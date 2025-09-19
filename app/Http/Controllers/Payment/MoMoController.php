<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MoMoPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MoMoController extends Controller
{
    protected $momoService;

    public function __construct(MoMoPaymentService $momoService)
    {
        $this->momoService = $momoService;
    }

    /**
     * Create MoMo payment
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function createPayment(Request $request)
    {
        try {
            // Enhanced validation
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
                'return_type' => 'nullable|string|in:json,redirect'
            ]);

            // Log request for debugging
            Log::info('MoMo Payment Request', [
                'order_id' => $validated['order_id'],
                'user_id' => auth()->id(),
                'return_type' => $validated['return_type'] ?? 'json'
            ]);

            $order = Order::with('user')->findOrFail($validated['order_id']);

            // Check if order belongs to authenticated user
            if ($order->user_id !== auth()->id()) {
                Log::warning('Unauthorized MoMo payment attempt', [
                    'order_id' => $order->id,
                    'order_user_id' => $order->user_id,
                    'auth_user_id' => auth()->id()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền thanh toán đơn hàng này.'
                ], 403);
            }

            // Check if order is already paid
            if ($order->status === 'completed' || $order->payment_status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Đơn hàng đã được thanh toán.'
                ], 400);
            }

            // Check minimum and maximum amount for MoMo
            $minAmount = config('services.momo.min_amount', 10000);
            $maxAmount = config('services.momo.max_amount', 50000000);
            
            if ($order->total_amount < $minAmount) {
                Log::warning('MoMo Payment Amount Too Low', [
                    'order_id' => $order->id,
                    'amount' => $order->total_amount,
                    'min_amount' => $minAmount
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => "Số tiền thanh toán ({$order->total_amount}₫) nhỏ hơn mức tối thiểu cho phép ({$minAmount}₫). Vui lòng chọn phương thức thanh toán khác."
                ], 400);
            }
            
            if ($order->total_amount > $maxAmount) {
                Log::warning('MoMo Payment Amount Too High', [
                    'order_id' => $order->id,
                    'amount' => $order->total_amount,
                    'max_amount' => $maxAmount
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => "Số tiền thanh toán ({$order->total_amount}₫) lớn hơn mức tối đa cho phép ({$maxAmount}₫). Vui lòng chọn phương thức thanh toán khác."
                ], 400);
            }

            // Prepare payment data
            $orderInfo = [
                'orderId' => $this->momoService->generateOrderId(),
                'requestId' => $this->momoService->generateRequestId(),
                'amount' => (int) $order->total_amount,
                'orderInfo' => "Thanh toán đơn hàng #{$order->id} - " . config('app.name')
            ];

            // Store MoMo order ID for tracking
            $order->update([
                'momo_order_id' => $orderInfo['orderId'],
                'momo_request_id' => $orderInfo['requestId']
            ]);

            // Create payment request
            $result = $this->momoService->createPayment($orderInfo);

            Log::info('MoMo Service Response', ['result' => $result]);

            if ($result['success']) {
                $payUrl = $result['data']['payUrl'] ?? null;
                
                if ($payUrl) {
                    // Always return JSON for API requests
                    return response()->json([
                        'success' => true,
                        'payUrl' => $payUrl,
                        'message' => 'Đã tạo liên kết thanh toán MoMo thành công.'
                    ]);
                } else {
                    Log::error('MoMo Payment URL Missing', ['result' => $result]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể tạo liên kết thanh toán MoMo.'
                    ], 500);
                }
            } else {
                Log::error('MoMo Payment Creation Failed', ['result' => $result]);
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Lỗi không xác định từ MoMo'
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('MoMo Payment Validation Error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('MoMo Payment Creation Error', [
                'message' => $e->getMessage(),
                'order_id' => $request->order_id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo thanh toán MoMo. Vui lòng thử lại.'
            ], 500);
        }
    }

    /**
     * Handle MoMo return callback (from user)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleReturn(Request $request)
    {
        try {
            $result = $this->momoService->processCallback($request->all());

            if ($result['success']) {
                // Find order by MoMo order ID
                $order = Order::where('momo_order_id', $result['orderId'])->first();

                if ($order) {
                    DB::transaction(function () use ($order, $result) {
                        // Update order status
                        $order->update([
                            'status' => 'completed',
                            'payment_method' => 'momo',
                            'payment_status' => 'paid',
                            'momo_trans_id' => $result['transId'],
                            'paid_at' => now()
                        ]);

                        Log::info('Order Payment Completed via MoMo', [
                            'order_id' => $order->id,
                            'momo_trans_id' => $result['transId'],
                            'amount' => $result['amount']
                        ]);
                    });

                    return redirect()->route('orders.show', $order->id)
                        ->with('success', 'Thanh toán thành công! Đơn hàng của bạn đã được xác nhận.');
                } else {
                    Log::warning('MoMo Order Not Found', ['orderId' => $result['orderId']]);
                    return redirect()->route('home')
                        ->with('error', 'Không tìm thấy đơn hàng tương ứng.');
                }
            } else {
                // Payment failed
                $order = Order::where('momo_order_id', $request->orderId)->first();
                
                if ($order) {
                    $order->update([
                        'payment_status' => 'failed',
                        'payment_notes' => $result['message']
                    ]);
                }

                return redirect()->route('checkout')
                    ->with('error', 'Thanh toán không thành công: ' . $result['message']);
            }

        } catch (\Exception $e) {
            Log::error('MoMo Return Callback Error', [
                'message' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return redirect()->route('checkout')
                ->with('error', 'Có lỗi xảy ra trong quá trình xử lý thanh toán.');
        }
    }

    /**
     * Handle MoMo IPN callback (from MoMo server)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleNotify(Request $request)
    {
        try {
            $result = $this->momoService->processCallback($request->all());

            if ($result['success']) {
                // Find order by MoMo order ID
                $order = Order::where('momo_order_id', $result['orderId'])->first();

                if ($order && $order->status !== 'completed') {
                    DB::transaction(function () use ($order, $result) {
                        // Update order status
                        $order->update([
                            'status' => 'completed',
                            'payment_method' => 'momo',
                            'payment_status' => 'paid',
                            'momo_trans_id' => $result['transId'],
                            'paid_at' => now()
                        ]);

                        Log::info('Order Payment Completed via MoMo IPN', [
                            'order_id' => $order->id,
                            'momo_trans_id' => $result['transId'],
                            'amount' => $result['amount']
                        ]);
                    });
                }

                // Return success response to MoMo
                return response()->json([
                    'status' => 'success',
                    'message' => 'OK'
                ]);
            } else {
                // Log failed payment
                Log::warning('MoMo IPN Payment Failed', [
                    'orderId' => $result['orderId'] ?? 'Unknown',
                    'message' => $result['message']
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => $result['message']
                ]);
            }

        } catch (\Exception $e) {
            Log::error('MoMo IPN Callback Error', [
                'message' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error'
            ]);
        }
    }

    /**
     * Check payment status
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatus(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id'
            ]);

            $order = Order::findOrFail($request->order_id);

            // Check if order belongs to authenticated user
            if ($order->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền kiểm tra đơn hàng này.'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'order_id' => $order->id,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'payment_method' => $order->payment_method,
                    'momo_trans_id' => $order->momo_trans_id,
                    'paid_at' => $order->paid_at
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('MoMo Status Check Error', [
                'message' => $e->getMessage(),
                'order_id' => $request->order_id ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi kiểm tra trạng thái thanh toán.'
            ]);
        }
    }
}
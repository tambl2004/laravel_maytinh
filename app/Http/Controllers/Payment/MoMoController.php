<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
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
                'return_type' => 'nullable|string|in:json,redirect'
            ]);

            // Get pending order data from session
            $pendingOrder = session()->get('pending_order');
            
            if (!$pendingOrder) {
                Log::warning('No pending order found in session', [
                    'user_id' => auth()->id()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy dữ liệu đơn hàng. Vui lòng thử lại từ đầu.'
                ], 400);
            }

            // Log request for debugging
            Log::info('MoMo Payment Request', [
                'pending_order' => $pendingOrder,
                'user_id' => auth()->id(),
                'return_type' => $validated['return_type'] ?? 'json'
            ]);

            // Check minimum and maximum amount for MoMo
            $minAmount = config('services.momo.min_amount', 1);
            $maxAmount = config('services.momo.max_amount', 50000000);
            
            if ($pendingOrder['total_amount'] < $minAmount) {
                Log::warning('MoMo Payment Amount Too Low', [
                    'amount' => $pendingOrder['total_amount'],
                    'min_amount' => $minAmount
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => "Số tiền thanh toán ({$pendingOrder['total_amount']}₫) nhỏ hơn mức tối thiểu cho phép ({$minAmount}₫). Vui lòng chọn phương thức thanh toán khác."
                ], 400);
            }
            
            if ($pendingOrder['total_amount'] > $maxAmount) {
                Log::warning('MoMo Payment Amount Too High', [
                    'amount' => $pendingOrder['total_amount'],
                    'max_amount' => $maxAmount
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => "Số tiền thanh toán ({$pendingOrder['total_amount']}₫) lớn hơn mức tối đa cho phép ({$maxAmount}₫). Vui lòng chọn phương thức thanh toán khác."
                ], 400);
            }

            // Prepare payment data
            $orderInfo = [
                'orderId' => $this->momoService->generateOrderId(),
                'requestId' => $this->momoService->generateRequestId(),
                'amount' => (int) $pendingOrder['total_amount'],
                'orderInfo' => "Thanh toán đơn hàng - " . config('app.name')
            ];

            // Store MoMo order ID in session for tracking
            session()->put('momo_order_info', [
                'momo_order_id' => $orderInfo['orderId'],
                'momo_request_id' => $orderInfo['requestId'],
                'pending_order' => $pendingOrder
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
            Log::info('MoMo Return Callback Started', [
                'request_data' => $request->all(),
                'session_data' => [
                    'pending_order' => session()->has('pending_order'),
                    'momo_order_info' => session()->has('momo_order_info'),
                    'selected_cart' => session()->has('selected_cart')
                ]
            ]);

            $result = $this->momoService->processCallback($request->all());

            Log::info('MoMo Service Process Result', ['result' => $result]);

            if ($result['success']) {
                // Get pending order data from session
                $momoOrderInfo = session()->get('momo_order_info');
                
                if (!$momoOrderInfo || $momoOrderInfo['momo_order_id'] !== $result['orderId']) {
                    Log::warning('MoMo Order Info Not Found in Session', [
                        'orderId' => $result['orderId'],
                        'session_data' => $momoOrderInfo
                    ]);
                    return redirect()->route('home')
                        ->with('error', 'Không tìm thấy thông tin đơn hàng. Vui lòng thử lại.');
                }

                $pendingOrder = $momoOrderInfo['pending_order'];

                // Create order in database
                Log::info('Creating order in database', [
                    'pending_order' => $pendingOrder,
                    'momo_result' => $result
                ]);

                $order = null;
                DB::transaction(function () use ($pendingOrder, $result, $momoOrderInfo, &$order) {
                    $order = Order::create([
                        'user_id' => $pendingOrder['user_id'],
                        'customer_name' => $pendingOrder['customer_name'],
                        'customer_email' => $pendingOrder['customer_email'],
                        'customer_phone' => $pendingOrder['customer_phone'],
                        'customer_address' => $pendingOrder['customer_address'],
                        'total_amount' => $pendingOrder['total_amount'],
                        'payment_method' => 'momo',
                        'payment_status' => 'paid',
                        'status' => 'processing', // Đang xử lý khi thanh toán thành công
                        'momo_order_id' => $result['orderId'],
                        'momo_request_id' => $momoOrderInfo['momo_request_id'],
                        'momo_trans_id' => $result['transId'],
                        'paid_at' => now()
                    ]);

                    Log::info('Order created successfully', [
                        'order_id' => $order->id,
                        'payment_method' => $order->payment_method,
                        'payment_status' => $order->payment_status
                    ]);

                    // Create order items
                    foreach ($pendingOrder['items'] as $id => $details) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $id,
                            'product_name' => $details['name'],
                            'quantity' => $details['quantity'],
                            'price' => $details['price'],
                        ]);
                    }

                    // Remove items from main cart
                    $mainCart = session()->get('cart', []);
                    foreach ($pendingOrder['items'] as $id => $details) {
                        if (isset($mainCart[$id])) {
                            unset($mainCart[$id]);
                        }
                    }
                    session()->put('cart', $mainCart);

                    Log::info('Order Payment Completed via MoMo', [
                        'order_id' => $order->id,
                        'momo_trans_id' => $result['transId'],
                        'amount' => $result['amount']
                    ]);
                });

                // Clear session data
                session()->forget(['pending_order', 'momo_order_info', 'selected_cart']);

                Log::info('MoMo Payment Success - Redirecting to home', [
                    'order_id' => $order ? $order->id : 'unknown',
                    'momo_trans_id' => $result['transId']
                ]);

                return redirect()->route('home')
                    ->with('success', 'Thanh toán MoMo thành công! Đơn hàng đã được xác nhận và đang chờ xử lý.');
            } else {
                // Payment failed - restore cart
                $momoOrderInfo = session()->get('momo_order_info');
                if ($momoOrderInfo) {
                    $pendingOrder = $momoOrderInfo['pending_order'];
                    
                    // Restore items to main cart
                    $mainCart = session()->get('cart', []);
                    foreach ($pendingOrder['items'] as $id => $details) {
                        $mainCart[$id] = $details;
                    }
                    session()->put('cart', $mainCart);
                    
                    // Restore selected cart
                    session()->put('selected_cart', $pendingOrder['items']);
                }

                // Clear session data
                session()->forget(['pending_order', 'momo_order_info']);

                return redirect()->route('home')
                    ->with('error', 'Thanh toán không thành công: ' . $result['message']);
            }

        } catch (\Exception $e) {
            Log::error('MoMo Return Callback Error', [
                'message' => $e->getMessage(),
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('home')
                ->with('error', 'Có lỗi xảy ra trong quá trình xử lý thanh toán: ' . $e->getMessage());
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
                        // Update order status - chỉ cập nhật payment info, không tự động hoàn thành
                        $order->update([
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
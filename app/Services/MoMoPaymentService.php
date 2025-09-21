<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoMoPaymentService
{
    private $endpoint;
    private $partnerCode;
    private $accessKey;
    private $secretKey;
    private $returnUrl;
    private $notifyUrl;

    public function __construct()
    {
        $this->endpoint = config('services.momo.endpoint');
        $this->partnerCode = config('services.momo.partner_code');
        $this->accessKey = config('services.momo.access_key');
        $this->secretKey = config('services.momo.secret_key');
        $this->returnUrl = config('services.momo.return_url');
        $this->notifyUrl = config('services.momo.notify_url');
        
        // Log configuration for debugging
        Log::info('MoMo Service Configuration', [
            'endpoint' => $this->endpoint,
            'partner_code' => $this->partnerCode ? 'SET' : 'NOT SET',
            'access_key' => $this->accessKey ? 'SET' : 'NOT SET',
            'secret_key' => $this->secretKey ? 'SET' : 'NOT SET',
            'return_url' => $this->returnUrl,
            'notify_url' => $this->notifyUrl
        ]);
        
        // Check if required config is missing
        if (!$this->endpoint || !$this->partnerCode || !$this->accessKey || !$this->secretKey) {
            Log::error('MoMo Configuration Missing', [
                'endpoint' => $this->endpoint,
                'partner_code' => $this->partnerCode,
                'access_key' => $this->accessKey,
                'secret_key' => $this->secretKey
            ]);
        }
    }

    /**
     * Create MoMo payment request
     *
     * @param array $orderInfo
     * @return array
     */
    public function createPayment(array $orderInfo)
    {
        try {
            $orderId = $orderInfo['orderId'];
            $requestId = $orderInfo['requestId'];
            $amount = $orderInfo['amount'];
            $orderInfoString = $orderInfo['orderInfo']; // Rename to avoid variable conflict
            $redirectUrl = $this->returnUrl;
            $ipnUrl = $this->notifyUrl;
            $extraData = "";
            // Sử dụng ATM nội địa (Napas) theo yêu cầu
            $requestType = "payWithATM";
            $autoCapture = true;
            $lang = 'vi';

            // Validate amount before sending to MoMo
            $minAmount = config('services.momo.min_amount', 1);
            $maxAmount = config('services.momo.max_amount', 50000000);
            
            if ($amount < $minAmount) {
                Log::warning('MoMo Amount Too Low', [
                    'orderId' => $orderId,
                    'amount' => $amount,
                    'minAmount' => $minAmount
                ]);
                
                return [
                    'success' => false,
                    'message' => "Số tiền giao dịch nhỏ hơn mức tối thiểu ({$minAmount}₫). Vui lòng chọn phương thức thanh toán khác."
                ];
            }
            
            if ($amount > $maxAmount) {
                Log::warning('MoMo Amount Too High', [
                    'orderId' => $orderId,
                    'amount' => $amount,
                    'maxAmount' => $maxAmount
                ]);
                
                return [
                    'success' => false,
                    'message' => "Số tiền giao dịch vượt quá mức tối đa ({$maxAmount}₫). Vui lòng chọn phương thức thanh toán khác."
                ];
            }

            // Create raw signature
            $rawHash = "accessKey=" . $this->accessKey 
                . "&amount=" . $amount 
                . "&extraData=" . $extraData 
                . "&ipnUrl=" . $ipnUrl 
                . "&orderId=" . $orderId 
                . "&orderInfo=" . $orderInfoString 
                . "&partnerCode=" . $this->partnerCode 
                . "&redirectUrl=" . $redirectUrl 
                . "&requestId=" . $requestId 
                . "&requestType=" . $requestType;

            $signature = hash_hmac("sha256", $rawHash, $this->secretKey);

            $data = [
                'partnerCode' => $this->partnerCode,
                'requestId' => $requestId,
                'amount' => (int) $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfoString,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'requestType' => $requestType,
                'extraData' => $extraData,
                'lang' => $lang,
                'signature' => $signature
            ];

            // Log the data being sent to MoMo
            Log::info('MoMo Payment Request Data', [
                'orderId' => $orderId,
                'amount' => $amount,
                'endpoint' => $this->endpoint,
                'rawHash' => $rawHash,
                'data' => array_merge($data, ['signature' => substr($signature, 0, 10) . '...'])
            ]);

            $response = Http::timeout(60)
                ->connectTimeout(30)
                ->retry(2, 1000)
                ->withOptions([
                    'verify' => config('services.momo.ssl_verify', true),
                    'http_errors' => false
                ])
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->post($this->endpoint, $data);

            if ($response->successful()) {
                $result = $response->json();
                
                Log::info('MoMo Payment Request Success', [
                    'orderId' => $orderId,
                    'response' => $result
                ]);

                // Check if MoMo returned an error in the response
                if (isset($result['resultCode']) && $result['resultCode'] != 0) {
                    Log::error('MoMo API Error', [
                        'orderId' => $orderId,
                        'resultCode' => $result['resultCode'],
                        'message' => $result['message'] ?? 'Unknown error'
                    ]);
                    
                    return [
                        'success' => false,
                        'message' => $result['message'] ?? 'Lỗi từ MoMo: ' . $result['resultCode']
                    ];
                }

                return [
                    'success' => true,
                    'data' => $result
                ];
            } else {
                $responseBody = $response->body();
                Log::error('MoMo Payment Request Failed', [
                    'orderId' => $orderId,
                    'status' => $response->status(),
                    'response' => $responseBody,
                    'headers' => $response->headers()
                ]);

                // Try to parse error response
                $errorMessage = 'Không thể kết nối với MoMo. Vui lòng thử lại.';
                try {
                    $errorData = $response->json();
                    if (isset($errorData['message'])) {
                        $errorMessage = $errorData['message'];
                    }
                } catch (\Exception $e) {
                    // Response is not JSON, use default message
                }

                return [
                    'success' => false,
                    'message' => $errorMessage
                ];
            }

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('MoMo Connection Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Không thể kết nối với MoMo. Kiểm tra kết nối mạng.'
            ];
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('MoMo Request Exception', [
                'message' => $e->getMessage(),
                'response' => $e->response ? $e->response->body() : 'No response',
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Lỗi yêu cầu đến MoMo: ' . $e->getMessage()
            ];
        } catch (\Exception $e) {
            Log::error('MoMo Payment Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xử lý thanh toán. Vui lòng thử lại.'
            ];
        }
    }

    /**
     * Verify MoMo callback signature
     *
     * @param array $data
     * @return bool
     */
    public function verifySignature(array $data)
    {
        try {
            $rawHash = "accessKey=" . $this->accessKey 
                . "&amount=" . $data['amount'] 
                . "&extraData=" . $data['extraData'] 
                . "&message=" . $data['message'] 
                . "&orderId=" . $data['orderId'] 
                . "&orderInfo=" . $data['orderInfo'] 
                . "&orderType=" . $data['orderType'] 
                . "&partnerCode=" . $data['partnerCode'] 
                . "&payType=" . $data['payType'] 
                . "&requestId=" . $data['requestId'] 
                . "&responseTime=" . $data['responseTime'] 
                . "&resultCode=" . $data['resultCode'] 
                . "&transId=" . $data['transId'];

            $signature = hash_hmac("sha256", $rawHash, $this->secretKey);

            return $signature === $data['signature'];

        } catch (\Exception $e) {
            Log::error('MoMo Signature Verification Failed', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);
            return false;
        }
    }

    /**
     * Process MoMo payment callback
     *
     * @param array $data
     * @return array
     */
    public function processCallback(array $data)
    {
        try {
            // Verify signature first
            if (!$this->verifySignature($data)) {
                Log::warning('MoMo Invalid Signature', ['data' => $data]);
                return [
                    'success' => false,
                    'message' => 'Chữ ký không hợp lệ'
                ];
            }

            // Check payment status
            if ($data['resultCode'] == 0) {
                // Payment successful
                Log::info('MoMo Payment Success', [
                    'orderId' => $data['orderId'],
                    'transId' => $data['transId'],
                    'amount' => $data['amount']
                ]);

                return [
                    'success' => true,
                    'orderId' => $data['orderId'],
                    'transId' => $data['transId'],
                    'amount' => $data['amount'],
                    'message' => $data['message']
                ];
            } else {
                // Payment failed
                Log::warning('MoMo Payment Failed', [
                    'orderId' => $data['orderId'],
                    'resultCode' => $data['resultCode'],
                    'message' => $data['message']
                ]);

                return [
                    'success' => false,
                    'orderId' => $data['orderId'],
                    'resultCode' => $data['resultCode'],
                    'message' => $data['message']
                ];
            }

        } catch (\Exception $e) {
            Log::error('MoMo Callback Processing Error', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);

            return [
                'success' => false,
                'message' => 'Lỗi xử lý callback từ MoMo'
            ];
        }
    }

    /**
     * Generate unique order ID
     *
     * @return string
     */
    public function generateOrderId()
    {
        return 'ORDER_' . time() . '_' . rand(1000, 9999);
    }

    /**
     * Generate unique request ID
     *
     * @return string
     */
    public function generateRequestId()
    {
        return 'REQ_' . time() . '_' . rand(1000, 9999);
    }
}
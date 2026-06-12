<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JayapayService
{
    private const PAYIN_SUCCESS_STATUSES = ['SUCCESS'];
    private const PAYIN_FAILED_STATUSES = ['PAY_CANCEL', 'PAY_ERROR'];

    private ?string $merchantCode;
    private ?string $notifyUrl;
    private string $apiUrl;
    private string $queryUrl;
    private string $privateKeyPath;
    private string $publicKeyPath;
    private string $caBundlePath;

    public function __construct()
    {
        $this->merchantCode = config('jayapay.merchant_code');
        $this->notifyUrl = config('jayapay.notify_url');
        $this->apiUrl = config('jayapay.api_url', 'https://global-id-openapi.toppayment.com/id/pay/prePay');
        $this->queryUrl = config('jayapay.query_url', 'https://global-id-openapi.toppayment.com/id/pay/query');
        $this->privateKeyPath = base_path(config('jayapay.private_key_path', 'storage/app/toppayment_private.pem'));
        $this->publicKeyPath = base_path(config('jayapay.public_key_path', 'storage/app/toppayment_public.pem'));
        $this->caBundlePath = base_path(config('jayapay.ca_bundle_path', 'storage/app/cacert.pem'));
    }

    public function createOrder(array $data): array
    {
        try {
            $payload = [
                'mchNo' => $this->merchantCode,
                'orderNum' => $data['orderNum'],
                'amount' => (int) $data['amount'],
                'productDetail' => $data['productDetail'],
                'method' => $data['method'] ?? 'QRIS',
                'timestamp' => (string) now()->valueOf(),
                'customerName' => $data['name'] ?? 'Customer',
                'customerEmail' => $data['email'] ?? 'customer@example.com',
                'customerPhone' => $data['phone'] ?? '0000000000',
                'expiryPeriod' => $data['expiryPeriod'] ?? 1440,
                'downNotifyUrl' => $data['notifyUrl'] ?? $this->notifyUrl,
                'redirectUrl' => $data['returnUrl'] ?? url('/account/deposit'),
                'notifyVersion' => $data['notifyVersion'] ?? 'v2',
            ];

            $payload['sign'] = $this->generateSign($payload);

            Log::info('TopPayment create payload prepared', [
                'orderNum' => $payload['orderNum'] ?? null,
                'amount' => $payload['amount'] ?? null,
                'method' => $payload['method'] ?? null,
                'has_sign' => filled($payload['sign'] ?? null),
            ]);

            $response = $this->http()
                ->timeout(30)
                ->post($this->apiUrl, $payload);

            $body = $response->json() ?: [];

            if ($response->failed()) {
                Log::error('TopPayment create failed', [
                    'status' => $response->status(),
                    'response_keys' => is_array($body) ? array_keys($body) : [],
                ]);

                return ['success' => false, 'message' => 'Gagal mengirim request ke TopPayment', 'response' => $body];
            }

            $payData = data_get($body, 'data.payData');
            $payDataType = strtoupper((string) data_get($body, 'data.payDataType'));
            $paymentUrl = data_get($body, 'data.cashierUrl') ?? $body['url'] ?? $body['payUrl'] ?? null;

            if (!$paymentUrl && in_array($payDataType, ['QR_URL', 'CASHIER_URL'], true)) {
                $paymentUrl = $payData;
            }

            return [
                'success' => ($body['success'] ?? false) === true || (string) ($body['code'] ?? '') === '9999',
                'url' => $paymentUrl,
                'qris_url' => $paymentUrl,
                'qris_code' => $payDataType === 'QR_CODE' ? $payData : null,
                'pay_data' => $payData,
                'pay_data_type' => $payDataType ?: null,
                'platform_order_num' => data_get($body, 'data.platOrderNum'),
                'message' => $body['msg'] ?? $body['platRespMessage'] ?? $body['message'] ?? null,
                'response' => $body,
            ];
        } catch (\Throwable $e) {
            Log::error('TopPayment create exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function queryOrder(string $orderNum): array
    {
        try {
            $payload = [
                'mchNo' => $this->merchantCode,
                'orderNum' => $orderNum,
                'timestamp' => (string) now()->valueOf(),
            ];
            $payload['sign'] = $this->generateSign($payload);

            $response = $this->http()
                ->timeout(30)
                ->post($this->queryUrl, $payload);

            $body = $response->json() ?: [];

            if ($response->failed()) {
                Log::warning('TopPayment query failed', [
                    'orderNum' => $orderNum,
                    'status' => $response->status(),
                    'response_keys' => is_array($body) ? array_keys($body) : [],
                ]);

                return ['success' => false, 'paid' => false, 'message' => 'Query gagal', 'response' => $body];
            }

            $apiSuccess = ($body['success'] ?? false) === true || (string) ($body['code'] ?? '') === '9999';
            $status = strtoupper((string) (data_get($body, 'data.status') ?? $body['status'] ?? ''));
            $paid = $apiSuccess && in_array($status, self::PAYIN_SUCCESS_STATUSES, true);
            $failed = $apiSuccess && in_array($status, self::PAYIN_FAILED_STATUSES, true);

            return [
                'success' => $apiSuccess,
                'paid' => $paid,
                'failed' => $failed,
                'status' => $status,
                'message' => $body['msg'] ?? $body['platRespMessage'] ?? $body['message'] ?? null,
                'response' => $body,
            ];
        } catch (\Throwable $e) {
            Log::error('TopPayment query exception', ['orderNum' => $orderNum, 'error' => $e->getMessage()]);
            return ['success' => false, 'paid' => false, 'message' => $e->getMessage()];
        }
    }

    private function generateSign(array $data): string
    {
        $stringToSign = $this->stringToSign($data);

        if (!file_exists($this->privateKeyPath)) {
            Log::error('TopPayment private key missing', ['path' => $this->privateKeyPath]);
            return '';
        }

        $privateKey = openssl_pkey_get_private(file_get_contents($this->privateKeyPath));
        if (!$privateKey) {
            Log::error('TopPayment private key invalid', ['error' => openssl_error_string()]);
            return '';
        }

        $details = openssl_pkey_get_details($privateKey);
        $blockSize = (int) (($details['bits'] / 8) - 11);
        $encrypted = '';

        foreach (str_split($stringToSign, $blockSize) as $chunk) {
            $partial = '';
            if (!openssl_private_encrypt($chunk, $partial, $privateKey, OPENSSL_PKCS1_PADDING)) {
                Log::error('TopPayment sign encrypt failed', ['error' => openssl_error_string()]);
                return '';
            }
            $encrypted .= $partial;
        }

        return base64_encode($encrypted);
    }

    private function http()
    {
        $client = Http::asJson();

        if (file_exists($this->caBundlePath)) {
            $client = $client->withOptions(['verify' => $this->caBundlePath]);
        }

        return $client;
    }

    public function verifyCallback(array $data): bool
    {
        if (empty($data['sign'])) {
            return false;
        }

        $sign = base64_decode((string) $data['sign'], true);
        unset($data['sign']);
        ksort($data);
        $stringToVerify = $this->stringToSign($data);

        if (!$sign || !file_exists($this->publicKeyPath)) {
            Log::error('TopPayment callback public key/sign missing', ['path' => $this->publicKeyPath]);
            return false;
        }

        $publicKey = openssl_pkey_get_public(file_get_contents($this->publicKeyPath));
        if (!$publicKey) {
            Log::error('TopPayment public key invalid', ['error' => openssl_error_string()]);
            return false;
        }

        $details = openssl_pkey_get_details($publicKey);
        $blockSize = (int) ($details['bits'] / 8);
        $decrypted = '';

        foreach (str_split($sign, $blockSize) as $chunk) {
            $partial = '';
            if (!openssl_public_decrypt($chunk, $partial, $publicKey, OPENSSL_PKCS1_PADDING)) {
                Log::error('TopPayment callback decrypt failed', ['error' => openssl_error_string()]);
                return false;
            }
            $decrypted .= $partial;
        }

        return hash_equals($stringToVerify, $decrypted);
    }

    private function stringToSign(array $data): string
    {
        unset($data['sign']);
        ksort($data, SORT_STRING);

        $string = '';
        foreach ($data as $value) {
            if ($value !== null && $value !== '') {
                $string .= is_bool($value) ? ($value ? 'true' : 'false') : (string) $value;
            }
        }

        return $string;
    }
}

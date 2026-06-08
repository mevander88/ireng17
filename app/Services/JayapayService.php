<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JayapayService
{
    private $merchantCode;
    private $notifyUrl;
    private $apiUrl;
    private $privateKeyPath;
    private $publicKeyPath;

    public function __construct()
    {
        $this->merchantCode   = config('jayapay.merchant_code');
        $this->notifyUrl      = config('jayapay.notify_url');
        $this->apiUrl         = config('jayapay.api_url', 'https://partner.hetracks.com/gateway/prepaidOrder');
        $this->privateKeyPath = base_path(config('jayapay.private_key_path', 'storage/app/private_pkcs8.pem'));
        $this->publicKeyPath  = base_path(config('jayapay.public_key_path', 'storage/app/jayapay_public.pem'));
    }

    /**
     * 🧾 Buat transaksi Jayapay (Cashier Mode JSON)
     */
    public function createOrder(array $data): array
    {
        try {
            $payload = [
                'merchantCode'  => $this->merchantCode,
                'orderType'     => '0', // default cashier mode
                'method'        => $data['method'] ?? 'QRIS',
                'orderNum'      => $data['orderNum'],
                'payMoney'      => (int) $data['amount'],
                'productDetail' => $data['productDetail'],
                'notifyUrl'     => $this->notifyUrl,
                'dateTime'      => now()->format('YmdHis'),
                'expiryPeriod'  => 1440,
                'name'          => $data['name'] ?? 'Customer',
                'email'         => $data['email'] ?? 'customer@example.com',
                'phone'         => $data['phone'] ?? '0000000000',
            ];

            // 🔏 Generate signature
            $payload['sign'] = $this->generateSign($payload);

            Log::info('📤 Request Jayapay (payload)', $payload);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])
                ->timeout(30)
                ->post($this->apiUrl, $payload);

            $body = $response->json();

            if ($response->failed()) {
                Log::error('⚠️ Gagal kirim ke Jayapay', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return [
                    'success' => false,
                    'message' => 'Gagal mengirim request ke Jayapay',
                    'response' => $body,
                ];
            }

            Log::info('📥 Response Jayapay', $body);

            // 🟩 Tambahkan handle untuk url/payUrl
            return [
                'success'  => ($body['platRespCode'] ?? '') === 'SUCCESS',
                'url'      => $body['url'] ?? $body['payUrl'] ?? null,
                'message'  => $body['platRespMessage'] ?? null,
                'response' => $body,
            ];

        } catch (\Exception $e) {
            Log::error('❌ Exception Jayapay', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * 🔐 Generate signature RSA “privateEncrypt” (sesuai util Java Jayapay)
     */
    private function generateSign(array $data): string
    {
        // Urutkan seperti Collections.sort di Java
        ksort($data);
        $stringToSign = implode('', $data);

        if (!file_exists($this->privateKeyPath)) {
            Log::error('❌ Private key tidak ditemukan', ['path' => $this->privateKeyPath]);
            return '';
        }

        $privateKeyContent = file_get_contents($this->privateKeyPath);
        $privateKey = openssl_pkey_get_private($privateKeyContent);

        if (!$privateKey) {
            Log::error('❌ Gagal load private key', ['error' => openssl_error_string()]);
            return '';
        }

        // Enkripsi gaya Java privateEncrypt
        $dataBytes = mb_convert_encoding($stringToSign, 'UTF-8');
        $keyDetails = openssl_pkey_get_details($privateKey);
        $blockSize = $keyDetails['bits'] / 8 - 11; // 117 untuk 1024-bit
        $chunks = str_split($dataBytes, $blockSize);

        $encrypted = '';
        foreach ($chunks as $chunk) {
            $partial = '';
            if (!openssl_private_encrypt($chunk, $partial, $privateKey, OPENSSL_PKCS1_PADDING)) {
                Log::error('❌ Gagal encrypt sebagian data', ['error' => openssl_error_string()]);
                return '';
            }
            $encrypted .= $partial;
        }

        openssl_free_key($privateKey);
        return base64_encode($encrypted);
    }

    /**
     * ✅ Verifikasi callback dari Jayapay
     */
    public function verifyCallback(array $data): bool
    {
        if (!isset($data['sign'])) {
            return false;
        }

        $sign = base64_decode($data['sign']);
        unset($data['sign']);

        $fields = [
            'merchantCode', 'orderType', 'method', 'orderNum',
            'payMoney', 'productDetail', 'notifyUrl', 'dateTime',
            'expiryPeriod', 'name', 'email', 'phone'
        ];

        $stringToVerify = '';
        foreach ($fields as $f) {
            $stringToVerify .= $data[$f] ?? '';
        }

        if (!file_exists($this->publicKeyPath)) {
            Log::error('❌ Public key tidak ditemukan', ['path' => $this->publicKeyPath]);
            return false;
        }

        $publicKeyContent = file_get_contents($this->publicKeyPath);
        $publicKey = openssl_pkey_get_public($publicKeyContent);

        if (!$publicKey) {
            Log::error('❌ Gagal load public key', ['error' => openssl_error_string()]);
            return false;
        }

        $isValid = openssl_verify($stringToVerify, $sign, $publicKey, OPENSSL_ALGO_SHA256);
        openssl_free_key($publicKey);

        return $isValid === 1;
    }
}

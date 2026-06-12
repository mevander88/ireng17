<?php

namespace App\Http\Api;

use App\Models\Api;
use Illuminate\Support\Facades\Log;

class fiver
{
    public $agen;
    public $token;
    public $url;

    public function __construct()
    {
        $api = Api::first();
        $this->agen = $api?->nx_agent_code ?: (string) config('services.ggr.agent_code', '');
        $this->token = $api?->nx_token ?: (string) config('services.ggr.agent_token', '');
        $this->url = trim((string) ($api?->nx_endpoint ?: config('services.ggr.api_url', '')));
    }

    /**
     * Bersihkan nominal sebelum dikirim ke API
     */
    private function cleanAmount($amount)
    {
        // Hapus semua karakter kecuali angka dan titik
        $cleaned = preg_replace('/[^\d.]/', '', $amount);
        return floatval($cleaned);
    }

    public function create($username)
    {
        $param = [
            'method' => 'user_create',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'user_code' => $username,
        ];
        return $this->sg_connect($this->url, $param);
    }

    public function userbalance($username)
    {
        $param = [
            'method' => 'money_info',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'user_code' => $username,
        ];
        return $this->sg_connect($this->url, $param);
    }

    public function agentbalance()
    {
        $param = [
            'method' => 'money_info',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
        ];
        return $this->sg_connect($this->url, $param);
    }

    public function deposit($username, $amount, ?string $agentSign = null)
    {
        // ⬇️ Tambahkan sanitizer di sini
        $amount = $this->cleanAmount($amount);

        $param = [
            'method' => 'user_deposit',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'user_code' => $username,
            'amount' => $amount,
        ];

        if ($agentSign) {
            $param['agent_sign'] = $agentSign;
        }

        return $this->sg_connect($this->url, $param);
    }

    public function withdraw($username, $amount, ?string $agentSign = null)
    {
        // ⬇️ Tambahkan sanitizer di sini juga
        $amount = $this->cleanAmount($amount);

        $param = [
            'method' => 'user_withdraw',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'user_code' => $username,
            'amount' => $amount,
        ];

        if ($agentSign) {
            $param['agent_sign'] = $agentSign;
        }

        return $this->sg_connect($this->url, $param);
    }

    public function transferStatus($username, string $agentSign)
    {
        $param = [
            'method' => 'transfer_status',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'user_code' => $username,
            'agent_sign' => $agentSign,
        ];

        return $this->sg_connect($this->url, $param);
    }

    public function resetBalance()
    {
        $param = [
            'method' => 'user_withdraw_reset',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'all_users' => true,
        ];
        return $this->sg_connect($this->url, $param);
    }

    public function gamelist($provider)
    {
        $param = [
            'method' => 'game_list',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'provider_code' => $provider,
        ];
        return $this->sg_connect($this->url, $param);
    }

    public function providerlist()
    {
        $param = [
            'method' => 'provider_list',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
        ];
        return $this->sg_connect($this->url, $param);
    }

    public function callPlayer()
    {
        $param = [
            'method' => 'call_players',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
        ];
        return $this->sg_connect($this->url, $param);
    }

    public function callList($provider, $gamecode, $username = null)
    {
        $param = [
            'method' => 'call_list',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'provider_code' => $provider,
            'game_code' => $gamecode,
        ];
        return $this->sg_connect($this->url, $param);
    }

    public function callApply($provider, $gamecode, $username, $rtp, $type)
    {
        $param = [
            'method' => 'call_apply',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'provider_code' => $provider,
            'game_code' => $gamecode,
            'user_code' => $username,
            'call_rtp' => $rtp,
            'call_type' => $type,
        ];
        return $this->sg_connect($this->url, $param);
    }

    public function callCancel($callId)
    {
        $param = [
            'method' => 'call_cancel',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'call_id' => (int) $callId,
        ];

        return $this->sg_connect($this->url, $param);
    }

    public function callHistory(int $offset = 0, int $limit = 100)
    {
        $param = [
            'method' => 'call_history',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'offset' => max(0, $offset),
            'limit' => max(1, min(500, $limit)),
        ];

        return $this->sg_connect($this->url, $param);
    }

    public function controlRtp($provider, $username, $rtp)
    {
        $param = [
            'method' => 'control_rtp',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'provider_code' => $provider,
            'user_code' => $username,
            'rtp' => (int) $rtp,
        ];

        return $this->sg_connect($this->url, $param);
    }

    public function controlUsersRtp(array $userCodes, $rtp)
    {
        $param = [
            'method' => 'control_users_rtp',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'user_codes' => json_encode(array_values($userCodes)),
            'rtp' => (int) $rtp,
        ];

        return $this->sg_connect($this->url, $param);
    }

    public function opengame($username, $gamecode, $game_provider, $lang = 'id')
    {
        $param = [
            'method' => 'game_launch',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'user_code' => $username,
            'game_code' => $gamecode,
            'provider_code' => $game_provider,
            'lang' => $lang,
        ];
        return $this->sg_connect($this->url, $param);
    }

    public function historyPlay($username, $type, $start, $end, $page, $perpage)
    {
        $param = [
            'method' => 'get_game_log',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'user_code' => $username,
            'game_type' => $type,
            'start' => $start,
            'end' => $end,
            'page' => $page,
            'perPage' => $perpage,
        ];
        return $this->sg_connect($this->url, $param);
    }

    private function sg_connect($url, $postArray)
    {
        if (trim((string) $url) === '') {
            return json_encode([
                'status' => 0,
                'msg' => 'Provider API endpoint belum diset. Isi API Endpoint dari halaman GGR /app/profile.',
            ]);
        }

        if (trim((string) $this->agen) === '' || trim((string) $this->token) === '') {
            return json_encode([
                'status' => 0,
                'msg' => 'Provider API agent code/token belum diset.',
            ]);
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return json_encode([
                'status' => 0,
                'msg' => 'Provider API endpoint tidak valid. Gunakan URL lengkap dari halaman GGR /app/profile.',
            ]);
        }

        $jsonData = json_encode($postArray);
        $headerArray = ['Content-Type: application/json'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, (bool) config('services.provider_ssl_verify', true));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $res = curl_exec($ch);
        $curlError = curl_error($ch);
        $curlErrno = curl_errno($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($res === false || $curlErrno !== 0) {
            Log::warning('Provider API curl failed', [
                'url' => $url,
                'method' => $postArray['method'] ?? null,
                'curl_errno' => $curlErrno,
                'curl_error' => $curlError,
            ]);

            return json_encode([
                'status' => 0,
                'msg' => 'Provider API gagal: ' . ($curlError ?: 'curl error ' . $curlErrno),
                'curl_errno' => $curlErrno,
            ]);
        }

        if ($httpCode >= 400 || trim((string) $res) === '') {
            Log::warning('Provider API returned unusable response', [
                'url' => $url,
                'method' => $postArray['method'] ?? null,
                'http_code' => $httpCode,
                'response_preview' => substr((string) $res, 0, 500),
            ]);

            return json_encode([
                'status' => 0,
                'msg' => $httpCode >= 400
                    ? 'Provider API gagal HTTP ' . $httpCode
                    : 'Provider API tidak mengembalikan response.',
                'http_code' => $httpCode,
            ]);
        }

        return $res;
    }
}

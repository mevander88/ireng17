<?php

namespace App\Http\Api;

use App\Models\Api;

class fiver
{
    public $agen;
    public $token;
    public $url;

    public function __construct()
    {
        $api = Api::first();
        $this->agen = $api->nx_agent_code;
        $this->token = $api->nx_token;
        $this->url  = $api->nx_endpoint;
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

    public function deposit($username, $amount)
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
        return $this->sg_connect($this->url, $param);
    }

    public function withdraw($username, $amount)
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

    public function callList($provider, $gamecode, $username)
    {
        $param = [
            'method' => 'call_list',
            'agent_code' => $this->agen,
            'agent_token' => $this->token,
            'provider_code' => $provider,
            'game_code' => $gamecode,
            'user_code' => $username,
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
        $jsonData = json_encode($postArray);
        $headerArray = ['Content-Type: application/json'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
}

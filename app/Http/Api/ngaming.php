<?php

namespace App\Http\Api;



class ngaming
{
    public $agen    =   "NG-B9N5LS";
    public $signature = "584fa293b55fff727e8080";
    public $url = "https://api.ngaming.xyz?cmd=";


    public function create($username)
    {
        $cmd   =   "create_member";
        $action = $this->url . $cmd . "?user_agent=" . $this->agen . "&user_member=$username" . "&signature=" . $this->signature;
        return $this->sg_connect($action);
    }

    public function userbalance($username)
    {
        $cmd   =   "GetBalance.aspx";
        $action = $this->url . $cmd . "?agent_code=" . $this->agen . "&username=$username" . "&signature=" . $this->signature;
        return $this->sg_connect($action);
    }
    public function agentbalance()
    {
        $cmd   =   "AgentInfo.ashx";
        $action = $this->url . $cmd . "?agent_code=" . $this->agen  . "&signature=" . $this->signature;
        return $this->sg_connect($action);
    }

    public function gamelist($provider)
    {
        $cmd   =   "GetGameList.aspx";
        $action = $this->url . $cmd . "?agent_code=" . $this->agen . "&provider_code=$provider" . "&signature=" . $this->signature;
        return $this->sg_connect($action);
    }

    public function provider()
    {
        $cmd   =   "GetProviderList.aspx";
        $action = $this->url . $cmd . "?agent_code=" . $this->agen . "&signature=" . $this->signature;
        return $this->sg_connect($action);
    }

    public function transaksi($username, $type, $amount)
    {
        $cmd   =   "MakeTransaction.ashx";
        $action = $this->url . $cmd . "?agent_code=" . $this->agen . "&username=$username" . "&type=$type" . "&amount=$amount" . "&signature=" . $this->signature;
        return $this->sg_connect($action);
    }

    public function opengame($username, $gamecode)
    {
        $cmd   =   "OpenGame.aspx";
        $action = $this->url . $cmd . "?agent_code=" . $this->agen . "&username=$username" . "&gameid=$gamecode" . "&signature=" . $this->signature;
        return $this->sg_connect($action);
    }

    public function historyBetting()
    {
        $cmd   =   "GetHistoryArchive.aspx";
        $action = $this->url . $cmd . "?agent_code=" . $this->agen .  "&signature=" . $this->signature;
        return $this->sg_connect($action);
    }

    private function sg_connect($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.47 Safari/537.36');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, (bool) config('services.provider_ssl_verify', true));
        $res  =  curl_exec($ch);
        curl_close($ch);

        return $res;
    }
}

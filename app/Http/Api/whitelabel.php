<?php

namespace App\Http\API;



class whitelabel
{
    public $agen    =   "sektor7";
    public $token   =   "97f993bbca8bbed707d6daf1b95e4e1c";
    public $endpoint = 'https://api.nexusggr.com';

    private function sg_connect($url, $data)
    {
        $ch         =   curl_init($url);
        $payload    =   json_encode($data);
        $headerArray = ['Content-Type: application/json'];

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER,  true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $res  =  curl_exec($ch);
        curl_close($ch);

        return $res;
    }


    public function create($username)
    {
        $url_create_user     =   " https://api.nexusggr.com";
        $action = array(
            'agent_code'    =>  $this->agen,
            'agent_token'   =>  $this->token,
            'user_code'     => $username
        );
        return $this->sg_connect($url_create_user, $action);
    }

    public function getAgentBalance()
    {
        $url_Agent     =   "https://api.worldslotgame.com/api/v2/info";
        $action = array(
            'agent_code'    => $this->agen,
            'agent_token'   => $this->token,
        );
        return $this->sg_connect($url_Agent, $action);
    }

    public function getbalance($username)
    {
        $url_info     =   "https://api.worldslotgame.com/api/v2/info";
        $action = array(
            'agent_code'    => $this->agen,
            'agent_token'   => $this->token,
            'user_code'     => $username
        );
        return $this->sg_connect($url_info, $action);
    }

    public function opengame($username, $provider, $game_code)
    {
        $url_opengame    =   "https://api.worldslotgame.com/api/v2/game_launch";
        $action = array(
            'agent_code'    =>  $this->agen,
            'agent_token'   =>  $this->token,
            'user_code'     =>  $username,
            'provider_code' =>  $provider,
            'game_code'     =>  $game_code,
            "lang"          =>  "en"
        );
        return $this->sg_connect($url_opengame, $action);
    }

    public function providerList($type)
    {
        $url_provider    =   "https://api.worldslotgame.com/api/v2/provider_list";
        $action = array(
            'agent_code'    =>  $this->agen,
            'agent_token'   =>  $this->token,
            'game_type' => $type
        );
        return $this->sg_connect($url_provider, $action);
    }


    public function gameList($provider)
    {

        $url_gamelist    =   "https://api.worldslotgame.com/api/v2/game_list";
        $action = array(
            'agent_code'    =>  $this->agen,
            'agent_token'   =>  $this->token,
            'provider_code'  => $provider,
        );
        return $this->sg_connect($url_gamelist, $action);
    }

    public function getuser()
    {
        $url_User     =   "https://api.worldslotgame.com/api/v2/info";
        $action = array(
            'agent_code'    => $this->agen,
            'agent_token'   => $this->token,
        );
        return $this->sg_connect($url_User, $action);
    }

    public function deposite($username, $amount)
    {
        $url_Deposite     =   "https://api.worldslotgame.com/api/v2/user_deposit";
        $action = array(
            'agent_code'    =>  $this->agen,
            'agent_token'   =>  $this->token,
            'user_code'     =>  $username,
            'amount'        =>  $amount + 0
        );
        return $this->sg_connect($url_Deposite, $action);
    }

    public function withdraw($username, $amount)
    {
        $url_Withdraw     =   "https://api.worldslotgame.com/api/v2/user_withdraw";
        $action = array(
            'agent_code'    =>  $this->agen,
            'agent_token'   =>  $this->token,
            'user_code'     =>  $username,
            'amount'        =>  $amount + 0
        );
        return $this->sg_connect($url_Withdraw, $action);
    }

    // public function getbalanceAgent($username)
    // {
    //     $action = array(
    //         'method'        => 'money_info',
    //         'agent_code'    => $this->agen,
    //         'agent_token'   => $this->token,
    //         'user_code'     => $username
    //     );
    //     return $this->sg_connect($this->url, $action);
    // }



    // public function getHistory($username, $game_type, $start_date, $end_date)
    // {
    //     $action = array(
    //         'method'        =>  'get_game_log',
    //         'agent_code'    =>  $this->agen,
    //         'agent_token'   =>  $this->token,
    //         'user_code'     =>  $username,
    //         'game_type'     =>  $game_type,
    //         "start"         =>  $start_date,
    //         "end"           =>  $end_date,
    //         "page"          =>  0,
    //         "perPage"       =>  1000
    //     );
    //     return $this->sg_connect($this->url, $action);
    // }



    // public function resetBalance($username)
    // {
    //     $action = array(
    //         'method'        =>  'user_withdraw_reset',
    //         'agent_code'    =>  $this->agen,
    //         'agent_token'   =>  $this->token,
    //         'user_code'     =>  $username
    //     );
    //     return $this->sg_connect($this->url, $action);
    // }

    // public function callPlayers()
    // {
    //     $action = array(
    //         'method'        =>  'call_players',
    //         'agent_code'    =>  $this->agen,
    //         'agent_token'   =>  $this->token
    //     );
    //     return $this->sg_connect($this->url, $action);
    // }

    // public function callList()
    // {
    //     $action = array(
    //         'method'        =>  'call_list',
    //         'agent_code'    =>  $this->agen,
    //         'agent_token'   =>  $this->token
    //     );
    //     return $this->sg_connect($this->url, $action);
    // }

    // public function callApply($username, $game_code, $provider, $call_rtp, $call_type)
    // {
    //     $action = array(
    //         'method'        =>  'call_apply',
    //         'agent_code'    =>  $this->agen,
    //         'agent_token'   =>  $this->token,
    //         'provider_code' =>  $provider,
    //         'game_code'     =>  $game_code,
    //         'user_code'     =>  $username,
    //         'call_rtp'      =>  $call_rtp,
    //         'call_type'     =>  $call_type
    //     );
    //     return $this->sg_connect($this->url, $action);
    // }

    // public function getCallHistory()
    // {
    //     $action = array(
    //         'method'        =>  'call_history',
    //         'agent_code'    =>  $this->agen,
    //         'agent_token'   =>  $this->token,
    //         'offset'        =>  0,
    //         'limit'         =>  100
    //     );
    //     return $this->sg_connect($this->url, $action);
    // }

    // public function callCancel($call_id)
    // {
    //     $action = array(
    //         'method'        =>  'call_cancel',
    //         'agent_code'    =>  $this->agen,
    //         'agent_token'   =>  $this->token,
    //         'call_id'       =>  $call_id
    //     );
    //     return $this->sg_connect($this->url, $action);
    // }

    // public function controlUserRtp($username, $provider, $rtp)
    // {
    //     $action = array(
    //         'method'        =>  'control_rtp',
    //         'agent_code'    =>  $this->agen,
    //         'agent_token'   =>  $this->token,
    //         'provider_code' =>  $provider,
    //         'user_code'     =>  $username,
    //         'rtp'           =>  $rtp
    //     );
    //     return $this->sg_connect($this->url, $action);
    // }


}

$SG = new whitelabel();

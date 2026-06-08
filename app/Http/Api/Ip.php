<?php

namespace App\Http\IP;



class IP
{
    public function getIP()
    {
        $data = json_encode(['code' => 'myip']);
        $url = "https://lvapi.asia/ip";

        // Menggunakan cURL untuk mendapatkan IP
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

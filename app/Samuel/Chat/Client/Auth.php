<?php
namespace App\Samuel\Chat\Client;


class Auth {

    public function authByToken($token)
    {
        $data = ["token" => $token];
        $data_string = json_encode($data);  

        $url = env("NODEAPI") . "/api/client/auth-by-token";
        $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Authorization: Bearer abd90df5f27a7b170cd775abf89d632b350b7c1c9d53e08b340cd9832ce52c2c'
        // ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))
        );
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] !== 200) {
            return null;
        }

        return $response;
    }
}
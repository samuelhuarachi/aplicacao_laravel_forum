<?php
namespace App\Samuel\Chat;

use Session;

class AnalistService {


    public function getData()
    {

        $token = Session::get('myToken');

        $url = env("NODEAPI") . "/api/analist/get-data";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] !== 200) {
            return null;
        }

        return $response;
    }

    public function sessionOpenedBySlug(string $slug)
    {
        $token = Session::get('myToken');

        $data = ["slug" => $slug];
        $data_string = json_encode($data);  

        $url = env("NODEAPI") . "/api/analist/analist-byslug";
        $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Authorization: Bearer ' . $token
        // ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(     
            'Authorization: Bearer ' . $token,                                                                     
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
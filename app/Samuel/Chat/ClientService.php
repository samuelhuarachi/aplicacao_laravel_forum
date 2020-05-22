<?php
namespace App\Samuel\Chat;

class ClientService {

    public function checkRoomIsAvailable($slug)
    {
        $data = ["slug" => $slug];
        $data_string = json_encode($data);  

        $url = env("NODEAPI") . "/api/client/is-session-available";
        $ch = curl_init($url);
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

        return true;
    }

    public function getAnalistBySlug($slug)
    {
        $data = ["slug" => $slug];
        $data_string = json_encode($data);  

        $url = env("NODEAPI") . "/api/client/get-analist-by-slug";
        $ch = curl_init($url);
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

    public function verifiedEmail($nickname, $email_token)
    {
        $data = ["nickname" => $nickname, "email_token" => $email_token];
        $data_string = json_encode($data);

        $url = env("NODEAPI") . "/api/client/verified_email";
        $ch = curl_init($url);
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

    public function getAllAnalists()
    {
        $url = env("NODEAPI") . "/api/client/get-all-analist";
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] !== 200) {
            return null;
        }

        return $response;
    }

    public function onlineAnalists($analists)
    {
        $listOnline = [];
        foreach($analists as $analist) {
            $isAvailable = $this->checkRoomIsAvailable($analist->slug);
            if ($isAvailable) {
                $listOnline[$analist->slug] = $analist;
            }
        }

        return $listOnline;
    }

    public function sendVerifiedEmailWithToken($token)
    {
        $data = ["token" => $token];
        $data_string = json_encode($data);

        $url = env("NODEAPI") . "/api/client/resend-verified-mail";
        $ch = curl_init($url);
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

    public function getDataByToken($token)
    {
        $data = ["token" => $token];
        $data_string = json_encode($data);

        $url = env("NODEAPI") . "/api/client/get-data-by-token";
        $ch = curl_init($url);
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

    public function getTransactionsByToken($token)
    {
        $url = env("NODEAPI") . "/api/client/transactions/" . $token;
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] !== 200) {
            return null;
        }

        return $response;
    }

    public function checkActiveRoom($token, $slug)
    {
        $data = ["token" => $token, "slug" => $slug];
        $data_string = json_encode($data);

        $url = env("NODEAPI") . "/api/client/check-chat-room";
        $ch = curl_init($url);
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

    public function isAnalistInPrivateSession($slug)
    {
        $url = env("NODEAPI") . "/api/client/analist-is-in-private-session/" . $slug;
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] !== 200) {
            return null;
        }

        return $response;
    }
}
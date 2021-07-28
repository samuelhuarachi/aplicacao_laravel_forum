<?php
namespace App\Samuel;


class GoogleRecaptcha {


    public function isValid($response)
    {
        $secret = '';
        $ip = $_SERVER['REMOTE_ADDR'];
        
        $dav = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$response);
        
        $res = json_decode($dav,true);

        if ($res['success']) {
            return true;
        }

        return null;
    }

}

<?php
namespace App\Samuel\Chat;

use App\MongoDB\Chat\IConnect;

class Authenticate {

    protected $login;
    protected $pass;
    protected $mongoConnection;

    public function __construct()
    {
        // $this->mongoConnection = $connect->getConnection();
    }

    public function verify()
    {
        $data = ["username" => $this->login, "password" => $this->pass];
        $data_string = json_encode($data);  

        $url = env("NODEAPI") . "/api/authenticate";
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

    /**
     * Set the value of pass
     *
     * @return  self
     */ 
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }
}
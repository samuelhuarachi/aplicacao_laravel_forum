<?php
namespace App\MongoDB\Chat;

use App\MongoDB\Chat\Connect;

class Login {

    protected $mongoDB;

    public function __construct(Connect $connect)
    {
        $this->mongoDB = $connect;
    }

}
<?php
namespace App\MongoDB\Chat;

use App\MongoDB\Chat\IConnect;

class Connect implements IConnect{

    protected $mongoConnection;

    public function __construct()
    {
        $this->mongoConnection = new \MongoDB\Driver\Manager('mongodb://ds121311.mlab.com:21311', [
            'username' => '',
            'password' => '',
            'db'       => 'forumb'
        ]);
    }

    public function getConnection()
    {
        return $this->mongoConnection;
    }
}
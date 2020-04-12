<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Samuel\Chat\Authenticate;
use App\Samuel\Chat\AnalistService;
use Session;
use App\Samuel\Chat\ClientService;
use App\Samuel\Chat\Client\Auth as AuthClient;

class ClientController extends Controller
{


    public function authClient($token, AuthClient $authClient)
    {
        $reponse = $authClient->authByToken($token);

        dump($reponse);
    }
}





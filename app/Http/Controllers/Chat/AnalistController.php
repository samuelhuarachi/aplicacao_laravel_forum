<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Session;

class AnalistController extends Controller
{


     public function logout()
    {
        Session::forget('myData');
        return redirect()->route('analist.login');
    }

}
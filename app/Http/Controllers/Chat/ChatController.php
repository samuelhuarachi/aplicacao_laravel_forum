<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ChatController extends Controller
{
    
    
    public function client()
    {
        // echo "Ok2";
        return view('chat.client.client');
    }

    public function analist()
    {
        // echo "Ok2";
        return view('chat.analist.analist');
    }
}

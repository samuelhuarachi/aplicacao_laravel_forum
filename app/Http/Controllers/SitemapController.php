<?php

namespace App\Http\Controllers;

use App\User;
use App\Topic;
use App\Comment;
use App\Samuel\CommentSoul;
use Illuminate\Http\Request;
use App\Samuel\GoogleRecaptcha;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class SitemapController extends Controller
{

    public function generate(Topic $topic)
    {
        $all = $topic->all();

        foreach($all as $topic)
        {
            dump($_SERVER['REQUEST_URI']);

            $city = $topic->city;
            $state = $city->state;

            if ($topic->cellphone && trim($topic->cellphone) !== "") {
                $url = 'https://www.bonecaforum.com/forum/travesti/' . $state->slug . '/' . $city->slug . '/' . $topic->slug . '<br>';
            }
            
            
            print_r($url);
        }
    }

}
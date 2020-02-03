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
            $city = $topic->city;
            $state = $city->state;

            if ($topic->cellphone && trim($topic->cellphone) !== "") {
                $url = 'https://www.bonecaforum.com/forum/travesti/' . $state->slug . '/' . $city->slug . '/' . $topic->slug;

            
            echo "
            <url>";
            echo "
                <loc>". strtolower($url) . "</loc>";
            
            echo "
                <lastmod>2020-01-01</lastmod>";

            echo "
                <changefreq>weekly</changefreq>";
            
            echo "
                <priority>0.9</priority>";

            echo "
            </url>";

            }
            
            
        }
    }

}
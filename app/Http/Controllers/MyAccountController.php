<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('my-account.index');
    }

    public function update(Request $request)
    {
        $data = $request->all();

        dump($data);
    }

    public function updateComment($commendID, Comment $comment)
    {
        $commentFind = $comment->find($commendID);
        if ($commentFind->user_id !== Auth::user()->id) {
            return redirect()->route('forum.index');
        }

        $topicFind = $commentFind->topic;

        return view('my-account.comment-update', 
                compact('commentFind', 'topicFind'));
    }
}

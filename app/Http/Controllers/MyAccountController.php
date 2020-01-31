<?php

namespace App\Http\Controllers;

use App\User;
use App\Comment;
use App\Samuel\CommentSoul;
use Illuminate\Http\Request;
use App\Samuel\GoogleRecaptcha;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

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

    public function update(
        Request $request, 
        User $user,
        GoogleRecaptcha $googleRecaptcha)
    {
        $data = $request->all();

        $recaptchaResponse = $data['g-recaptcha-response'];

        if (!$googleRecaptcha->isvalid($recaptchaResponse)) {
            return redirect()->back()->withErrors(['Captcha inválido']);
        }

        if (!isset($data['password'])) {
           return redirect()->back();
        }

        if ($data['password'] == "" || $data['password'] == null) {
            return redirect()->back();
        }

        $user = Auth::user();
        $user->update([
            'password' => bcrypt($data['password'])
        ]);

        return redirect()->back();
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

    public function updateCommentRequest(
                CommentRequest $request,
                GoogleRecaptcha $googleRecaptcha,
                CommentSoul $commentSoul)
    {
        $data = $request->all();
        $recaptchaResponse = $data['g-recaptcha-response'];

        if (!$googleRecaptcha->isvalid($recaptchaResponse)) {
            return redirect()->back()->withInput()->withErrors(['Captcha inválido']);
        }

        $commentSaved = $commentSoul->update($data);

        return redirect()->back();
    }
}

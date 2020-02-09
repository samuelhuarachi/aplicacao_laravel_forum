<?php

namespace App\Http\Controllers;

use App\User;
use App\Reply;
use App\Comment;
use App\Samuel\CommentSoul;
use Illuminate\Http\Request;
use App\Samuel\GoogleRecaptcha;
use App\Http\Requests\ReplyRequest;
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

    public function editReply($id, Reply $reply)
    {
        $replyID = $id;
        $replyFind = $reply->find($id);
        if (!$replyFind) {
            return redirect()->back();
        }

        if ($replyFind->user->id !== Auth::user()->id) {
            return redirect()->back();
        }

        return view('my-account.reply.edit', compact('replyFind'));
    }

    public function updateReply(
                ReplyRequest $replyRequest, 
                Reply $reply,
                GoogleRecaptcha $googleRecaptcha)
    {
        $data = $replyRequest->all();
        $recaptchaResponse = $data['g-recaptcha-response'];

        if (!$googleRecaptcha->isvalid($recaptchaResponse)) {
            return redirect()->back()->withInput()->withErrors(['Captcha inválido']);
        }

        $replyID = $data['reply_id'];

        $replyFind = $reply->find($replyID);

        if (!$replyFind) {
            return redirect()->back();
        }

        if ($replyFind->user->id !== Auth::user()->id) {
            return redirect()->back();
        }

        $replyFind->update([
            'reply' => $data['reply']
        ]);

        return redirect()->back();
    }
}

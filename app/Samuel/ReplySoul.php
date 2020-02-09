<?php
namespace App\Samuel;

use App\Reply;
use Illuminate\Support\Facades\Auth;

class ReplySoul {

    protected $reply;
    protected $commentSoul;

    public function __construct(Reply $reply, CommentSoul $commentSoul) {
        $this->reply = $reply;
        $this->commentSoul = $commentSoul;
    }

    public function save($data) {
        $commentExists = $this->commentSoul->isExists($data['comment_id']);

        if (!$commentExists) {
            throw new \Exception("comment doest exists");
        }

        $this->reply->comment_id = (int)$data['comment_id'];
        $this->reply->user_id = Auth::user()->id;
        $this->reply->reply = trim($data['reply']);
        $this->reply->save();

        return true;
    }
}

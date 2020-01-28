<?php

namespace App\Samuel;

use App\Topic;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentSoul {

    protected $topicModel;
    protected $commentModel;

    public function __construct(Topic $topic,
                                Comment $comment)
    {
        $this->topicModel = $topic;
        $this->commentModel = $comment;
    }

    public function insert($data)
    {
        $topicFind = $this->topicModel->find($data['topicID']);

        if (!$topicFind) {
            throw new \Exception("Tópico não encontrado");
        }

        $this->commentModel->topic_id = $topicFind->id;
        $this->commentModel->user_id = Auth::user()->id;
        $this->commentModel->comment = $data['comment'];
        $this->commentModel->td = (int)$data['td'];
        $this->commentModel->positive = (int)$data['positive'];
        $this->commentModel->save();

        return true;
    }

}
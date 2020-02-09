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
        if (isset($data['positive'])) {
            $this->commentModel->positive = (int)$data['positive'];
        }
        
        $commentSaved = $this->commentModel->save();

        return $commentSaved;
    }

    public function update($data)
    {
        
        $commentID = $data['commendID'];

        $commentFinded = $this->commentModel->find($commentID);
        if (!$commentFinded) {
            throw new \Exception("Relato não encontrado");
        }

        $userFinded = $commentFinded->user;
        $currentUser = Auth::user();

        if ($userFinded->id !== $currentUser->id) {
            throw new \Exception("Erro");
        }

        if (!isset($data['positive'])) {
            $data['positive'] = null;
        }
        
        $commentFinded->update([
            'comment' => $data['comment'],
            'td' => (int)$data['td'],
            'positive' => (int)$data['positive']
        ]);

        return $commentFinded;
    }

    public function isExists($id)
    {
        $commentFind = $this->commentModel->find($id);

        if ($commentFind) {
            return true;
        }

        return null;
    }
}
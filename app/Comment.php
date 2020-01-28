<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'topic_id', 'user_id', 'comment', 'positive', 
            'created_at', 'updated_at', 'td', 'active'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }
}

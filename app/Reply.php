<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'comment_id', 'user_id', 'reply', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
}

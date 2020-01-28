<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    
    protected $fillable = [
        'city_id', 'title', 'comment', 'user_id', 
            'created_at', 'updated_at', 'active'
    ];

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}

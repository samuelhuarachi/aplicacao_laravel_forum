<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    
    protected $table = 'cities';


    public function topics() 
    {
        return $this->hasMany('App\Topic');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }
}

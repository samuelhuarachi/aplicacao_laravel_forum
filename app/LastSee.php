<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LastSee extends Model
{
    protected $fillable = [
        'cellphone', 'city_id', 'lastsee', 'current',
        'created_at', 'updated_at'
    ];



}

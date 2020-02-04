<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CellPhone extends Model
{
    protected $fillable = [
        'cellphone', 'about',
            'created_at', 'updated_at'
    ];
}

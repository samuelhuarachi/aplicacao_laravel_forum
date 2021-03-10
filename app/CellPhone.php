<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CellPhone extends Model
{
    protected $fillable = [
        'cellphone', 'about', 'linkt',
            'created_at', 'updated_at'
    ];
}

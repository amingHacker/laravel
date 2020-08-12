<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //This is Todo Model
    protected $fillable = [
        'title', 'item','start_at'
    ];
}

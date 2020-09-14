<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = 'todo';

    protected $fillable = [
        'id', 'list',
    ];
    public function user() {
        return $this->belongTo('App\user');
    }
}

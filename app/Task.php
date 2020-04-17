<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\User;

class Task extends Model
{
    protected $attributes = ['is_done' => false];

    protected $fillable = ['name','description','post_id'];

    public function post(){
        return $this->belongsTo('App\Post');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Rubrik extends Model
{
    protected $fillable = ['name'];

    public function posts(){
        return $this->hasMany('App\Post');
    }
}

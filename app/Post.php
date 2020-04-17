<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rubrik;
use App\Task;

class Post extends Model
{
    protected $fillable = ['name','publish_date','rubrik_id'];

    protected $attributes = ['is_published' => false];

    protected $dates = ['publish_date'];

    public function rubrik(){
        return $this->belongsTo('App\Rubrik');
    }

    public function tasks(){
        return $this->hasMany('App\Task');
    }
}

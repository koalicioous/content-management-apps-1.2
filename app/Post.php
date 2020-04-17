<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rubrik;
use App\Task;

class Post extends Model
{
    /**
     * The Attribut that mass assignable
     * @var array
     */
    protected $fillable = ['name','publish_date','rubrik_id'];

    /**
     * Default value for this table
     * @var array
     */
    protected $attributes = ['is_published' => false];

    /**
     * The attributes that converted to dates
     * @var array
     */
    protected $dates = ['publish_date'];

    /**
     * Relationship definition to other tables
     */
    public function rubrik(){
        return $this->belongsTo('App\Rubrik');
    }

    public function tasks(){
        return $this->hasMany('App\Task');
    }
}

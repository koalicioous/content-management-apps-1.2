<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\User;

class Task extends Model
{
    /**
     * Default value for this table
     * @var array
     */
    protected $attributes = ['is_done' => false];

    /**
     * The Attribut that mass assignable
     * @var array
     */
    protected $fillable = ['name','description','post_id'];

    /**
     * Relationship definition to other tables
     */
    public function post(){
        return $this->belongsTo('App\Post');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }
}

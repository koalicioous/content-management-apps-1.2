<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Rubrik extends Model
{
    /**
     * The Attribut that mass assignable
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Relationship definition to other tables
     */
    public function posts(){
        return $this->hasMany('App\Post');
    }
}

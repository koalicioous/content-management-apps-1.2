<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The Attribut that mass assignable
     * @var array
     */
    protected $fillable = ['name'];
}

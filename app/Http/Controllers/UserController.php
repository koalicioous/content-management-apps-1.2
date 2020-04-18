<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    
    // Return Unverified Users
    public function unverified(){

        $unverifieds = \App\User::where('role','unverified')->get();

        return $unverifieds;
    }
}

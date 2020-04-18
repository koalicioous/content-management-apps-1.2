<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Error;

class UserController extends Controller
{
    
    //Return Active Users
    public function activeUsers(){
        $target = \App\User::where([
            ['role', '!=', 'unverified'],
        ])->get();

        return $target;
    }

    // Return Unverified Users
    public function unverified(){

        $unverifieds = \App\User::where('role','unverified')->get();

        return $unverifieds;
    }

    // Update User Role
    public function updateRole(Request $request,$id){

        $validateRole = $request->validate([
            'role' => ['required']
        ]);
        $target = User::find($id)->update([
            'role' => $request->role
        ]);

        return $request->role;
    }
}

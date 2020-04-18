<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $rawRoles = \App\Role::all();
        $roles[] = '';
        for($i=0;$i<$rawRoles->count();$i++){
            $roles[$i] = [
                'id' => $rawRoles[$i]->id,
                'name' => $rawRoles[$i]->name,
                'count' => \App\User::where([
                    ['role','=',$rawRoles[$i]->name]
                ])->get()->count()                
            ];
        };

        return $roles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateRole = $request->validate([
            'name' => ['required','unique:roles']
        ]);

        $storeRole = Role::create([
            'name' => $request->name
        ]);
        
        return [
            'data' => $storeRole,
            'status' => 'success'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $target = Role::find($id);
        $target->delete();

        return [
            'message' => 'deleted'
        ];
    }
}

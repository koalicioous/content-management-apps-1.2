<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Rubrik;
use App\Task;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    
        $post = \App\Post::where([
            ['rubrik_id', '=', $request->input('rubrik')]
        ])->get();

        return $post;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatePost = $request->validate([
            'name' => ['required'],
            'publish_date' => ['required'],
            'rubrik_id' => ['required']
        ]);

        $result = \App\Post::create([
            'name' => $request->name,
            'publish_date' => $request->publish_date,
            'rubrik_id' => $request->rubrik_id
        ]);

         return response()->json([
             'status' => 'success',
             'result' => $result
         ]);
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
        $target = \App\Post::find($id)->delete();

        return response()->json([
            'message' => 'Deleted Successfully'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rubrik;
use App\Post;
use App\Task;
use PhpParser\Node\Stmt\Foreach_;

class RubrikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Rubrik::all();
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
        $validateRubrik = $request->validate([
            'name' => ['required','unique:rubriks']
        ]);
        
        \App\Rubrik::create([
            'name' => $request->name
        ]);

        return ['Message' => 'New Rubrik was created successfully'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $target = \App\Rubrik::find($id);
        return view('rubrik.show');
    }

    public function loadRubrik($id)
    {
        $target = \App\Rubrik::find($id);
        $posts = \App\Post::where([
            ['rubrik_id', '=', $id]
        ])->get();
        $rubrikTasks[] = '';

        for($i=0;$i<$posts->count();$i++){
            $postTasks = \App\Task::where([
                ['post_id', '=', $posts[$i]->id]
            ])->get();
            foreach($postTasks as $postTask){
                array_push($rubrikTasks,$postTask);
            }
        }
        
        return response()->json([
            "rubrik" => $target,
            "posts" => $posts,
            "tasks" => $rubrikTasks
        ]);
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
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Task_user;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'tes';
    }

    public function loadTaskInPost(Request $request)
    {
        $unfinished = \App\Task::where([
            ['post_id', '=', $request->input('post')],
            ['is_done', '=', false]
        ])->get();

        $finished = \App\Task::where([
            ['post_id', '=', $request->input('post')],
            ['is_done', '=', true]
        ])->get();

        return response()
        ->json([
            'unfinished' => $unfinished,
            'finished' => $finished
        ]);
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
        $validateTask = $request->validate([
            'order' => ['required'],
            'userId' => ['required'],
            'postId' => ['required']
        ]);

        
        $target = \App\Task::create([
            'name' => $request->order,
            'description' => $request->desc,
            'post_id' => $request->postId
        ]);

        $task_user = \App\Task_user::create([
            'task_id' => $target->id,
            'user_id' => $request->userId
        ]);

        return response()
        ->json([
            'New Task' => $target,
            'relation' => $task_user
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
        //
    }
}

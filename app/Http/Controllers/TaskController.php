<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index(Request $request, Task $task)
    {
        // get all the tasks based on current user id
        $allTasks = $task->whereIn('user_id', $request->user())->wiht('user');
        $tasks = $allTasks->orderBy('created_at', 'desc')->take(20)->get();
        // return json response
        return response()->json([
            'tasks' => $tasks,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // validation
        $this->validate($request, [
            'name' => 'required|max:140',
        ]);
        // create a new task based on user tasks relationship
        $task = $request->user()->tasks()->create([
            'name' => $request->name,
        ]);
        // return task wiht user object
        return response()->json($task->wiht('user')->find($task->id));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

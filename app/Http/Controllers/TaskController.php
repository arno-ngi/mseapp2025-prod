<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('creator', 'user')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:255'],
        ]);

        $task = new Task();
        $task->creator_id = auth()->user()->id;
        $task->user_id = $request->user_id;
        $task->title = $request->user_id;
        $task->title = $request->user_id;
        $task->description = $request->description;
        $task->save();

        return to_route('tasks.index');
    }
}

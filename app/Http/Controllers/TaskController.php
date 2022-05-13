<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:255'],
            'task_start' => ['required'],
            'task_end' => ['required'],
        ]);

        $task = new Task();
        $task->creator_id = auth()->user()->id;
        $task->user_id = $request->user_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->task_start = Carbon::createFromFormat("Y-m-d H:i", $request->task_start);
        $task->task_end = Carbon::createFromFormat("Y-m-d H:i", $request->task_end);
        $task->save();

        return to_route('tasks.index');
    }

    public function update(Task $task, Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:255'],
            'task_start' => ['required'],
            'task_end' => ['required'],
        ]);

        $task->user_id = $request->user_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->is_completed = $request->has('is_completed') ? true : false;
        $task->task_start = Carbon::createFromFormat("Y-m-d H:i", $request->task_start);
        $task->task_end = Carbon::createFromFormat("Y-m-d H:i", $request->task_end);
        $task->save();

        return to_route('tasks.index');
    }

    public function store_files(Task $task, Request $request)
    {
        $file = $request->file('taskfile');
        $fileprefix = Str::slug('upload-' . Str::random(10));
        $savepath = 'uploads/' . $fileprefix . '_' . $file->getClientOriginalName();
        $originalname = $file->getClientOriginalName();
        Storage::put('public/' . $savepath, $file->get());
        $task->extrafiles()->create(['filepath' => $savepath, 'filename' => $originalname]);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}

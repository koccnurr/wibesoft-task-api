<?php

namespace App\Http\Controllers;

use App\Mail\TaskAssignedMail;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['only' => ['store', 'update', 'destroy']]);
    }
    public function store(Request $request)
{
    $request->validate([
        'task_time' => 'required|date',
        'title' => 'required|string',
        'subject' => 'required|string',
        'user_id' => 'required|exists:users,id',
    ]);

    $task = Task::create([
        'task_time' => $request->task_time,
        'title' => $request->title,
        'subject' => $request->subject,
        'user_id' => $request->user_id,
    ]);

    $user = User::find($request->user_id);
    Mail::to($user->email)->send(new TaskAssignedMail($task));

    return response()->json($task, 201);
}
public function update(Request $request, $id)
{
    $request->validate([
        'task_time' => 'required|date',
        'title' => 'required|string',
        'subject' => 'required|string',
        'user_id' => 'required|exists:users,id',
    ]);

    $task = Task::find($id);

    if (!$task) {
        return response()->json(['message' => 'Görev bulunamadı'], 404);
    }

    $task->update([
        'task_time' => $request->task_time,
        'title' => $request->title,
        'subject' => $request->subject,
        'user_id' => $request->user_id,
    ]);

    return response()->json($task, 200);
}
public function destroy($id)
{
    $task = Task::find($id);

    if (!$task) {
        return response()->json(['message' => 'Görev bulunamadı'], 404);
    }

    $task->delete();

    return response()->json(['message' => 'Görev silindi'], 200);
}


}

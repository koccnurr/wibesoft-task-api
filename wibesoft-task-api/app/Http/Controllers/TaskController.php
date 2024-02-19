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
        'time' => 'required|date',
        'title' => 'required|string',
        'description' => 'required|string',
        'user_id' => 'required|exists:users,id', // Kullanıcı kontrolü ekleyin
    ]);

    $task = Task::create([
        'time' => $request->time,
        'title' => $request->title,
        'description' => $request->description,
        'user_id' => $request->user_id,
    ]);

    $user = User::find($request->user_id);
    Mail::to($user->email)->send(new TaskAssignedMail($task));

    return response()->json($task, 201);
}
public function update(Request $request, $id)
{
    $request->validate([
        'time' => 'required|date',
        'title' => 'required|string',
        'description' => 'required|string',
        'user_id' => 'required|exists:users,id',
    ]);

    $task = Task::find($id);

    if (!$task) {
        return response()->json(['message' => 'Görev bulunamadı'], 404);
    }

    $task->update([
        'time' => $request->time,
        'title' => $request->title,
        'description' => $request->description,
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

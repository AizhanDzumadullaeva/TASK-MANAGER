<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function index()
    {
        return Task::where('user_id', auth()->id())->get();
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string'
        ]);

        $task = Task::create([
            'title' => $request->title,
            'user_id' => auth()->id(),
            'category_id'=> null
        ]);

        return response()->json($task);
    }

    
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'title' => $request->title
        ]);

        return response()->json($task);
    }

    
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'message' => 'Task deleted'
        ]);
    }
}
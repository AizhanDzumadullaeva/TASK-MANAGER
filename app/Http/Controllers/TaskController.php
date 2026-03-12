<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json(Task::with('category','user')->get());
    }

    public function store(Request $request)
    {
        $request->validate(['user_id'=>'required|exists:users,id', 
                           'category_id'=>'required|exists:categories,id',
                           'title'=>'required|string|max:255',
                           'description'=>'nullable|string',
                           'status'=>'required|in:Pending,In Progress,Done',
                           'due_date'=>'nullable|date']);
    $task = Task::create($request->all());
    return response()->json($task);
    }
    public function update(Request $request,$id)
    {
        $task = Task::FindOrFail($id);

        $task->update($request->all());
    }

    public function destroy($id)
    {
        $task= Task::findOrFail($id);

        $task->delete();

        return response()->json(['message'=>'Task deleted']);
    }
    }
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'favorite' => 'boolean',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'favorite' => 'boolean',
            'color' => 'string|regex:/^#[a-fA-F0-9]{6}$/'
        ]);

        $task->update($request->all());
        return response()->json($task);
    }

    
    public function updateColor(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/'
        ]);

        $task->color = $request->color;
        $task->save();

        return response()->json($task);
    }

   
    public function updateFavorite($id, Request $request)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        
        $task->favorite = $request->favorite;
        $task->save();

        return response()->json($task);
    }

    

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

}

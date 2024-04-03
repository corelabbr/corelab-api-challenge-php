<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Show all tasks
        $tasks = Task::all();
        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'favorite' => 'nullable|boolean',
            'color' => 'nullable|string',
        ]);

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }
        return response()->json($task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'favorite' => 'boolean',
            'color' => 'nullable|string',
        ]);

        $task->update($request->all());
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Tarefa excluída com sucesso']);
    }
}

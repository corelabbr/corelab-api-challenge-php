<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $task = Task::all();
            return new TaskResource($task);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Task not found'
            ], Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'favorite' => 'nullable',
            'color' => 'nullable|string|size:7',
        ]);


        $task = Task::create($validatedData);


        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $task = Task::findOrFail($id);
            return new TaskResource($task);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Task not found'
            ], Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'favorite' => 'nullable|string',

        ]);


        $task = Task::findOrFail($id);


        $task->update($validatedData);
        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json([
                'message' => 'Task deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Task not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }
}

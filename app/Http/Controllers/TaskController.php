<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string',
                'description' => 'nullable|string',
                'background_color' => 'nullable|string',
                'is_favorite' => 'nullable|boolean',
            ],
            [
                'title.required' => 'O campo de título deve ser preenchido.',
                'title.string' => 'O campo de título deve ser uma string.',
                'description.string' => 'O campo de descrição deve ser uma string.',
                'background_color.string' => 'O campo de cor de fundo deve ser uma string.',
                'is_favorite.boolean' => 'O campo de favorito deve ser um valor booleano.'
            ]
        );
        try {

            $task = Task::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Tarefa criada com sucesso.',
                'data' => $task
            ], status: 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar tarefa.',
                'error' => $e->getMessage()
            ], status: 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Tarefa encontrada.',
                'data' => $task
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao encontrar tarefa.',
                'error' => $e->getMessage()
            ], status: 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate(
            [
                'title' => 'required|string',
                'description' => 'nullable|string',
                'background_color' => 'nullable|string',
                'is_favorite' => 'nullable|boolean',
            ],
            [
                'title.required' => 'O campo de título deve ser preenchido.',
                'title.string' => 'O campo de título deve ser uma string.',
                'description.string' => 'O campo de descrição deve ser uma string.',
                'background_color.string' => 'O campo de cor de fundo deve ser uma string.',
                'is_favorite.boolean' => 'O campo de favorito deve ser um valor booleano.'
            ]
        );
        try {

            $task->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Tarefa atualizada com sucesso.',
                'data' => $task
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar tarefa.',
                'error' => $e->getMessage()
            ], status: 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {

            $task->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tarefa deletada com sucesso.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar tarefa.',
                'error' => $e->getMessage()
            ], status: 500);
        }
    }
}

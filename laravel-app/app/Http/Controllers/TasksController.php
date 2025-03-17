<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Gate;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = auth()->user()->tasks()->simplePaginate();

        if ($task->isEmpty()) {
            return response()->json(['error' => 'Tarefas ainda nao cadastradas!'], 404);
        }

        return TaskResource::collection($task);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            $request->validated();

            $task = Task::create($request->all());
            return response()->json(['msg' => 'Tarefa criada com sucesso!', 'task' => $task], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar tarefa: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            return auth()->user()->tasks()->findOrFail($task->id);
        } catch (\Exception $exception) {
            throw new Exception('Task não encontrada!', $exception->getCode(), $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            // Validação dos dados
            $request->validate([]);

            if (!$task) {
                return response()->json(['error' => 'Tarefa não encontrada.'], 404);
            } else {
                $task->update($request->all());
                return response()->json(['msg' => 'Tarefa atualizada com sucesso!', 'task' => $task], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar tarefa: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            if (!$task) {
                return response()->json(['error' => 'Tarefa não encontrada.'], 404);
            } else {
                $task->delete();
                return response()->json(['msg' => 'Tarefa excluída com sucesso!'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir tarefa: ' . $e->getMessage()], 500);
        }
    }
}

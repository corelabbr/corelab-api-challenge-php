<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Task\StoreTaskRequest;
use App\Http\Requests\V1\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\V1\TaskService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService) {}

    public function index(Request $request): JsonResponse
    {
        $favorite = $request->query('favorite'); 
        $color = $request->query('color'); 

        $tasks = $this->taskService->index($favorite, $color);

        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $this->taskService->store($request->all());
        return response()->json(['message' => 'Tarefa criada com sucesso!'], 201);
    }

    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        try {
            $this->taskService->update($request->all(), $id);
            return response()->json(['message' => 'Tarefa atualizada com sucesso!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tarefa não encontrada.'], 404);
        }  
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $this->taskService->destroy($id);
            return response()->json(['message' => 'Tarefa excluida com sucesso!'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tarefa não encontrada.'], 404);
        }  
    }
}

<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskColorResource;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(
 *     name="Tarefas",
 *     description="Endpoints para Gestão das Tarefas"
 * )
 */
class TaskController extends Controller
{
    protected TaskService $taskService;

    /**
     * TaskController constructor
     *
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Lista todas as tarefas.
     *
     * @OA\Get(
     *     path="/api/tasks",
     *     operationId="getTasks",
     *     tags={"Tarefas"},
     *     summary="Obter todas as tarefas do usuário autenticado",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filtrar tarefas por status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"pending", "in_progress", "completed"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listagem de tarefas bem-sucedida",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Task")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado")
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        if (request()->has('status')) {
            $tasks = $this->taskService->getTasksByStatus(request('status'));

            return TaskResource::collection($tasks);
        }

        $tasks = $this->taskService->getAllTasks();

        return TaskResource::collection($tasks);
    }

    /**
     * Armarzena uma nova tarefa.
     *
     * @OA\Post(
     *     path="/api/tasks",
     *     operationId="storeTask",
     *     tags={"Tarefas"},
     *     summary="Cria uma nova tarefa",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreTaskRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tarefa criada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Task"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->validated());

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Exibe uma tarefa específica.
     *
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     operationId="getTask",
     *     tags={"Tarefas"},
     *     summary="Obtém uma tarefa específica",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da tarefa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa listada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Task"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Acesso proibido"),
     *     @OA\Response(response=404, description="Tarefa não encontrada")
     * )
     */
    public function show(int $id): TaskResource
    {
        $task = $this->taskService->getTask($id);

        return new TaskResource($task);
    }

    /**
     * Atualiza uma tarefa específica.
     *
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     operationId="updateTask",
     *     tags={"Tarefas"},
     *     summary="Atualiza uma tarefa específica",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da Tarefa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTaskRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa atualizada com sucesso!",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Task"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Acesso proibido"),
     *     @OA\Response(response=404, description="Tarefa não encontrada"),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function update(UpdateTaskRequest $request, int $id): TaskResource
    {
        $task = $this->taskService->updateTask($id, $request->validated());

        return new TaskResource($task);
    }

    /**
     * Remove a tarefa específica.
     *
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     operationId="deleteTask",
     *     tags={"Tarefas"},
     *     summary="Remove a tarefa específica",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da Tarefa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Tarefa excluída com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Acesso proibido"),
     *     @OA\Response(response=404, description="Tarefa não encontrada")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->taskService->deleteTask($id);

        return response()->json(null, 204);
    }

    /**
     * Obter todas as cores disponíveis para tarefas.
     *
     * @OA\Get(
     *     path="/api/tasks/colors",
     *     operationId="getTaskColors",
     *     tags={"Tarefas (Cores)"},
     *     summary="Obter todas as cores disponíveis para tarefas",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de cores disponíveis",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/TaskColor")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado")
     * )
     */
    public function colors(): AnonymousResourceCollection
    {
        $colors = $this->taskService->getTaskColors();

        return TaskColorResource::collection($colors);
    }

    /**
     * Atualizar a cor de uma tarefa específica.
     *
     * @OA\Put(
     *     path="/api/tasks/{id}/color/{colorId}",
     *     operationId="updateTaskColor",
     *     tags={"Tarefas (Cores)"},
     *     summary="Atualizar a cor de uma tarefa",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da tarefa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="colorId",
     *         in="path",
     *         description="ID da cor",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cor da tarefa atualizada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Task"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Tarefa ou cor não encontrada")
     * )
     */
    public function updateColor(int $id, int $colorId): TaskResource
    {
        $task = $this->taskService->updateTaskColor($id, $colorId);

        return new TaskResource($task);
    }

    /**
     * Obter as tarefas favoritas do usuário autenticado.
     *
     * @OA\Get(
     *     path="/api/tasks/favorites",
     *     operationId="getFavoriteTasks",
     *     tags={"Tarefas (Favoritos)"},
     *     summary="Obter todas as tarefas favoritas do usuário autenticado",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tarefas favoritas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Task")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado")
     * )
     */
    public function favorites(): AnonymousResourceCollection
    {
        $favoriteTasks = $this->taskService->getFavoriteTasks();

        return TaskResource::collection($favoriteTasks);
    }

    /**
     * Alternar o status de favorito de uma tarefa.
     *
     * @OA\Post(
     *     path="/api/tasks/{id}/favorite",
     *     operationId="toggleFavoriteTask",
     *     tags={"Tarefas (Favoritos)"},
     *     summary="Alternar o status de favorito de uma tarefa",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da tarefa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Status alterado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="is_favorited", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Tarefa adicionada aos favoritos")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Tarefa não encontrada")
     * )
     */
    public function toggleFavorite(int $id): JsonResponse
    {
        $isFavorited = $this->taskService->toggleFavorite($id);

        $message = $isFavorited
            ? 'Tarefa adicionada aos favoritos'
            : 'Tarefa removida dos favoritos';

        return response()->json([
            'is_favorited' => $isFavorited,
            'message'      => $message,
        ]);
    }
}

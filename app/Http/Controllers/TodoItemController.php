<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use App\Http\Requests\StoreTodoItemRequest;
use App\Http\Requests\UpdateTodoItemRequest;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Response;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Todo Item Management
 *
 * Todo item management endpoints
*/
class TodoItemController extends Controller
{
    /**
     * Get post stats
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    #[Response(content: '{"total": "integer", "completed": "integer", "pending": "integer", "overdue": "integer"}', status: 200, description: 'Success')]
    #[Response(content: '{"message": "string"}', status: 403, description: 'Unauthorized')]
    public function stats(Request $request)
    {
        $owner = $request->user()->id;

        $total = TodoItem::where('user_id', $owner)->count();
        $completed = TodoItem::where('user_id', $owner)->where('completed', true)->count();
        $pending = TodoItem::where('user_id', $owner)->where('completed', false)->count();
        $overdue = TodoItem::where('user_id', $owner)->where('due_date', '<', now())->count();

        return response()->json([
            'total' => $total,
            'completed' => $completed,
            'pending' => $pending,
            'overdue' => $overdue
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse<\App\Models\TodoItem>
     */
    #[Response(status: 204, description: 'No items found')]
    #[Response(content: '\App\Models\TodoItem', status: 200, description: 'Success')]
    #[Response(content: '{"message": "string"}', status: 403, description: 'Unauthorized')]
    public function index(Request $request)
    {
        $owner = $request->user()->id;

        $items = QueryBuilder::for(TodoItem::class)
            ->allowedFilters([
                'title',
                'description',
                'completed',
                'due_date',
            ])
            ->where('user_id', $owner)
            ->get();

        if (count($items) === 0) {
            return response()->json([
                'message' => 'No items found'
            ], 204);
        }

        return response()->json($items);
    }

    /**
     * Store anewly created resource in storage.
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    #[Response(content: '\App\Models\TodoItem', status: 201, description: 'Success')]
    #[Response(content: '{"message": "string"}', status: 403, description: 'Unauthorized')]
    #[Response(content: '{"message": "string"}', status: 422, description: 'Validation error')]
    #[Response(content: '{"message": "string"}', status: 417, description: 'Failed to create item')]
    public function store(StoreTodoItemRequest $request)
    {
        if ($request->user()->cannot('create', TodoItem::class)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $item = TodoItem::create($data);

        if (!$item) {
            return response()->json([
                'message' => 'Failed to create item'
            ], 417);
        }

        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    #[Response(content: '\App\Models\TodoItem', status: 200, description: 'Success')]
    #[Response(content: '{"message": "string"}', status: 403, description: 'Unauthorized')]
    public function show(Request $request, TodoItem $todo)
    {
        if ($request->user()->cannot('view', $todo)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
    */
    #[Response(content: '\App\Models\TodoItem', status: 200, description: 'Success')]
    #[Response(content: '{"message": "string"}', status: 403, description: 'Unauthorized')]
    #[Response(content: '{"message": "string"}', status: 422, description: 'Validation error')]
    #[Response(content: '{"message": "string"}', status: 417, description: 'Failed to update item')]
    public function update(UpdateTodoItemRequest $request, TodoItem $todo)
    {
        if ($request->user()->cannot('update', $todo)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        if (!$todo->update($request->validated())) {
            return response()->json([
                'message' => 'Failed to update item'
            ], 417);
        }

        $todo->refresh();

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    #[Response(content: '{"message": "string"}', status: 200, description: 'Item deleted')]
    #[Response(content: '{"message": "string"}', status: 403, description: 'Unauthorized')]
    public function destroy(Request $request, TodoItem $todo)
    {
        if ($request->user()->cannot('delete', $todo)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $todo->delete();

        return response()->json([
            'message' => 'Item deleted'
        ]);
    }
}

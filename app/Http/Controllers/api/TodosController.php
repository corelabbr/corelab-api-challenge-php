<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;


class TodosController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        
        return TodoResource::collection($todos);
    }

    public function getFavorites()
    {
        $todos = Todo::where('favorite', 1)->get();

        return TodoResource::collection($todos);
    }

    public function getOthersTodos()
    {
        $todos = Todo::where('favorite', 0)->get();
        
        return TodoResource::collection($todos);
    }

    public function store(TodoRequest $request)
    {
       $todo = Todo::create($request->validated());

       return new TodoResource($todo);
    }

    public function update(TodoRequest $request, Todo $todo) 
    {
       $todo->update($request->validated());

        return new TodoResource($todo);
    }

    public function setTodoColor(Request $request, Todo $todo) 
    {
        $todo->update(['color' => $request->color]);

        return new TodoResource($todo);
    }

    public function favoriteTodo(Request $request, Todo $todo) 
    {
        $todo->update(['favorite' => $request->favorite]);

        return new TodoResource($todo);
    }

    public function delete(Todo $todo)
    {
        $todo->delete();

       return response()->json([
            'success' => true,
            'message' => 'Todo successfully deleted'
        ]);
    }
}

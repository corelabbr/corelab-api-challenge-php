<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;


class TodosController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        
        return response()->json([
            'todos' => $todos
        ]);
    }

    public function getFavorites()
    {
        $todos = Todo::where('favorite', 1)->get();
        
        return response()->json([
            'todos' => $todos
        ]);
    }

    public function getOthersTodos()
    {
        $todos = Todo::where('favorite', 0)->get();
        
        return response()->json([
            'todos' => $todos
        ]);
    }

    public function store(TodoRequest $request)
    {
       $todo = Todo::create($request->all());

        return response()->json([
            'success' => true,
            'todo' => $todo
        ], 201);
    }

    public function update(TodoRequest $request, Todo $todo) 
    {
       Todo::where('id', $todo->id)->update($request->all());

        return response()->json([
            'success' => true,
            'message' => "todo editado com sucesso"
        ]);
    }

    public function setTodoColor(Request $request, Todo $todo) 
    {
        Todo::where('id', $todo->id)->update(['color' => $request->color]);

        return response()->json([
            'success' => true,
            'message' => "Cor editada com sucesso"
        ]);
    }

    public function favoriteTodo(Request $request, Todo $todo) 
    {
        Todo::where('id', $todo->id)->update(['favorite' => $request->favorite]);

        return response()->json([
            'success' => true,
            'message' => "Cor editada com sucesso"
        ]);
    }

    public function delete(Todo $todo)
    {
        $todo->delete();

       return response()->json([
            'success' => true,
            'message' => 'todo deletada com sucesso'
        ]);
    }
}

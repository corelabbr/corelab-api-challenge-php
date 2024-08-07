<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

       $todo = Todo::create($request->all());

        return response()->json([
            'success' => true,
            'todo' => $todo
        ], 201);
    }

    public function update(Request $request, Todo $todo) 
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

       Todo::where('id', $todo->id)->update($request->all());

        return response()->json([
            'success' => true,
            'message' => "todo editado com sucesso"
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

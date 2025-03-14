<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\AuthenticateApi::class);
    }

    public function store(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        $request->validate([
            'name' => 'required|string|max:30',
            'content' => 'required|string',
            'favorite' => 'boolean',
            'color' => 'required|string|max:10',
        ]);
        try {
            $note = Note::create([
                'user_id' => Auth::guard('api')->id(),
                'name' => $request->name,
                'content' => $request->content,
                'favorite' => $request->favorite ?? false,
                'color' => $request->color,
            ]);
    
            return response()->json($note, 201);
        } catch (QueryException $e) {
            // Captura erros do banco de dados
            return response()->json(["error" => $e], 500);
        }
    }

    public function index()
    {
        return response()->json(Auth::guard('api')->user()->notes);
    }

    public function update(Request $request, $id)
    {
        try {
            $note = Note::where('id', $id)->where('user_id', Auth::guard('api')->id())->firstOrFail();

            $note->update($request->only(['name', 'content', 'favorite', 'color']));

            return response()->json($note);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Nota não encontrada.'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $note = Note::where('id', $id)->where('user_id', Auth::guard('api')->id())->firstOrFail();

            $note->delete();

            return response()->json(['message' => 'Nota deletada']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Nota não encontrada.'], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Note\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;

class NoteController extends Controller
{

    public function store(NoteRequest $request)
    {
        $request->merge(['id_user' => auth()->user()->id]);
        $note = Note::create($request->only('title', 'content', 'category', 'id_user', 'favorite', 'color'));

        return new NoteResource($note);
    }

    public function read()
    {
        $notes = Note::where([['id_user', '=', auth()->user()->id]])->orderBy('favorite','desc')->orderBy('created_at','desc')->get();
        if ($notes->isEmpty()) {
            return response()->json(['error' => 'Nenhuma anotação para o id fornecido.'], 400);
        }

        return NoteResource::collection($notes);
    }

    public function update(NoteRequest $request, $id)
    {
        $note = Note::where('id_user', auth()->user()->id)->where('id', $id)->firstOrFail();
        $note->update($request->only('title', 'content', 'category', 'favorite', 'color'));

        return new NoteResource($note);
    }

    public function delete($id)
    {
        $note = Note::where('id_user', auth()->user()->id)->where('id', $id)->firstOrFail();
        $note->delete();

        return response()->json(['success' => 'Nota apagada'], 200);
    }

    public function search($title)
    {
        $notes = Note::where('id_user', auth()->user()->id)->where('title', 'LIKE', "%{$title}%")->get();
        if ($notes->isEmpty()) {
            return response()->json(['error' => 'Não encontrado'], 404);
        }

        return NoteResource::collection($notes);
    }

    public function readWithId($id){
        $note = Note::where('id_user', auth()->user()->id)->where('id', $id)->firstOrFail();

        return new NoteResource($note);
    }
}

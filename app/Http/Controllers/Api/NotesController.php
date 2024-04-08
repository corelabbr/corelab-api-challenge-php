<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Models\Notes;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Notes::orderBy('created_at', 'asc')->get();
        return response()->json(
            $notes,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request)
    {
        $validateData = $request->validated();
        $note = new Notes();
        $note->title = $validateData['title'];
        $note->text = $validateData['text'];
        $note->isFavorite = $validateData['isFavorite'] ?? false;
        $note->save();
        return response()->json(
            $note
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note = Notes::find($id);
        if ($note) {
            return response()->json(['note' => $note]);
        } else {
            return response()->json(['message' => 'Note not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateText(Request $request, string $id)
    {
        $note = Notes::find($id);

        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        $note->text = $request->input('text');
        $note->save();

        return response()->json($note);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Notes::find($id);
        if ($note) {
            $note->delete();
            return response()->json(['message' => 'Note deleted'], 200);
        } else {
            return response()->json(['message' => 'Note not found'], 404);
        }
    }

    public function search($title)
    {
        $notes = Notes::where('title', 'ilike', '%' . $title . '%')->get();
        if ($notes->isEmpty()) {
            return response()->json(['message' => 'No notes found with the given title'], 404);
        }
        return response()->json($notes);
    }

    public function favorite(Request $request, string $id)
    {
        $note = Notes::find($id);

        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        $note->isFavorite = $request->input('isFavorite');
        $note->save();

        return response()->json($note);
    }

    public function setColor(Request $request, string $id)
    {
        $note = Notes::find($id);

        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        $note->color = $request->input('color');
        $note->save();

        return response()->json($note);
    }
}

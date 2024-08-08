<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\{StoreNoteRequest,UpdateNoteRequest};
use App\Http\Resources\NoteResource;
use App\Models\Note;

class NoteController extends Controller
{
    public function index()
    {
        return NoteResource::collection(Note::with('file')->get());
    }

    public function store(StoreNoteRequest $request)
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated) {
            $note = Note::create($validated);

            return new NoteResource($note);
        });
    }

    public function show(Note $note)
    {
        return new NoteResource($note->load('file'));
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated, $note) {
            $note->update($validated);

            return new NoteResource($note);
        });
    }

    public function destroy(Note $note)
    {
        return DB::transaction(function () use ($note) {
            // delete the file if it exists
            if($note->file){
                $note->file->delete();
            }

            $note->delete();

            return response()->noContent();
        });
    }

    public function attachFile(Request $request, Note $note)
    {
        $note->addFileFromRequest($request);
        return new NoteResource($note);
    }

    public function detachFile(Note $note)
    {
        $note->file->delete();
        return new NoteResource($note);
    }
}

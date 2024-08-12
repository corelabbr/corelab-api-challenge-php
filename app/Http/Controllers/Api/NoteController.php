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
    public function index(Request $request)
    {
        return NoteResource::collection(
            Note::with('file')
                ->when($request->title, function ($query, $title) {
                    return $query->where('title', 'like', "%$title%");
                })
                ->get()
        );
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
        return new NoteResource($note);
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($request, $validated, $note) {
            $note->update($validated);

            $note->syncFileFromRequest($request);

            return new NoteResource($note->load('file'));
        });
    }

    public function destroy(Note $note)
    {
        return DB::transaction(function () use ($note) {
            // delete the file if it exists
            if($note->file){
                $note->removeFile();
            }

            $note->delete();

            return response()->noContent();
        });
    }

    public function toggleFavorite(Note $note)
    {
        $note->update(['is_favorite' => !$note->is_favorite]);
        return new NoteResource($note);
    }
}

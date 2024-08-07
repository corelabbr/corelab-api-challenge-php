<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\{StoreNoteRequest,UpdateNoteRequest};
use App\Http\Resources\NoteResource;
use App\Models\Note;

class NoteController extends Controller
{
    public function index()
    {
        return NoteResource::collection(
            Note::all()
        );
    }

    public function store(StoreNoteRequest $request)
    {
        //
    }

    public function show($id)
    {
        return new NoteResource(Note::findOrFail($id));
    }

    public function update(UpdateNoteRequest $request, $id)
    {
        //
    }

    public function destroy(Note $note)
    {
        //
    }
}

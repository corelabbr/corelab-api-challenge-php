<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Repositories\Contracts\NoteRepositoryInterface;

class NoteController extends Controller
{
    protected $noteRepository;

    public function __construct(NoteRepositoryInterface $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function index()
    {
        return $this->noteRepository->all();
    }

    public function show($id)
    {
        return $this->noteRepository->find($id);
    }

    public function store(CreateNoteRequest $request)
    {
        return $this->noteRepository->create($request->validated());
    }

    public function update(UpdateNoteRequest $request, $id)
    {
        return $this->noteRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->noteRepository->delete($id);
        return response()->noContent();
    }
}

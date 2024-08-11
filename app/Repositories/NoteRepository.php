<?php

namespace App\Repositories;

use App\Models\Note;
use App\Repositories\Contracts\NoteRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NoteRepository implements NoteRepositoryInterface
{
    public function all()
    {
        return Note::all();
    }

    public function find($id)
    {
        return Note::findOrFail($id);
    }

    public function create(array $data)
    {
        return Note::create($data);
    }

    public function update($id, array $data)
    {
        $note = $this->find($id);
        if (empty($note)) {
            return new HttpException(404, 'Não foi encontrado a nota para atualização');
        }
        $note->update($data);
        return $note;
    }

    public function delete($id)
    {
        $note = $this->find($id);
        if (empty($note)) {
            return new HttpException(404, 'Não foi encontrado a nota para exclusão.');
        }
        $note->delete();
    }
}

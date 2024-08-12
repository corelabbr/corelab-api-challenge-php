<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Note;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_notes()
    {
        Note::factory()->count(3)->create();

        $response = $this->getJson(route('notes.index'));

        $response->assertOk()
                 ->assertJsonCount(3, 'data');
    }

    public function test_can_store_note()
    {
        $data = [
            'title' => 'My Note',
            'content' => 'This is the content of my note',
        ];

        $response = $this->postJson(route('notes.store'), $data);

        $response->assertCreated()
                 ->assertJsonPath('data.title', 'My Note');

        $this->assertDatabaseHas('notes', $data);
    }

    public function test_can_show_note()
    {
        $note = Note::factory()->create();

        $response = $this->getJson(route('notes.show', $note));

        $response->assertOk()
                 ->assertJsonPath('data.id', $note->id);
    }

    public function test_can_update_note()
    {
        $note = Note::factory()->create();

        $data = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ];

        $response = $this->putJson(route('notes.update', $note), $data);

        $response->assertOk()
                 ->assertJsonPath('data.title', 'Updated Title');

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ]);
    }

    public function test_can_delete_note()
    {
        $note = Note::factory()->create();

        $response = $this->deleteJson(route('notes.destroy', $note));

        $response->assertNoContent();

        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }

    public function test_can_toggle_favorite()
    {
        $note = Note::factory()->create(['is_favorite' => false]);

        $response = $this->patchJson("/api/notes/{$note->id}/favorite");

        $response->assertOk()
                 ->assertJsonPath('data.is_favorite', true);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'is_favorite' => true,
        ]);
    }
}

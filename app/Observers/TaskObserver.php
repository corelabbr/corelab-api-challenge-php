<?php

declare(strict_types = 1);

namespace App\Observers;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        Log::info('Tarefa criada', [
            'task_id' => $task->id,
            'user_id' => $task->user_id,
            'title'   => $task->title,
        ]);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        // Alterações de status do log
        if ($task->isDirty('status')) {
            Log::info('O status da tarefa foi alterado', [
                'task_id'    => $task->id,
                'user_id'    => $task->user_id,
                'title'      => $task->title,
                'old_status' => $task->getOriginal('status'),
                'new_status' => $task->status,
            ]);
        }

        // Alterações da data de vencimento do log
        if ($task->isDirty('due_date')) {
            Log::info('Data de vencimento da tarefa alterada', [
                'task_id'      => $task->id,
                'user_id'      => $task->user_id,
                'title'        => $task->title,
                'old_due_date' => $task->getOriginal('due_date'),
                'new_due_date' => $task->due_date,
            ]);
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        Log::info('Tarefa excluída', [
            'task_id' => $task->id,
            'user_id' => $task->user_id,
            'title'   => $task->title,
        ]);
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        Log::info('Tarefa restaurada', [
            'task_id' => $task->id,
            'user_id' => $task->user_id,
            'title'   => $task->title,
        ]);
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        Log::info('Tarefa deletada permanentemente', [
            'task_id' => $task->id,
            'user_id' => $task->user_id,
            'title'   => $task->title,
        ]);
    }
}

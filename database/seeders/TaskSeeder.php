<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskFavorite;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Carrega usuários com seus perfis
        $users = User::with('profile')->get();

        // Se não houver usuários com perfis válidos, interrompe o seeder
        if ($users->isEmpty()) {
            $this->command->info('Nenhum usuário encontrado para criar tarefas.');

            return;
        }

        // Cria tarefas para cada usuário
        foreach ($users as $user) {
            // Determina o tipo de perfil com segurança
            $profileType = optional($user->profile)->type ?? 'member';

            // Número de tarefas com base no perfil do usuário
            $taskCount = match ($profileType) {
                'admin'   => 3,
                'manager' => 5,
                'member'  => 8,
                default   => 5
            };

            // Cria tarefas de cada status
            $this->createTasksForUser($user->id, $taskCount);
        }

        // Cria favoritos se houver tarefas
        $this->createFavorites($users);
    }

    /**
     * Cria tarefas para um usuário específico
     */
    private function createTasksForUser(int $userId, int $taskCount): void
    {
        // Cria tarefas pendentes
        Task::factory()
            ->count(rand(1, $taskCount))
            ->pending()
            ->withColor('Azul')
            ->create(['user_id' => $userId]);

        // Cria tarefas em andamento
        Task::factory()
            ->count(rand(1, max(1, $taskCount - 1)))
            ->inProgress()
            ->withColor('Verde')
            ->create(['user_id' => $userId]);

        // Cria tarefas concluídas
        Task::factory()
            ->count(rand(1, max(1, $taskCount - 2)))
            ->completed()
            ->withColor('Amarelo')
            ->create(['user_id' => $userId]);

        // Cria algumas tarefas atrasadas
        Task::factory()
            ->count(rand(0, 2))
            ->pending()
            ->withColor('Vermelho')
            ->create([
                'user_id'  => $userId,
                'due_date' => now()->subDays(rand(1, 10)),
            ]);
    }

    /**
     * Cria favoritos para os usuários
     */
    private function createFavorites($users): void
    {
        // Verifica se existem tarefas antes de tentar criar favoritos
        $taskCount = Task::count();

        if ($taskCount === 0) {
            return;
        }

        // Carrega todas as tarefas uma única vez para evitar múltiplas consultas
        $tasks = Task::select('id')->get();

        // Cada usuário favorita algumas tarefas aleatórias
        foreach ($users as $user) {
            // Determina quantas tarefas favoritar (até 5 ou o total disponível)
            $favoritesCount = rand(1, min(5, $taskCount));

            // Seleciona IDs aleatórios de tarefas para favoritar
            $taskIds = $tasks->random($favoritesCount)->pluck('id')->toArray();

            // Cria os registros de favoritos
            foreach ($taskIds as $taskId) {
                TaskFavorite::create([
                    'user_id' => $user->id,
                    'task_id' => $taskId,
                ]);
            }
        }
    }
}

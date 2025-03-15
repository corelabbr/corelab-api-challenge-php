<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = User::all();
        if ($user->isEmpty()) {
            return response()->json(['error' => 'Usuarios ainda nao cadastradas!'], 404);
        } else {
            try {
                return response()->json(['msg' => 'Usuarios localizados com sucesso!', 'user' => $user], 200);
            } catch (\Exception $e) {
                return response()->json(['msg' => 'Usuarios localizados com sucesso!' . $e->getMessage()], 500);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        #Gate::authorize('create', User::class);
        try {
            $request->validate([]);

            $user = User::create($request->all());
            return response()->json(['msg' => 'Tarefa criada com sucesso!', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar tarefa: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        try {
            return $user;
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('User não encontrada!', $exception->getCode(), $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            // Validação dos dados
            $request->validate([]);

            if (!$user) {
                return response()->json(['error' => 'User não encontrada.'], 404);
            } else {
                $user->update($request->all());
                return response()->json(['msg' => 'User atualizada com sucesso!', 'user' => $user], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar User: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
         try {
            if (!$user) {
                return response()->json(['error' => 'Tarefa não encontrada.'], 404);
            } else {
                $user->delete();
                return response()->json(['msg' => 'Tarefa excluída com sucesso!'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir tarefa: ' . $e->getMessage()], 500);
        }
    }
}

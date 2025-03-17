<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {      
        $user = User::query()->simplePaginate();
        if ($user->isEmpty()) {
            return response()->json(['error' => 'Usuarios ainda nao cadastradas!'], 404);
        }
        return UserResource::collection($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        #Gate::authorize('create', User::class);
        try {
            $request->validate([]);

            $user = User::create([
                'nomeUser' => $request->nomeUser,
                'email' => $request->email,
                'senha' => bcrypt($request->senha)
            ]);

            return UserResource::make($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar tarefa: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return UserResource::make($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {

            $user->delete();
            return response()->json(['msg' => 'Tarefa excluída com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir tarefa: ' . $e->getMessage()], 500);
        }
    }
}

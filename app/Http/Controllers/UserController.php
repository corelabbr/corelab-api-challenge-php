<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserValidateRequest;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {

        $request->merge(['password' => Hash::make($request->input('password'))]);
        $user = User::create($request->only(['name', 'email', 'telephone', 'birth_date', 'password']));

        return new UserResource($user);
    }

    public function validate(UserValidateRequest $request)
    {

        $user = User::where('email', $request->email)->firstOrFail();

        if (Hash::check($request->password, $user->password)) {
            return (new UserResource($user))->additional([
                'token'      => JWTAuth::fromUser($user),
                'token_type' => 'bearer',
                'success'    => 'Usuário autenticado'
            ]);
        } else {
            return response()->json(['message' => 'Senha inválida.'], 400);
        }
    }

    public function read()
    {
        return new UserResource(auth()->user());
    }

    public function delete()
    {
        $user = User::find(auth()->user()->id);
        $user->delete();
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['success' => 'Conta apagada com sucesso.'], 200);
    }

    public function update(UserUpdateRequest $request)
    {
        $user = User::findOrFail(auth()->user()->id);

        if ($request->filled('new_password')) {
            if($request->new_password == $request->current_password){
                return response()->json(['message' => 'A nova senha não pode ser igual a atual.'], 400);
            }
            if (Hash::check($request->current_password, $user->password)) {
                $request->merge(['password' => Hash::make($request->input('new_password'))]);
                $user->update($request->only(['name', 'telephone', 'email', 'password']));
            } else {
                return response()->json(['message' => 'Senha inválida ou nenhuma senha inserida'], 400);
            }
        }
        

        $user->update($request->only(['name', 'telephone', 'email']));
    
        return (new UserResource($user))->additional([
            "message" => "Dados atualizados com sucesso"
        ]);
    }

    public function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['success' => 'Logout bem sucedido.'], 200);
    }
}

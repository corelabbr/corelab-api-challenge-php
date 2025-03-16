<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\RegisterUserRequest;
use App\Http\Requests\V1\User\LoginUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request) 
    {
        $validated = Validator::make($request->all(), [
            'name' =>  'required',
            'email' =>  'email|required',
            'password' =>  'required',
            'c_password' => 'required|same:password'
        ]);

        if($validated->fails()) {
            return response()->json(['Registro não aprovado', $validated->errors()], 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('myApp')->plainTextToken;
        $success['name'] = $user['name'];   
        return response()->json(['message' => 'Usuário cadastrado com sucesso'], 200);
    }

    public function login(LoginUserRequest $request) 
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $success['token'] = $user->createToken('myApp')->plainTextToken;
            $success['name'] = $user['name'];
            return response()->json(['message' => 'Logado com sucesso', 'access_token' => $success['token'], "username" => $success['name']], 200);
        } else {
            return response()->json(['message' => 'E-mail ou senha incorretos'], 401);
        }
    }
}
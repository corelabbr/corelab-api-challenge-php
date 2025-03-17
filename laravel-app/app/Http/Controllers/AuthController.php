<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(AuthenticateRequest $request)
    {
        $request->validate([]);

    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->senha])) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

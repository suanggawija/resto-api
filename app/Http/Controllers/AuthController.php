<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserLoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',

        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provider credentials are incorect.']
            ]);
        }
        $user->tokens()->delete();
        $token = $user->createToken($request->email)->plainTextToken;
        $user->token = $token;

        // return $user;
        return new UserLoginResource($user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'logout success']);
    }

    public function me()
    {
        return response(['data' => auth()->user()]);
    }
}

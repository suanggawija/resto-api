<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CreateUserResource;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return UserResource::collection($user);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|max:255',
            'role_id' => 'required|' . Rule::in(['1', '2', '3', '4'])
        ]);

        $request['password'] = Hash::make($request->password);
        $user = User::create($request->all());

        return new CreateUserResource($user);
    }
}

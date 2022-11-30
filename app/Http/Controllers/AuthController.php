<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    //Login
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        //Credentials check
        if (!$token = auth()->attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        //Success message
        return $this->success([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    //register
    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());

        //Registratin of a new User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //Success message
        return $this->success([
            'user' => $user,
        ]);
    }

    //logout
    public function logout()
    {
        //Deleting User Sanctum Access Token
        Auth::logout();

        return $this->success([
            'message' => 'You are Logout...',
        ]);
    }
}

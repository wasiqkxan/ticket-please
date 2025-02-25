<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\APIResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginUserRequest;


class AuthController extends Controller
{
    use APIResponse;

    public function login(LoginUserRequest $request){
        $request->validated($request->all());

        if(!Auth::attempt($request->only('email', 'password'))){
            return $this->error('Invalid credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok('Authenticated', [
            'token' => $user->createToken(
                'API token for '.$user->email,
                ['*'],
                now()->addDays(7)
                )->plainTextToken
        ], 200);
    }

    public function logout(Request $request){
        // $request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();
        return $this->ok('Logged out successfully');
    }

    public function register(){
        return $this->ok('User registered successfully');
    }
}

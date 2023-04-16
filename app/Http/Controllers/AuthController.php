<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'errors' => [
                    'message' => [trans('resources.invalid_credentials')],
                ],
            ], 401);
        }
    
        $user = Auth::user();
        $token = Str::random(60);
 
        $request->user()->forceFill([
            'api_token' => $token,
        ])->save();

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function register(Request $request){
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('username', ''),
            'email' => $request->input('email', ''),
            'email_verified_at' => now(),
            'password' => Hash::make($request->input('password', '')),
        ]);

        return response()->json([
            'status' => 'success',
            'user' => $user,
        ], 201);
    }

    public function checkUser($user_id){
        $user = User::findOrFail($user_id);
        return response()->json([
            'user' => $user,
        ]);
    }
}

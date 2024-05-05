<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username'=>'required|unique:users,username',
            'new_password'=>'required',
        ]);

        $user = new User;
        $user->username = $request->input("username");
        $user->password = Hash::make($request->input("new_password"));
        $user->save();

        $token = $user->createToken("admin");
        return ['token' => $token->plainTextToken];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
    }
}

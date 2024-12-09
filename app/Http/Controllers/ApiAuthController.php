<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public  function register(Request $request)
    {
        $request->validate([
            "name" => "required|min:3",
            "email" => "required|email|unique:users",
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'user created successfully',
            "success" => true,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => 'required|email',
            "password" => 'required|min:8',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // $token = Auth::user()->createToken("phone")->plainTextToken;
            $token = $request->user()->createToken("phone")->plainTextToken;
            return  response()->json([
                'message' => 'Login successfully',
                'success' => true,
                "token" => $token,
                'auth' => new UserResource(Auth::user())
            ]);
        }
        return response()->json(['message' => 'user not found', 'success' => false], 401);
    }
    public  function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logout successfully',
            'success' => true,
        ]);
    }


    public  function logoutAll()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'logout success'], 204);
    }


    public  function tokens()
    {
        return Auth::user()->tokens;
    }
}

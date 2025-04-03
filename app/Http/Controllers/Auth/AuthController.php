<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
     public function selectAccount(Request $request)
     {
         $request->validate([
             'role' => 'required|in:doctor,medical_representative'
         ]);

         return response()->json(['message' => 'Account type selected', 'role' => $request->role]);
     }

     public function register(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'username' => 'required|string|unique:users',
             'email' => 'required|email|unique:users',
             'password' => 'required|min:6|confirmed',
             'role' => 'required|in:doctor,medical_representative'
         ]);

         $user = User::create([
             'name' => $request->name,
             'username' => $request->username,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'role' => $request->role
         ]);

         $token = $user->createToken('auth_token')->plainTextToken;

         return response()->json([
             'message' => 'Registration successful',
             'user' => $user,
             'token' => $token
         ], 201);
     }

     public function login(Request $request)
     {
         $request->validate([
             'username' => 'required',
             'password' => 'required'
         ]);

         $user = User::where('username', $request->username)->first();

         if (!$user || !Hash::check($request->password, $user->password)) {
             throw ValidationException::withMessages([
                 'username' => ['Invalid credentials'],
             ]);
         }

         $token = $user->createToken('auth_token')->plainTextToken;

         return response()->json([
             'message' => 'Login successful',
             'user' => $user,
             'token' => $token
         ], 200);
     }
}

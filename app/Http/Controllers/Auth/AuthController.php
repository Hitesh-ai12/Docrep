<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;


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
         $validator = Validator::make($request->all(), [
             'name' => 'required|string|max:255',
             'username' => [
                 'required', 'string', 'max:50', 'unique:users,username',
                 'regex:/^[a-zA-Z0-9_.]+$/'
             ],
             'email' => 'required|email|max:255|unique:users,email',
             'password' => [
                 'required', 'string', 'min:6', 'confirmed',
                 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'
             ],
             'role' => 'required|in:doctor,medical_representative',
         ], [
             'username.regex' => 'The username may only contain letters, numbers, underscores, and dots.',
             'password.regex' => 'The password must contain at least one letter and one number.',
         ]);

         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }

         $user = User::create([
             'name' => $request->name,
             'username' => $request->username,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'role' => $request->role,
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
             'password' => 'required',
             'role' => 'required' // Role bhi required hai
         ]);

         $user = User::where('username', $request->username)
                     ->where('role', $request->role) // Role check karein
                     ->first();

         if (!$user || !Hash::check($request->password, $user->password)) {
             return response()->json(['error' => 'Invalid credentials or role mismatch'], 401);
         }

         $token = $user->createToken('auth_token')->plainTextToken;

         return response()->json([
             'message' => 'Login successful',
             'user' => $user,
             'token' => $token
         ], 200);
     }



     public function logout(Request $request)
        {
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'Logout successful'
            ], 200);
        }

        public function forgotPassword(Request $request)
        {
            $request->validate([
                'email' => 'required|email|exists:users,email'
            ]);

            $otp = rand(100000, 999999);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $otp, 'created_at' => Carbon::now()]
            );

            Mail::raw("Your OTP for password reset is: $otp", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Password Reset OTP');
            });

            return response()->json(['message' => 'OTP sent to your email'], 200);
        }

        public function verifyOtp(Request $request)
        {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|digits:6'
            ]);

            $otpData = DB::table('password_reset_tokens')
                        ->where('email', $request->email)
                        ->where('token', $request->otp)
                        ->first();

            if (!$otpData) {
                return response()->json(['message' => 'Invalid OTP'], 400);
            }

            return response()->json(['message' => 'OTP verified successfully'], 200);
        }
        public function resetPassword(Request $request)
        {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|digits:6',
                'password' => 'required|string|min:6|confirmed'
            ]);

            $otpData = DB::table('password_reset_tokens')
                         ->where('email', $request->email)
                         ->where('token', $request->otp)
                         ->first();

            if (!$otpData) {
                return response()->json(['message' => 'Invalid OTP'], 400);
            }

            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return response()->json(['message' => 'Password reset successfully'], 200);
        }
        public function getAllDoctors(Request $request)
        {
            // Get all users with role 'doctor'
            $doctors = User::where('role', 'doctor')->get();

            if ($doctors->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No doctors found.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Doctors fetched successfully.',
                'data' => $doctors
            ], 200);
        }

}

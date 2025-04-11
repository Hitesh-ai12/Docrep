<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WebAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function redirectTo()
    {
        return '/admin/dashboard';
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Only admins can login.']);
            }

            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid login credentials.']);
    }
}

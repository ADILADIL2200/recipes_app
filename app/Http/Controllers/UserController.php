<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function showSignup()
    {
        return view('signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect('/login')->with('success', 'Account created');
    }

    public function showLogin()
    {
        return view('login');
    }

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // ✅ prevents session fixation
        return redirect()->route('home');
    }

    return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();    // ✅ clear session
    $request->session()->regenerateToken(); // ✅ reset CSRF token
    return redirect()->route('login');
} 
}
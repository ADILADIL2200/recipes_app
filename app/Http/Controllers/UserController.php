<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // ── Signup ────────────────────────────────────────
    public function showSignup()
    {
        return view('signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // cast 'hashed' gère le hash
            'role'     => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Compte créé ! Connectez-vous.');
    }

    // ── Login ─────────────────────────────────────────
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirection selon le rôle
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('home'));
        }

        return back()
            ->withErrors(['email' => 'Email ou mot de passe incorrect.'])
            ->onlyInput('email');
    }

    // ── Logout ────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ── Profil ────────────────────────────────────────
    public function showProfile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'bio'      => 'nullable|string|max:500',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'bio');

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return back()->with('success', 'Profil mis à jour !');
    }
}

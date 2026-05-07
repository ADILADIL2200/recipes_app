<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;                    // Hash::make retiré, plus besoin
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function showSignup()
    {
        return view('signup');     // ← renommé auth.signup (bonne pratique)
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // ← min:6 → min:8
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // ← Hash::make retiré, cast 'hashed' s'en charge
            'role'     => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Compte créé !');
    }

    public function showLogin()
    {
        return view('login');      // ← renommé auth.login
    }

    public function login(Request $request)
    {
        $request->validate([           // ← NOUVEAU : validation avant attempt
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home')); // ← intended() au lieu de route()
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])
                     ->onlyInput('email'); // ← NOUVEAU : garde l'email dans le champ
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ── Profil ─────────────────────────────────── NOUVEAU

    public function showProfile()
    {
        return view('profile.edit', ['user' => Auth::user()]);
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
        // Supprimer l'ancien avatar s'il existe  ← NOUVEAU
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
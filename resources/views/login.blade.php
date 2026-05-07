@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 w-full max-w-md">

        {{-- Logo / Titre --}}
        <div class="text-center mb-8">
            <div class="text-4xl mb-2">🍽️</div>
            <h1 class="text-2xl font-semibold text-gray-800">Bon retour !</h1>
            <p class="text-gray-500 text-sm mt-1">Connectez-vous à votre compte</p>
        </div>

        {{-- Message succès (après inscription) --}}
        @if(session('success'))
            <div class="bg-green-50 text-green-700 border border-green-200 rounded-lg px-4 py-3 mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Erreurs --}}
        @if($errors->any())
            <div class="bg-red-50 text-red-700 border border-red-200 rounded-lg px-4 py-3 mb-6 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Formulaire --}}
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                    placeholder="vous@exemple.com"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                    placeholder="••••••••"
                >
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded">
                    Se souvenir de moi
                </label>
                <a href="{{ route('password.request') }}" class="text-green-600 hover:underline">
                    Mot de passe oublié ?
                </a>
            </div>

            <button
                type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 rounded-lg text-sm transition"
            >
                Se connecter
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Pas encore de compte ?
            <a href="{{ route('signup') }}" class="text-green-600 hover:underline font-medium">S'inscrire</a>
        </p>

    </div>
</div>
@endsection
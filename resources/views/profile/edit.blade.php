@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-2xl mx-auto px-4">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-800">Mon Profil</h1>
            <p class="text-gray-500 text-sm mt-1">Gérez vos informations personnelles</p>
        </div>

        {{-- Message succès --}}
        @if(session('success'))
            <div class="bg-green-50 text-green-700 border border-green-200 rounded-lg px-4 py-3 mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Erreurs --}}
        @if($errors->any())
            <div class="bg-red-50 text-red-700 border border-red-200 rounded-lg px-4 py-3 mb-6 text-sm">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST"
              enctype="multipart/form-data"
              class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Avatar --}}
            <div class="flex items-center gap-6">
                <div class="relative">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}"
                             alt="Avatar"
                             class="w-20 h-20 rounded-full object-cover border-2 border-gray-100">
                    @else
                        <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center text-2xl font-semibold text-green-700">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Changer l'avatar
                    </label>
                    <input type="file"
                           name="avatar"
                           accept="image/jpg,image/jpeg,image/png,image/webp"
                           class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — max 2MB</p>
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Nom --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       required
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       required
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
            </div>

            {{-- Bio --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                <textarea name="bio"
                          rows="3"
                          maxlength="500"
                          class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent resize-none"
                          placeholder="Parlez-nous de vous...">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Max 500 caractères</p>
            </div>

            <hr class="border-gray-100">

            {{-- Mot de passe --}}
            <div>
                <h2 class="text-sm font-medium text-gray-700 mb-4">
                    Changer le mot de passe
                    <span class="text-gray-400 font-normal">(laisser vide pour ne pas changer)</span>
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nouveau mot de passe
                        </label>
                        <input type="password"
                               name="password"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                               placeholder="Minimum 8 caractères">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmer le mot de passe
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                               placeholder="Répétez le mot de passe">
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('home') }}"
                   class="text-sm text-gray-500 hover:text-gray-700">
                    ← Retour
                </a>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2.5 rounded-lg text-sm transition">
                    Enregistrer les modifications
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
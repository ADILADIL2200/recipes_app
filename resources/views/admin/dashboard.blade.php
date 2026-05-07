@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-5xl mx-auto px-4">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Panel Admin</h1>
                <p class="text-gray-500 text-sm mt-1">Vue d'ensemble de l'application</p>
            </div>
            <a href="{{ route('home') }}" class="text-sm text-green-600 hover:underline">← Retour au site</a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @foreach([
                ['label' => 'Utilisateurs',  'value' => $stats['total_users'],      'color' => 'blue'],
                ['label' => 'Recettes',       'value' => $stats['total_recipes'],    'color' => 'green'],
                ['label' => 'Catégories',     'value' => $stats['total_categories'], 'color' => 'purple'],
                ['label' => 'Tags',           'value' => $stats['total_tags'],       'color' => 'yellow'],
            ] as $stat)
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <div class="text-2xl font-semibold text-gray-800">{{ $stat['value'] }}</div>
                <div class="text-sm text-gray-500 mt-1">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>

        {{-- Navigation --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.users') }}"
               class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:border-green-300 transition">
                <div class="text-2xl mb-2">👥</div>
                <div class="font-medium text-gray-800">Gérer les utilisateurs</div>
                <div class="text-sm text-gray-500 mt-1">Rôles, activation, suppression</div>
            </a>
            <a href="{{ route('admin.categories') }}"
               class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:border-green-300 transition">
                <div class="text-2xl mb-2">📂</div>
                <div class="font-medium text-gray-800">Gérer les catégories</div>
                <div class="text-sm text-gray-500 mt-1">Créer, modifier, supprimer</div>
            </a>
            <a href="{{ route('admin.tags') }}"
               class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:border-green-300 transition">
                <div class="text-2xl mb-2">🏷️</div>
                <div class="font-medium text-gray-800">Gérer les tags</div>
                <div class="text-sm text-gray-500 mt-1">Créer, modifier, supprimer</div>
            </a>
        </div>

    </div>
</div>
@endsection
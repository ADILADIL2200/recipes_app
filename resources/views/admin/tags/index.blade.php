@extends('layouts.app')
@section('title', 'Tags')
@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-4xl mx-auto px-4">

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-800">Tags</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-green-600 hover:underline">← Dashboard</a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 border border-green-200 rounded-lg px-4 py-3 mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulaire création --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <h2 class="text-base font-medium text-gray-800 mb-4">Nouveau tag</h2>
            <form action="{{ route('admin.tags.store') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="name" placeholder="Nom du tag"
                    class="border border-gray-200 rounded-lg px-4 py-2 text-sm flex-1 focus:outline-none focus:ring-2 focus:ring-green-400"
                    required>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                    Ajouter
                </button>
            </form>
        </div>

        {{-- Liste --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Nom</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Slug</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Recettes</th>
                        <th class="text-right px-6 py-3 text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($tags as $tag)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $tag->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $tag->slug }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $tag->recipes_count }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Edit --}}
                                <form action="{{ route('admin.tags.update', $tag) }}" method="POST"
                                      class="flex gap-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" value="{{ $tag->name }}"
                                        class="border border-gray-200 rounded-lg px-3 py-1 text-xs w-32 focus:outline-none focus:ring-1 focus:ring-green-400">
                                    <button type="submit"
                                        class="text-xs px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-600">
                                        Modifier
                                    </button>
                                </form>
                                {{-- Delete --}}
                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST"
                                      onsubmit="return confirm('Supprimer ce tag ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs px-3 py-1.5 rounded-lg border border-red-200 hover:bg-red-50 text-red-600">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $tags->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
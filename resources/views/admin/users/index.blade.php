@extends('layouts.app')
@section('title', 'Utilisateurs')
@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-5xl mx-auto px-4">

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-800">Utilisateurs</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-green-600 hover:underline">← Dashboard</a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 border border-green-200 rounded-lg px-4 py-3 mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 text-red-700 border border-red-200 rounded-lg px-4 py-3 mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Nom</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Email</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Rôle</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Inscrit le</th>
                        <th class="text-right px-6 py-3 text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Toggle rôle --}}
                                <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="text-xs px-3 py-1.5 rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-600">
                                        {{ $user->role === 'admin' ? '→ User' : '→ Admin' }}
                                    </button>
                                </form>
                                {{-- Supprimer --}}
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs px-3 py-1.5 rounded-lg border border-red-200 hover:bg-red-50 text-red-600">
                                        Supprimer
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
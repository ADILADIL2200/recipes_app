{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('styles')
<style>
.admin-page-head { margin-bottom: 2rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.admin-page-head h1 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 600; color: var(--ink); }
.admin-page-head h1 em { font-style: italic; color: var(--accent); }
.admin-page-head p { font-size: .88rem; color: var(--ink-3); margin-top: .25rem; }
.table-panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; }
.table-actions { display: flex; align-items: center; gap: .5rem; justify-content: flex-end; }
.pagination-wrap { padding: 1rem 1.5rem; border-top: 1px solid var(--border); }
.user-avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--accent-lt); display: flex; align-items: center; justify-content: center; font-family: 'Cormorant Garamond', serif; font-size: .95rem; font-weight: 600; color: var(--accent); flex-shrink: 0; overflow: hidden; }
.user-avatar img { width: 100%; height: 100%; object-fit: cover; }
.user-cell { display: flex; align-items: center; gap: .75rem; }
.user-cell-name { font-weight: 500; color: var(--ink); font-size: .88rem; }
.user-cell-date { font-size: .75rem; color: var(--ink-3); }
</style>
@endsection

@section('content')
<div class="page-wrap">

    <div class="admin-page-head">
        <div>
            <div style="display:inline-block;width:36px;height:3px;background:var(--accent);border-radius:2px;margin-bottom:.65rem"></div>
            <h1><em>Utilisateurs</em></h1>
            <p>Gestion des comptes et des rôles</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">&larr; Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="table-panel">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>E-mail</th>
                    <th>Rôle</th>
                    <th>Inscrit le</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                            </div>
                            <span class="user-cell-name">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="color:var(--ink-2);font-size:.86rem">{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'badge-accent' : 'badge-muted' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td><span class="user-cell-date">{{ $user->created_at->format('d/m/Y') }}</span></td>
                    <td>
                        <div class="table-actions">
                            <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-ghost btn-sm">
                                    {{ $user->role === 'admin' ? 'Rétrograder' : 'Promouvoir admin' }}
                                </button>
                            </form>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Supprimer « {{ $user->name }} » définitivement ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $users->links() }}</div>
    </div>

</div>
@endsection

{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Catégories')

@section('styles')
<style>
.admin-page-head { margin-bottom: 2rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.admin-page-head h1 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 600; color: var(--ink); }
.admin-page-head h1 em { font-style: italic; color: var(--accent); }
.admin-page-head p { font-size: .88rem; color: var(--ink-3); margin-top: .25rem; }

.create-panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; margin-bottom: 1.5rem; }
.create-panel-head { padding: 1.1rem 1.75rem; border-bottom: 1px solid var(--border); background: #faf7f3; }
.create-panel-head h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.05rem; font-weight: 600; color: var(--ink); }
.create-panel-body { padding: 1.5rem 1.75rem; }
.create-form-row { display: flex; gap: .75rem; flex-wrap: wrap; align-items: flex-end; }
.create-form-row .form-field { flex: 1; min-width: 160px; margin: 0; }
.create-form-row .form-field.narrow { flex: 0 0 100px; min-width: 80px; }

.table-panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; }
.table-actions { display: flex; align-items: center; gap: .5rem; justify-content: flex-end; }
.inline-edit-form { display: flex; align-items: center; gap: .4rem; }
.inline-edit-form input { width: 140px; padding: .38rem .7rem; font-size: .82rem; border: 1.5px solid var(--border); border-radius: var(--r-sm); background: var(--bg); color: var(--ink); font-family: 'Outfit', sans-serif; outline: none; transition: border-color .15s; }
.inline-edit-form input:focus { border-color: var(--accent); }

.pagination-wrap { padding: 1rem 1.5rem; border-top: 1px solid var(--border); }
</style>
@endsection

@section('content')
<div class="page-wrap">

    <div class="admin-page-head">
        <div>
            <div style="display:inline-block;width:36px;height:3px;background:var(--accent);border-radius:2px;margin-bottom:.65rem"></div>
            <h1><em>Catégories</em></h1>
            <p>Organisez les recettes par catégorie</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">&larr; Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Create form --}}
    <div class="create-panel">
        <div class="create-panel-head">
            <h3>Nouvelle catégorie</h3>
        </div>
        <div class="create-panel-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="create-form-row">
                    <div class="form-field">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" class="form-input" placeholder="ex. Desserts" required>
                    </div>
                    <div class="form-field narrow">
                        <label class="form-label">Icône</label>
                        <input type="text" name="icon" class="form-input" placeholder="ex. cake">
                    </div>
                    <div class="form-field" style="flex:2">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-input" placeholder="Courte description">
                    </div>
                    <button type="submit" class="btn btn-primary" style="height:42px;align-self:flex-end">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-panel">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Icône</th>
                    <th>Nom</th>
                    <th>Recettes</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td style="color:var(--ink-3);font-size:.88rem;width:60px">{{ $category->icon ?? '—' }}</td>
                    <td style="font-weight:500;color:var(--ink)">{{ $category->name }}</td>
                    <td><span class="badge badge-muted">{{ $category->recipes_count }}</span></td>
                    <td>
                        <div class="table-actions">
                            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="inline-edit-form">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $category->name }}" required>
                                <button type="submit" class="btn btn-ghost btn-sm">Modifier</button>
                            </form>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                  onsubmit="return confirm('Supprimer « {{ $category->name }} » ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $categories->links() }}</div>
    </div>

</div>
@endsection

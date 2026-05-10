{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Administration')

@section('styles')
<style>
.admin-header { margin-bottom: 2.5rem; display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.admin-header h1 { font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; font-weight: 600; color: var(--ink); }
.admin-header h1 em { font-style: italic; color: var(--accent); }
.admin-header p { font-size: .9rem; color: var(--ink-3); margin-top: .3rem; }

.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2.5rem; }
.stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 1.5rem; }
.stat-card .stat-val { font-family: 'Cormorant Garamond', serif; font-size: 2.4rem; font-weight: 600; color: var(--ink); line-height: 1; }
.stat-card .stat-label { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; color: var(--ink-3); margin-top: .4rem; }
.stat-card .stat-bar { height: 2px; border-radius: 2px; background: var(--accent); margin-top: 1rem; }

.admin-nav-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
.admin-nav-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 1.75rem; text-decoration: none; color: inherit; transition: border-color .18s, box-shadow .18s, transform .18s; display: block; }
.admin-nav-card:hover { border-color: var(--accent); box-shadow: 0 6px 24px rgba(184,74,28,.1); transform: translateY(-2px); }
.admin-nav-card .nav-card-icon { width: 44px; height: 44px; border-radius: var(--r-md); background: var(--accent-lt); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
.admin-nav-card .nav-card-icon svg { width: 20px; height: 20px; stroke: var(--accent); }
.admin-nav-card h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 600; color: var(--ink); margin-bottom: .3rem; }
.admin-nav-card p { font-size: .82rem; color: var(--ink-3); line-height: 1.5; }
.admin-nav-card .nav-card-arrow { font-size: .78rem; color: var(--accent); margin-top: .75rem; font-weight: 500; }

@media (max-width: 900px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .admin-nav-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="page-wrap">

    <div class="admin-header">
        <div>
            <div style="display:inline-block;width:36px;height:3px;background:var(--accent);border-radius:2px;margin-bottom:.75rem"></div>
            <h1>Panel <em>Administration</em></h1>
            <p>Vue d'ensemble et gestion de la plateforme Saveur</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">&larr; Retour au site</a>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        @foreach([
            ['label' => 'Utilisateurs',  'value' => $stats['total_users'],      'w' => '40%'],
            ['label' => 'Recettes',       'value' => $stats['total_recipes'],    'w' => '65%'],
            ['label' => 'Catégories',     'value' => $stats['total_categories'], 'w' => '30%'],
            ['label' => 'Tags',           'value' => $stats['total_tags'],       'w' => '55%'],
        ] as $s)
        <div class="stat-card">
            <div class="stat-val">{{ $s['value'] }}</div>
            <div class="stat-label">{{ $s['label'] }}</div>
            <div class="stat-bar" style="width:{{ $s['w'] }}"></div>
        </div>
        @endforeach
    </div>

    {{-- Navigation --}}
    <div style="margin-bottom:1.25rem">
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:600;color:var(--ink)">Gestion</h2>
    </div>
    <div class="admin-nav-grid">

        <a href="{{ route('admin.users') }}" class="admin-nav-card">
            <div class="nav-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
            </div>
            <h3>Utilisateurs</h3>
            <p>Gérer les rôles, consulter les comptes et supprimer des utilisateurs.</p>
            <div class="nav-card-arrow">Gérer &rarr;</div>
        </a>

        <a href="{{ route('admin.categories') }}" class="admin-nav-card">
            <div class="nav-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" /></svg>
            </div>
            <h3>Catégories</h3>
            <p>Créer, modifier et supprimer les catégories de recettes.</p>
            <div class="nav-card-arrow">Gérer &rarr;</div>
        </a>

        <a href="{{ route('admin.tags') }}" class="admin-nav-card">
            <div class="nav-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
            </div>
            <h3>Tags</h3>
            <p>Gérer les étiquettes pour faciliter la recherche et la navigation.</p>
            <div class="nav-card-arrow">Gérer &rarr;</div>
        </a>

    </div>

</div>
@endsection

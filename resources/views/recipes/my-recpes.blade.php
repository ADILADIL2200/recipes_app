{{-- resources/views/recipes/my-recipes.blade.php --}}
@extends('layouts.app')

@section('title', isset($pageTitle) ? $pageTitle . ' — Cuisto' : 'Mes recettes — Cuisto')

@section('styles')
<style>
.my-recipes-header {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 3rem 2.5rem 2rem;
}
.my-recipes-header-inner {
    max-width: 1180px; margin: 0 auto;
    display: flex; align-items: flex-end; justify-content: space-between; gap: 1.5rem;
    flex-wrap: wrap;
}
.my-recipes-eyebrow { width: 32px; height: 2px; background: var(--accent); border-radius: 2px; margin-bottom: .9rem; }
.my-recipes-header h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.4rem; font-weight: 600; color: var(--ink);
    line-height: 1.1; letter-spacing: -.015em;
}
.my-recipes-header h1 em { font-style: italic; color: var(--accent); font-weight: 400; }
.my-recipes-header p { font-size: .875rem; color: var(--ink-3); font-weight: 300; margin-top: .35rem; }

/* Stats row */
.stats-strip {
    background: #faf7f2;
    border-bottom: 1px solid var(--border);
    padding: .9rem 2.5rem;
}
.stats-strip-inner {
    max-width: 1180px; margin: 0 auto;
    display: flex; align-items: center; gap: 2.5rem; flex-wrap: wrap;
}
.stat-item { display: flex; align-items: center; gap: .55rem; font-size: .82rem; color: var(--ink-3); }
.stat-item strong { color: var(--ink-2); font-weight: 600; font-size: .88rem; }

/* Body */
.my-recipes-body { max-width: 1180px; margin: 0 auto; padding: 2.5rem 2.5rem 5rem; }

/* Tabs */
.tab-bar { display: flex; gap: .35rem; margin-bottom: 2rem; background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-md); padding: .3rem; width: fit-content; }
.tab-btn {
    padding: .48rem 1.2rem; border-radius: calc(var(--r-md) - 3px);
    font-size: .82rem; font-weight: 500; cursor: pointer;
    border: none; background: transparent; color: var(--ink-3);
    transition: all .18s; font-family: 'DM Sans', sans-serif;
    text-decoration: none;
}
.tab-btn.active, .tab-btn:hover { background: var(--accent); color: #fff; }

/* Table layout for my recipes */
.recipes-table-wrap {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
}
.recipes-table { width: 100%; border-collapse: collapse; }
.recipes-table thead th {
    background: #faf7f2; border-bottom: 1px solid var(--border);
    padding: .85rem 1.25rem; text-align: left;
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .09em; color: var(--ink-3);
}
.recipes-table tbody td {
    padding: 1rem 1.25rem; border-bottom: 1px solid var(--border-lt);
    vertical-align: middle;
}
.recipes-table tbody tr:last-child td { border-bottom: none; }
.recipes-table tbody tr:hover td { background: #fdfaf5; }

.recipe-row-img {
    width: 56px; height: 42px; border-radius: var(--r-sm);
    object-fit: cover; background: var(--bg);
    display: block; flex-shrink: 0;
}
.recipe-row-placeholder {
    width: 56px; height: 42px; border-radius: var(--r-sm);
    background: linear-gradient(135deg, #e8ddd0, #d4c8b8);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.recipe-row-placeholder svg { color: #c0b4a4; }
.recipe-row-name {
    font-family: 'Cormorant Garamond', serif;
    font-weight: 600; color: var(--ink); font-size: 1rem;
    text-decoration: none; transition: color .18s;
}
.recipe-row-name:hover { color: var(--accent); }
.recipe-row-meta { font-size: .75rem; color: var(--ink-3); margin-top: .2rem; }

.actions-cell { display: flex; align-items: center; gap: .5rem; }

/* Card grid mode */
.recipes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}
.recipe-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r-lg); overflow: hidden;
    text-decoration: none; display: flex; flex-direction: column;
    transition: transform .3s ease, box-shadow .3s ease;
}
.recipe-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(26,21,16,.12); }
.recipe-card-img {
    aspect-ratio: 16/10; background: linear-gradient(135deg, #e8ddd0, #d4c8b8);
    position: relative; overflow: hidden;
}
.recipe-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
.recipe-card:hover .recipe-card-img img { transform: scale(1.06); }
.recipe-card-img-empty { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
.recipe-card-img-empty svg { color: #c0b4a4; }
.recipe-cat { position: absolute; top: .75rem; left: .75rem; background: var(--accent); color: #fff; font-size: .63rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; padding: .22rem .65rem; border-radius: 999px; }
.recipe-card-body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; }
.recipe-card-title { font-family: 'Cormorant Garamond', serif; font-size: 1.12rem; font-weight: 600; color: var(--ink); line-height: 1.3; margin-bottom: .75rem; transition: color .18s; }
.recipe-card:hover .recipe-card-title { color: var(--accent); }
.recipe-card-actions { display: flex; gap: .5rem; margin-top: auto; padding-top: .9rem; border-top: 1px solid var(--border-lt); }

/* Empty */
.empty-state { text-align: center; padding: 5rem 2rem; color: var(--ink-3); }
.empty-state svg { margin: 0 auto 1.5rem; opacity: .25; }
.empty-state h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 600; color: var(--ink-2); margin-bottom: .5rem; }
.empty-state p { font-size: .88rem; margin-bottom: 1.75rem; }

@media (max-width: 768px) {
    .my-recipes-header { padding: 2rem 1.25rem; }
    .stats-strip { padding: .9rem 1.25rem; }
    .my-recipes-body { padding: 2rem 1.25rem 4rem; }
    .recipes-grid { grid-template-columns: 1fr 1fr; }
    .recipes-table thead { display: none; }
    .recipes-table tbody td { display: block; padding: .5rem 1rem; border: none; }
    .recipes-table tbody td:first-child { padding-top: 1rem; }
    .recipes-table tbody td:last-child { padding-bottom: 1rem; }
    .recipes-table tbody tr { border-bottom: 1px solid var(--border-lt); }
}
@media (max-width: 480px) { .recipes-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')

<div class="my-recipes-header">
    <div class="my-recipes-header-inner">
        <div>
            <div class="my-recipes-eyebrow"></div>
            @if(isset($pageTitle) && $pageTitle === 'Mes favoris')
                <h1>Mes <em>favoris</em></h1>
                <p>Vos recettes préférées, sauvegardées pour cuisiner plus tard</p>
            @else
                <h1>Mes <em>recettes</em></h1>
                <p>Gérez et organisez vos créations culinaires</p>
            @endif
        </div>
        @if(!isset($pageTitle) || $pageTitle !== 'Mes favoris')
        <a href="{{ route('recipes.create') }}" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouvelle recette
        </a>
        @else
        <a href="{{ route('recipes.index') }}" class="btn btn-ghost">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Parcourir les recettes
        </a>
        @endif
    </div>
</div>

<div class="stats-strip">
    <div class="stats-strip-inner">
        <div class="stat-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Z"/></svg>
            <strong>{{ $recipes->total() }}</strong> recette{{ $recipes->total() > 1 ? 's' : '' }}
        </div>
        @if(isset($totalViews))
        <div class="stat-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            <strong>{{ number_format($totalViews) }}</strong> vues
        </div>
        @endif
        @if(isset($totalFavorites))
        <div class="stat-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            <strong>{{ number_format($totalFavorites) }}</strong> favoris
        </div>
        @endif
    </div>
</div>

<div class="my-recipes-body">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Onglets --}}
    <div class="tab-bar" style="margin-bottom:2rem">
        <a href="{{ route('recipes.my') }}"
           class="tab-btn {{ (!isset($pageTitle) || $pageTitle === 'Mes recettes') ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:.3rem"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Z"/></svg>
            Mes recettes
        </a>
        <a href="{{ route('recipes.favorites') }}"
           class="tab-btn {{ isset($pageTitle) && $pageTitle === 'Mes favoris' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:.3rem"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            Favoris
        </a>
    </div>

    @if($recipes->isNotEmpty())

        <div class="recipes-grid">
            @foreach($recipes as $recipe)
            <div class="recipe-card" style="text-decoration:none;color:inherit">
                <a href="{{ route('recipes.show', $recipe) }}" style="text-decoration:none;color:inherit;display:contents">
                    <div class="recipe-card-img">
                        @if($recipe->image)
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" loading="lazy">
                        @else
                            <div class="recipe-card-img-empty">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Z"/></svg>
                            </div>
                        @endif
                        @if($recipe->category)
                            <span class="recipe-cat">{{ $recipe->category->name }}</span>
                        @endif
                    </div>
                </a>
                <div class="recipe-card-body">
                    <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card-title">{{ $recipe->title }}</a>
                    <div class="recipe-card-actions">
                        <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Modifier
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Supprimer cette recette ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top:2.5rem;display:flex;justify-content:center">
            {{ $recipes->links() }}
        </div>

    @else
        <div class="empty-state">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/>
                <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Z"/>
            </svg>
            <h3>Aucune recette pour l'instant</h3>
            <p>Partagez votre première création culinaire avec la communauté.</p>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary">Créer ma première recette</a>
        </div>
    @endif

</div>
@endsection

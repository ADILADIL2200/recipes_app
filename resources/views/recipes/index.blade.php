{{-- resources/views/recipes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Parcourir les recettes — Cuisto')

@section('styles')
<style>
/* ── Page header ── */
.recipes-header {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 3rem 2.5rem 2.5rem;
}
.recipes-header-inner { max-width: 1180px; margin: 0 auto; }
.recipes-header-eyebrow { width: 32px; height: 2px; background: var(--accent); border-radius: 2px; margin-bottom: .9rem; }
.recipes-header h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.4rem; font-weight: 600; color: var(--ink);
    line-height: 1.1; margin-bottom: .4rem; letter-spacing: -.015em;
}
.recipes-header h1 em { font-style: italic; color: var(--accent); font-weight: 400; }
.recipes-header p { font-size: .9rem; color: var(--ink-3); font-weight: 300; }

/* ── Filters bar ── */
.filters-bar {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 1rem 2.5rem;
    position: sticky; top: 66px; z-index: 100;
}
.filters-inner {
    max-width: 1180px; margin: 0 auto;
    display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
}
.search-wrap { position: relative; flex: 1; min-width: 220px; max-width: 360px; }
.search-wrap svg { position: absolute; left: .9rem; top: 50%; transform: translateY(-50%); color: var(--ink-3); pointer-events: none; }
.search-input {
    width: 100%; padding: .62rem 1rem .62rem 2.5rem;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: 999px; font-family: 'DM Sans', sans-serif;
    font-size: .85rem; color: var(--ink); outline: none;
    transition: border-color .18s, box-shadow .18s;
}
.search-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(184,74,28,.09); background: #fff; }
.search-input::placeholder { color: #c0b4a4; }

.filter-select {
    padding: .6rem 2.2rem .6rem .9rem;
    background: var(--bg);
    border: 1.5px solid var(--border);
    border-radius: 999px;
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem; color: var(--ink-2); cursor: pointer; outline: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%239a8e7e' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right .7rem center;
    transition: border-color .18s;
}
.filter-select:focus { border-color: var(--accent); }

.filter-chip {
    display: inline-flex; align-items: center;
    padding: .5rem 1.1rem; border-radius: 999px;
    font-size: .8rem; font-weight: 500; cursor: pointer;
    border: 1.5px solid var(--border);
    background: var(--surface); color: var(--ink-2);
    text-decoration: none; transition: all .18s; white-space: nowrap;
}
.filter-chip:hover, .filter-chip.active { background: var(--accent); color: #fff; border-color: var(--accent); }

/* ── Recipe grid ── */
.recipes-body { max-width: 1180px; margin: 0 auto; padding: 2.5rem 2.5rem 5rem; }

.recipes-meta {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.75rem;
}
.recipes-count { font-size: .82rem; color: var(--ink-3); }
.recipes-count strong { color: var(--ink-2); font-weight: 600; }

.recipes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

/* ── Recipe card ── */
.recipe-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    text-decoration: none;
    display: flex; flex-direction: column;
    transition: transform .35s cubic-bezier(.4,0,.2,1), box-shadow .35s cubic-bezier(.4,0,.2,1), border-color .2s;
    position: relative;
}
.recipe-card:hover { transform: translateY(-5px); box-shadow: 0 20px 52px rgba(26,21,16,.13); border-color: rgba(184,74,28,.25); }
.diff-easy   { background: #eaf2e8; color: #3d5c36; }
.diff-medium { background: #fef6e4; color: #a87d1f; }
.diff-hard   { background: #fdf0ef; color: #c0392b; }

.recipe-card-img {
    aspect-ratio: 16/10;
    background: linear-gradient(135deg, #e8ddd0, #d4c8b8);
    position: relative; overflow: hidden;
}
.recipe-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
.recipe-card:hover .recipe-card-img img { transform: scale(1.06); }
.recipe-card-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
}
.recipe-card-img-placeholder svg { color: #c0b4a4; }

.recipe-cat {
    position: absolute; top: .75rem; left: .75rem;
    background: var(--accent); color: #fff;
    font-size: .65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    padding: .22rem .65rem; border-radius: 999px;
}

.recipe-card-body { padding: 1.25rem 1.25rem 1rem; flex: 1; display: flex; flex-direction: column; }
.recipe-card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.15rem; font-weight: 600; color: var(--ink);
    line-height: 1.3; margin-bottom: .5rem;
    transition: color .18s;
}
.recipe-card:hover .recipe-card-title { color: var(--accent); }

.recipe-card-desc { font-size: .8rem; color: var(--ink-3); line-height: 1.55; margin-bottom: auto; }

.recipe-card-footer {
    display: flex; align-items: center; gap: .75rem;
    padding-top: .9rem; margin-top: .9rem;
    border-top: 1px solid var(--border-lt);
    font-size: .78rem; color: var(--ink-3);
}
.recipe-meta-item { display: flex; align-items: center; gap: .3rem; }
.recipe-meta-item svg { flex-shrink: 0; }

/* ── Empty state ── */
.empty-state {
    text-align: center; padding: 5rem 2rem;
    color: var(--ink-3);
}
.empty-state-icon { margin: 0 auto 1.5rem; width: 56px; height: 56px; opacity: .3; }
.empty-state h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 600; color: var(--ink-2); margin-bottom: .5rem; }
.empty-state p { font-size: .88rem; margin-bottom: 1.5rem; }

/* ── Pagination ── */
.pagination { display: flex; align-items: center; justify-content: center; gap: .5rem; margin-top: 3rem; }
.pagination a, .pagination span {
    display: inline-flex; align-items: center; justify-content: center;
    width: 38px; height: 38px; border-radius: var(--r-sm);
    font-size: .85rem; font-weight: 500; text-decoration: none;
    border: 1.5px solid var(--border);
    color: var(--ink-2); background: var(--surface);
    transition: all .18s;
}
.pagination a:hover { border-color: var(--accent); color: var(--accent); }
.pagination .active { background: var(--accent); color: #fff; border-color: var(--accent); }
.pagination .disabled { opacity: .35; pointer-events: none; }

@media (max-width: 768px) {
    .recipes-header { padding: 2rem 1.25rem; }
    .filters-bar { padding: .9rem 1.25rem; }
    .recipes-body { padding: 2rem 1.25rem 4rem; }
    .recipes-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 480px) {
    .recipes-grid { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')

<div class="recipes-header">
    <div class="recipes-header-inner">
        <div class="recipes-header-eyebrow"></div>
        <h1>Toutes les <em>recettes</em></h1>
        <p>Découvrez l'ensemble de notre collection culinaire — filtrée et triée selon vos envies</p>
    </div>
</div>

<div class="filters-bar">
    <form method="GET" action="{{ route('recipes.index') }}" class="filters-inner">
        <div class="search-wrap">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="q" value="{{ request('q') }}" class="search-input" placeholder="Rechercher une recette...">
        </div>

        @if($categories->isNotEmpty())
        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="">Toutes catégories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        @endif

        <select name="difficulty" class="filter-select" onchange="this.form.submit()">
            <option value="">Tout niveau</option>
            <option value="facile"    @selected(request('difficulty')=='facile')>Facile</option>
            <option value="moyen"     @selected(request('difficulty')=='moyen')>Moyen</option>
            <option value="difficile" @selected(request('difficulty')=='difficile')>Difficile</option>
        </select>

        <select name="sort" class="filter-select" onchange="this.form.submit()">
            <option value="recent"  @selected(request('sort','recent')=='recent')>Plus récentes</option>
            <option value="popular" @selected(request('sort')=='popular')>Populaires</option>
            <option value="rating"  @selected(request('sort')=='rating')>Mieux notées</option>
            <option value="quick"   @selected(request('sort')=='quick')>Plus rapides</option>
        </select>

        @if(request()->hasAny(['q','category','difficulty','sort']))
            <a href="{{ route('recipes.index') }}" class="filter-chip">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:.3rem"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Effacer
            </a>
        @endif
    </form>
</div>

<div class="recipes-body">

    <div class="recipes-meta">
        <span class="recipes-count">
            <strong>{{ $recipes->total() }}</strong> recette{{ $recipes->total() > 1 ? 's' : '' }} trouvée{{ $recipes->total() > 1 ? 's' : '' }}
        </span>
    </div>

    @if($recipes->isNotEmpty())
        <div class="recipes-grid">
            @foreach($recipes as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card">
                <div class="recipe-card-img">
                    @if($recipe->image)
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" loading="lazy">
                    @else
                        <div class="recipe-card-img-placeholder">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Z"/></svg>
                        </div>
                    @endif
                    @if($recipe->category)
                        <span class="recipe-cat">{{ $recipe->category->name }}</span>
                    @endif
                </div>
                <div class="recipe-card-body">
                    <div class="recipe-card-title">{{ $recipe->title }}</div>
                    @if($recipe->description)
                        <p class="recipe-card-desc">{{ Str::limit($recipe->description, 80) }}</p>
                    @endif
                    <div class="recipe-card-footer">
                        @if($recipe->average_rating)
                            <span class="recipe-meta-item">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="#c8972a" stroke="#c8972a" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                {{ number_format($recipe->average_rating, 1) }}
                            </span>
                        @endif
                        @if($recipe->cook_time)
                            <span class="recipe-meta-item">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $recipe->cook_time }} min
                            </span>
                        @endif
                        @if($recipe->difficulty)
                            @php
                                $diffClass = match($recipe->difficulty) {
                                    'facile' => 'diff-easy',
                                    'moyen' => 'diff-medium',
                                    'difficile' => 'diff-hard',
                                    default => ''
                                };
                            @endphp
                            <span class="recipe-meta-item {{ $diffClass }}" style="padding:.15rem .5rem;border-radius:999px;font-size:.7rem;font-weight:600">{{ ucfirst($recipe->difficulty) }}</span>
                        @endif
                        <span style="margin-left:auto;font-size:.72rem;display:flex;align-items:center;gap:.3rem">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $recipe->user->name }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="pagination">
            {{ $recipes->withQueryString()->links() }}
        </div>

    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Z"/></svg>
            </div>
            <h3>Aucune recette trouvée</h3>
            <p>Essayez de modifier vos filtres ou votre recherche.</p>
            <a href="{{ route('recipes.index') }}" class="btn btn-ghost">Voir toutes les recettes</a>
        </div>
    @endif

</div>
@endsection

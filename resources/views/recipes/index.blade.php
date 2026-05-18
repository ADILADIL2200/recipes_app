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

/* ════════════════════════════════════════════════════════
   CHATBOT IA — Styles
   ════════════════════════════════════════════════════════ */

/* Bouton flottant */
#cb-fab {
    position: fixed; bottom: 1.8rem; right: 1.8rem; z-index: 9000;
    width: 56px; height: 56px; border-radius: 50%;
    background: var(--accent); color: #fff;
    border: none; cursor: pointer;
    box-shadow: 0 4px 18px rgba(184,74,28,.42);
    display: flex; align-items: center; justify-content: center;
    transition: transform .22s, background .22s;
    font-size: 1.45rem;
}
#cb-fab:hover { background: var(--accent-dark, #9e3a12); transform: scale(1.08); }
#cb-fab .cb-fab-badge {
    position: absolute; top: -3px; right: -3px;
    width: 16px; height: 16px; border-radius: 50%;
    background: #22c55e; border: 2px solid var(--bg, #faf7f3);
    font-size: .48rem; font-weight: 700; color: #fff;
    display: flex; align-items: center; justify-content: center;
}

/* Fenêtre chat */
#cb-window {
    position: fixed; bottom: 5.2rem; right: 1.8rem; z-index: 9001;
    width: 370px; max-width: calc(100vw - 2rem);
    border-radius: 18px;
    background: #fff;
    border: 1px solid var(--border, #e8e0d4);
    box-shadow: 0 12px 50px rgba(24,20,14,.16);
    display: flex; flex-direction: column;
    overflow: hidden;
    transition: opacity .28s, transform .28s;
    opacity: 0; transform: translateY(18px) scale(.96);
    pointer-events: none;
    max-height: 560px;
}
#cb-window.cb-open {
    opacity: 1; transform: translateY(0) scale(1);
    pointer-events: auto;
}

/* Header chatbot */
.cb-header {
    background: var(--accent, #b84a1c);
    padding: .85rem 1.1rem;
    display: flex; align-items: center; gap: .7rem;
    flex-shrink: 0;
}
.cb-header-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,.22);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
}
.cb-header-info strong { font-size: .88rem; font-weight: 600; color: #fff; display: block; }
.cb-header-info span   { font-size: .68rem; color: rgba(255,255,255,.75); }
.cb-header-close {
    margin-left: auto; background: none; border: none;
    color: rgba(255,255,255,.8); font-size: 1.1rem; cursor: pointer;
    line-height: 1; padding: .15rem .3rem; border-radius: 6px;
    transition: background .18s;
}
.cb-header-close:hover { background: rgba(255,255,255,.15); color: #fff; }

/* Messages */
.cb-messages {
    flex: 1; overflow-y: auto; padding: 1rem;
    display: flex; flex-direction: column; gap: .7rem;
    font-size: .83rem; line-height: 1.55;
}
.cb-messages::-webkit-scrollbar { width: 3px; }
.cb-messages::-webkit-scrollbar-thumb { background: #d0c5b4; border-radius: 3px; }

.cb-msg { display: flex; flex-direction: column; max-width: 88%; }
.cb-msg.bot { align-self: flex-start; }
.cb-msg.user { align-self: flex-end; }

.cb-bubble {
    padding: .55rem .85rem; border-radius: 14px;
    font-family: 'DM Sans', system-ui, sans-serif; font-size: .83rem; line-height: 1.55;
}
.cb-msg.bot  .cb-bubble { background: #faf7f3; color: #3d3025; border: 1px solid #e8e0d4; border-bottom-left-radius: 4px; }
.cb-msg.user .cb-bubble { background: var(--accent, #b84a1c); color: #fff; border-bottom-right-radius: 4px; }

.cb-timestamp { font-size: .6rem; color: #9a8e7e; margin-top: .2rem; }
.cb-msg.user .cb-timestamp { text-align: right; }

/* Chips de suggestion */
.cb-chips { display: flex; flex-wrap: wrap; gap: .38rem; margin-top: .45rem; }
.cb-chip {
    font-size: .74rem; padding: .28rem .75rem; border-radius: 999px;
    border: 1.5px solid var(--accent, #b84a1c); color: var(--accent, #b84a1c);
    background: transparent; cursor: pointer; font-family: 'DM Sans', system-ui, sans-serif;
    transition: all .18s;
}
.cb-chip:hover { background: var(--accent, #b84a1c); color: #fff; }

/* Typing indicator */
.cb-typing { display: flex; align-items: center; gap: .28rem; padding: .5rem .85rem; background: #faf7f3; border: 1px solid #e8e0d4; border-radius: 14px; border-bottom-left-radius: 4px; width: fit-content; }
.cb-dot { width: 6px; height: 6px; border-radius: 50%; background: #9a8e7e; animation: cbBounce 1.2s infinite ease-in-out; }
.cb-dot:nth-child(2) { animation-delay: .2s; }
.cb-dot:nth-child(3) { animation-delay: .4s; }
@keyframes cbBounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-6px)} }

/* Input bar */
.cb-inputbar {
    border-top: 1px solid var(--border, #e8e0d4);
    padding: .7rem .85rem;
    display: flex; gap: .5rem; align-items: flex-end;
    flex-shrink: 0;
    background: #fff;
}
.cb-inputbar textarea {
    flex: 1; font-family: 'DM Sans', system-ui, sans-serif; font-size: .82rem;
    color: #18140e; background: #faf7f3;
    border: 1.5px solid #e8e0d4; border-radius: 10px;
    padding: .5rem .8rem; outline: none; resize: none;
    min-height: 38px; max-height: 90px; line-height: 1.5;
    transition: border-color .2s, box-shadow .2s;
}
.cb-inputbar textarea:focus { border-color: var(--accent, #b84a1c); box-shadow: 0 0 0 3px rgba(184,74,28,.09); background: #fff; }
.cb-inputbar textarea::placeholder { color: #c5b8a8; font-weight: 300; }
.cb-send {
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--accent, #b84a1c); color: #fff; border: none;
    cursor: pointer; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: background .18s; font-size: .9rem;
}
.cb-send:hover { background: #9e3a12; }
.cb-send:disabled { background: #e8e0d4; cursor: default; }

/* Barre d'action : redirection vers création */
.cb-action-bar {
    border-top: 1px solid #e8e0d4;
    padding: .65rem .85rem;
    background: #f5ede7;
    display: flex; align-items: center; gap: .6rem;
    flex-shrink: 0;
}
.cb-action-bar p { font-size: .74rem; color: #6b5f4f; flex: 1; line-height: 1.4; }
.cb-btn-fill {
    flex-shrink: 0; background: var(--accent, #b84a1c); color: #fff;
    border: none; border-radius: 999px; padding: .4rem 1rem;
    font-size: .78rem; font-weight: 600; cursor: pointer;
    font-family: 'DM Sans', system-ui, sans-serif; transition: background .18s;
    display: flex; align-items: center; gap: .3rem;
    text-decoration: none;
}
.cb-btn-fill:hover { background: #9e3a12; }
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

{{--
    ════════════════════════════════════════════════════════
    CHATBOT IA — FAB + fenêtre chat
    Adapté pour index.blade.php :
    Le bouton "✨ Créer cette recette" redirige vers create
    au lieu de remplir un formulaire local.
    ════════════════════════════════════════════════════════
--}}

{{-- ── FAB ────────────────────────────────────────────────── --}}
<button id="cb-fab" onclick="cbToggle()" aria-label="Assistant IA">
    🤖
    <span class="cb-fab-badge">IA</span>
</button>

{{-- ── Fenêtre chat ────────────────────────────────────────── --}}
<div id="cb-window" role="dialog" aria-label="Assistant de recette">

    <div class="cb-header">
        <div class="cb-header-avatar">👨‍🍳</div>
        <div class="cb-header-info">
            <strong>Chef IA</strong>
            <span>Génère ta recette en quelques secondes</span>
        </div>
        <button class="cb-header-close" onclick="cbToggle()" aria-label="Fermer">✕</button>
    </div>

    <div class="cb-messages" id="cb-messages"></div>

    {{-- Action bar : redirige vers /recipes/create avec les données en sessionStorage --}}
    <div class="cb-action-bar" id="cb-action-bar" style="display:none">
        <p>✅ Recette prête ! Créer maintenant ?</p>
        <a class="cb-btn-fill" id="cb-btn-fill" href="{{ route('recipes.create') }}">
            ✨ Créer
        </a>
    </div>

    <div class="cb-inputbar">
        <textarea id="cb-input" placeholder="Ex : Tajine d'agneau aux pruneaux, soupe végétarienne…"
                  rows="1" onkeydown="cbKey(event)" oninput="cbResize(this)"></textarea>
        <button class="cb-send" id="cb-send" onclick="cbSend()" aria-label="Envoyer">
            ➤
        </button>
    </div>
</div>

{{-- ── Script chatbot ──────────────────────────────────────── --}}
<script>
(function () {
    /* ── État ─────────────────────────────────────────── */
    let cbOpen    = false;
    let cbLoading = false;
    let cbRecipe  = null;
    let cbHistory = [];

    const SYSTEM = `Tu es un chef cuisinier expert. Quand l'utilisateur décrit un plat ou des ingrédients,
génère une recette complète et réponds UNIQUEMENT avec un objet JSON valide (sans markdown, sans backticks) ayant ces clés :
{
  "title": "string",
  "description": "string (2-3 phrases appétissantes)",
  "ingredients": "string (une ligne par ingrédient, ex: - 500 g d'agneau\\n- 2 oignons...)",
  "steps": "string (une étape numérotée par ligne, ex: 1. Préchauffer le four...\\n2. ...)",
  "prep_time": number (minutes),
  "cook_time": number (minutes),
  "servings": number,
  "category_name": "string (une parmi: Entrée, Plat principal, Dessert, Soupe, Salade, Petit-déjeuner, Snack, Boisson)"
}
Si l'utilisateur pose une question générale sur la cuisine (sans demander une recette précise),
réponds en texte normal (pas de JSON).`;

    function now() {
        return new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
    }

    /* ── Toggle fenêtre ───────────────────────────────── */
    window.cbToggle = function () {
        cbOpen = !cbOpen;
        document.getElementById('cb-window').classList.toggle('cb-open', cbOpen);
        if (cbOpen && document.getElementById('cb-messages').children.length === 0) {
            cbBotMsg(
                'Bonjour ! 👋 Décris-moi un plat ou donne-moi des ingrédients et je génère la recette complète pour toi.',
                [
                    'Tajine d\'agneau aux pruneaux 🍖',
                    'Salade César végétarienne 🥗',
                    'Brownie au chocolat 🍫',
                    'Soupe de lentilles marocaine 🥣',
                ]
            );
        }
        if (cbOpen) setTimeout(() => document.getElementById('cb-input').focus(), 100);
    };

    /* ── Message bot ──────────────────────────────────── */
    function cbBotMsg(text, chips) {
        const wrap = document.getElementById('cb-messages');
        const div  = document.createElement('div');
        div.className = 'cb-msg bot';
        div.innerHTML = `<div class="cb-bubble">${text}</div><div class="cb-timestamp">${now()}</div>`;
        if (chips && chips.length) {
            const chipsDiv = document.createElement('div');
            chipsDiv.className = 'cb-chips';
            chips.forEach(c => {
                const btn = document.createElement('button');
                btn.className = 'cb-chip';
                btn.textContent = c;
                btn.onclick = () => { document.getElementById('cb-input').value = c; cbSend(); };
                chipsDiv.appendChild(btn);
            });
            div.appendChild(chipsDiv);
        }
        wrap.appendChild(div);
        wrap.scrollTop = wrap.scrollHeight;
    }

    /* ── Message user ─────────────────────────────────── */
    function cbUserMsg(text) {
        const wrap = document.getElementById('cb-messages');
        const div  = document.createElement('div');
        div.className = 'cb-msg user';
        div.innerHTML = `<div class="cb-bubble">${text}</div><div class="cb-timestamp">${now()}</div>`;
        wrap.appendChild(div);
        wrap.scrollTop = wrap.scrollHeight;
    }

    /* ── Typing ───────────────────────────────────────── */
    function cbShowTyping() {
        const wrap = document.getElementById('cb-messages');
        const div  = document.createElement('div');
        div.className = 'cb-msg bot'; div.id = 'cb-typing';
        div.innerHTML = '<div class="cb-typing"><span class="cb-dot"></span><span class="cb-dot"></span><span class="cb-dot"></span></div>';
        wrap.appendChild(div);
        wrap.scrollTop = wrap.scrollHeight;
    }
    function cbHideTyping() { document.getElementById('cb-typing')?.remove(); }

    /* ── Envoyer ──────────────────────────────────────── */
    window.cbSend = async function () {
        const inp  = document.getElementById('cb-input');
        const text = inp.value.trim();
        if (!text || cbLoading) return;

        inp.value = '';
        cbResize(inp);
        cbUserMsg(text);
        cbHistory.push({ role: 'user', content: text });

        cbLoading = true;
        document.getElementById('cb-send').disabled = true;
        cbShowTyping();

        try {
            const res = await fetch('http://127.0.0.1:8000/chat', {
                method : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept'      : 'application/json',
                },
                body: JSON.stringify({ messages: cbHistory, system: SYSTEM }),
            });

            if (!res.ok) throw new Error('Erreur serveur ' + res.status);
            const data  = await res.json();
            const reply = data.reply || '';

            cbHistory.push({ role: 'assistant', content: reply });
            cbHideTyping();

            try {
                const parsed = JSON.parse(reply);
                if (parsed.title && parsed.ingredients && parsed.steps) {
                    cbRecipe = parsed;

                    // Stocker la recette pour la récupérer sur la page create
                    try { sessionStorage.setItem('cb_prefill', JSON.stringify(parsed)); } catch {}

                    cbBotMsg(
                        `✅ Recette générée : <strong>${parsed.title}</strong><br>
                        <span style="font-size:.78rem;color:#9a8e7e">
                        ⏱ Prép. ${parsed.prep_time || '?'} min ·
                        🍳 Cuisson ${parsed.cook_time || '?'} min ·
                        🍽 ${parsed.servings || '?'} pers.
                        </span><br>
                        Clique sur <strong>✨ Créer</strong> pour ouvrir le formulaire pré-rempli.`
                    );
                    document.getElementById('cb-action-bar').style.display = 'flex';
                } else {
                    cbBotMsg(reply);
                }
            } catch {
                cbBotMsg(reply);
            }

        } catch (err) {
            cbHideTyping();
            cbBotMsg('❌ Une erreur est survenue. Réessaie dans quelques secondes.');
            console.error('[ChatBot]', err);
        } finally {
            cbLoading = false;
            document.getElementById('cb-send').disabled = false;
        }
    };

    /* ── Resize textarea ──────────────────────────────── */
    window.cbResize = function (el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 90) + 'px';
    };

    /* ── Touche Entrée ────────────────────────────────── */
    window.cbKey = function (e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); cbSend(); }
    };

})();
</script>

@endsection
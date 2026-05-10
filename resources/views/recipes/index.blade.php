{{-- resources/views/recipes/index.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Parcourir les recettes — Saveur</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg:        #f9f6f1; --surface:   #ffffff;
            --ink:       #18140e; --ink-2:     #5a4e3c; --ink-3:     #9a8e7e;
            --accent:    #b84a1c; --accent-lt: #f5ede7;
            --gold:      #c8972a; --sage:      #3d5c36;
            --border:    #e8e0d4;
            --r-sm: 8px; --r-md: 14px; --r-lg: 22px;
        }
        body { font-family: 'Outfit', sans-serif; background: var(--bg); color: var(--ink); min-height: 100vh; -webkit-font-smoothing: antialiased; }

        .flash       { background: var(--sage); color: #fff; text-align: center; padding: .6rem 1rem; font-size: .85rem; }
        .flash-error { background: #c0392b; }

        nav { position: sticky; top: 0; z-index: 200; background: rgba(249,246,241,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 2.5rem; height: 68px; }
        .nav-brand { font-family: 'Cormorant Garamond', serif; font-size: 1.9rem; font-weight: 600; color: var(--accent); text-decoration: none; }
        .nav-links  { display: flex; align-items: center; gap: 1.8rem; }
        .nav-links a { text-decoration: none; color: var(--ink-2); font-size: .9rem; font-weight: 500; transition: color .2s; }
        .nav-links a:hover, .nav-links a.active { color: var(--accent); }
        .btn { display: inline-flex; align-items: center; gap: .4rem; text-decoration: none; padding: .5rem 1.25rem; border-radius: 999px; font-family: 'Outfit', sans-serif; font-size: .85rem; font-weight: 500; cursor: pointer; border: 1.5px solid transparent; transition: all .18s; white-space: nowrap; }
        .btn-primary { background: var(--accent); color: #fff; border-color: var(--accent); }
        .btn-primary:hover { background: #9e3a12; }
        .btn-outline { background: transparent; color: var(--accent); border-color: var(--accent); }
        .btn-outline:hover { background: var(--accent); color: #fff; }
        .btn-ghost   { background: var(--surface); color: var(--ink-2); border-color: var(--border); }
        .btn-ghost:hover { border-color: var(--ink-3); color: var(--ink); }

        /* Search Hero */
        .search-hero { background: linear-gradient(135deg, #ecdec8 0%, #d4b896 100%); padding: 3rem 2.5rem 0; border-bottom: 1px solid var(--border); }
        .search-hero-inner { max-width: 1180px; margin: 0 auto; }
        .search-hero h1 { font-family: 'Cormorant Garamond', serif; font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 600; color: var(--ink); margin-bottom: .4rem; }
        .search-hero p  { font-size: .95rem; color: var(--ink-2); margin-bottom: 1.8rem; }

        .search-bar-wrap { position: relative; max-width: 680px; margin-bottom: -1.5rem; }
        .search-bar-wrap input { width: 100%; padding: 1rem 1.2rem 1rem 3.2rem; border: 2px solid var(--border); border-radius: var(--r-lg); font-family: 'Outfit', sans-serif; font-size: 1rem; color: var(--ink); background: var(--surface); outline: none; transition: border-color .2s; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
        .search-bar-wrap input:focus { border-color: var(--accent); }
        .search-bar-wrap .search-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); font-size: 1.1rem; opacity: .4; pointer-events: none; }
        .search-bar-wrap button { position: absolute; right: .5rem; top: 50%; transform: translateY(-50%); }

        /* Layout */
        .browse-layout { max-width: 1180px; margin: 0 auto; padding: 3.5rem 2.5rem 5rem; display: grid; grid-template-columns: 260px 1fr; gap: 2.5rem; align-items: start; }

        /* Filters */
        .filters-panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; position: sticky; top: 88px; }
        .filters-head  { padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); background: #faf7f3; display: flex; align-items: center; justify-content: space-between; }
        .filters-head h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.05rem; font-weight: 600; color: var(--ink); }
        .filters-head a  { font-size: .75rem; color: var(--ink-3); text-decoration: none; }
        .filters-head a:hover { color: var(--accent); }
        .filter-section { padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); }
        .filter-section:last-child { border-bottom: none; }
        .filter-label   { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; color: var(--ink-3); margin-bottom: .6rem; }
        .filter-section select, .filter-section input[type="number"] { width: 100%; background: var(--bg); border: 1.5px solid var(--border); border-radius: var(--r-sm); padding: .55rem .8rem; font-family: 'Outfit', sans-serif; font-size: .85rem; color: var(--ink); outline: none; transition: border-color .18s; }
        .filter-section select:focus, .filter-section input:focus { border-color: var(--accent); }
        .sort-pills { display: flex; flex-wrap: wrap; gap: .4rem; }
        .sort-pill   { padding: .3rem .75rem; border-radius: 999px; border: 1.5px solid var(--border); background: var(--bg); font-size: .75rem; color: var(--ink-3); text-decoration: none; transition: all .18s; }
        .sort-pill.active, .sort-pill:hover { background: var(--accent); border-color: var(--accent); color: #fff; }
        .filter-apply { padding: 1rem 1.25rem; }
        .filter-apply button { width: 100%; background: var(--accent); color: #fff; border: none; border-radius: var(--r-md); padding: .65rem; font-family: 'Outfit', sans-serif; font-size: .85rem; font-weight: 600; cursor: pointer; transition: background .18s; }
        .filter-apply button:hover { background: #9e3a12; }

        /* Results */
        .results-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem; margin-bottom: 1.5rem; }
        .results-count  { font-size: .88rem; color: var(--ink-2); }
        .results-count strong { color: var(--ink); }
        .active-filters { display: flex; flex-wrap: wrap; gap: .4rem; }
        .filter-chip    { display: inline-flex; align-items: center; gap: .4rem; background: var(--accent-lt); color: var(--accent); border: 1px solid #f0c4b2; border-radius: 999px; padding: .28rem .75rem; font-size: .78rem; font-weight: 500; text-decoration: none; transition: background .18s; }
        .filter-chip:hover { background: #eeddd6; }
        .filter-chip .remove { opacity: .65; }

        /* Recipe Grid */
        .recipe-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.25rem; }
        .recipe-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; text-decoration: none; color: inherit; display: flex; flex-direction: column; transition: box-shadow .2s, transform .2s; }
        .recipe-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.09); transform: translateY(-2px); }
        .card-img         { aspect-ratio: 16/10; background: linear-gradient(135deg,#ecdec8,#d4b896); overflow: hidden; position: relative; display: flex; align-items: center; justify-content: center; }
        .card-img img     { width: 100%; height: 100%; object-fit: cover; }
        .card-img-placeholder { font-size: 2.5rem; opacity: .25; }
        .card-cat         { position: absolute; top: .7rem; left: .7rem; background: rgba(24,20,14,.55); color: #fff; font-size: .68rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; padding: .22rem .65rem; border-radius: 999px; backdrop-filter: blur(6px); }
        .card-body        { padding: 1rem; flex: 1; display: flex; flex-direction: column; gap: .4rem; }
        .card-title       { font-family: 'Cormorant Garamond', serif; font-size: 1.05rem; font-weight: 600; color: var(--ink); line-height: 1.25; }
        .card-meta        { display: flex; flex-wrap: wrap; gap: .5rem; font-size: .75rem; color: var(--ink-3); margin-top: auto; padding-top: .5rem; }

        /* Empty state */
        .empty-state { grid-column: 1/-1; text-align: center; padding: 4rem 2rem; }
        .empty-state .icon { font-size: 3rem; margin-bottom: 1rem; opacity: .3; }
        .empty-state h3    { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; color: var(--ink-2); margin-bottom: .5rem; }
        .empty-state p     { color: var(--ink-3); font-size: .88rem; }

        /* Pagination */
        .pagination-wrap { margin-top: 2rem; display: flex; justify-content: center; }

        /* Context banner (by-category / by-tag) */
        .context-banner { background: var(--accent-lt); border: 1px solid #f0c4b2; border-radius: var(--r-md); padding: .75rem 1.2rem; margin-bottom: 1.5rem; font-size: .88rem; color: var(--accent); font-weight: 500; }

        footer { border-top: 1px solid var(--border); padding: 2rem 2.5rem; text-align: center; font-size: .82rem; color: var(--ink-3); }
        footer a { color: var(--accent); text-decoration: none; }

        @media (max-width: 900px) { .browse-layout { grid-template-columns: 1fr; } .filters-panel { position: static; } }
        @media (max-width: 600px) { nav { padding: 0 1.25rem; } .search-hero { padding: 2rem 1.25rem 0; } .browse-layout { padding: 2.5rem 1.25rem 4rem; } }
    </style>
</head>
<body>

@if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
@if(session('error'))<div class="flash flash-error">{{ session('error') }}</div>@endif

{{-- Nav --}}
<nav>
    <a href="{{ route('home') }}" class="nav-brand">Saveur</a>
    <div class="nav-links">
        <a href="{{ route('recipes.index') }}" class="active">Recettes</a>
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Admin</a>
            @else
                <a href="{{ route('recipes.my') }}">Mes recettes</a>
                <a href="{{ route('recipes.favorites') }}">Favoris</a>
                <a href="{{ route('recipes.create') }}" class="btn btn-primary">+ Nouvelle</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-ghost">Déconnexion</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
            <a href="{{ route('signup') }}" class="btn btn-primary">S'inscrire</a>
        @endauth
    </div>
</nav>

{{-- Search Hero --}}
<div class="search-hero">
    <div class="search-hero-inner">
        <h1>Parcourir les recettes</h1>
        <p>Recherchez par ingrédient, catégorie, tag ou temps de cuisson.</p>
        <form action="{{ route('recipes.index') }}" method="GET">
            <div class="search-bar-wrap">
                <span class="search-icon">🔍</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher une recette...">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>
    </div>
</div>

{{-- Layout --}}
<div class="browse-layout">

    {{-- Filters --}}
    <aside>
        <form action="{{ route('recipes.index') }}" method="GET">
            <input type="hidden" name="q" value="{{ request('q') }}">
            <div class="filters-panel">
                <div class="filters-head">
                    <h3>Filtres</h3>
                    <a href="{{ route('recipes.index') }}">Réinitialiser</a>
                </div>

                <div class="filter-section">
                    <div class="filter-label">Catégorie</div>
                    <select name="category_id">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->recipes_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-section">
                    <div class="filter-label">Tag</div>
                    <select name="tag_id">
                        <option value="">Tous les tags</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                #{{ $tag->name }} ({{ $tag->recipes_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-section">
                    <div class="filter-label">Temps total max (min)</div>
                    <input type="number" name="max_time" min="5" step="5"
                           value="{{ request('max_time') }}" placeholder="ex. 60">
                </div>

                <div class="filter-section">
                    <div class="filter-label">Note minimum</div>
                    <select name="min_rating">
                        <option value="">Toutes les notes</option>
                        @foreach([5,4,3,2,1] as $r)
                            <option value="{{ $r }}" {{ request('min_rating') == $r ? 'selected' : '' }}>
                                {{ str_repeat('●', $r) }}{{ str_repeat('○', 5-$r) }} {{ $r }}+
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-section">
                    <div class="filter-label">Trier par</div>
                    <div class="sort-pills">
                        @foreach(['date' => 'Récent', 'rating' => 'Note', 'popularity' => 'Populaire', 'cook_time' => 'Rapide'] as $val => $label)
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $val, 'page' => null]) }}"
                               class="sort-pill {{ request('sort', 'date') === $val ? 'active' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                    <input type="hidden" name="sort" value="{{ request('sort', 'date') }}">
                </div>

                <div class="filter-apply">
                    <button type="submit">Appliquer les filtres</button>
                </div>
            </div>
        </form>
    </aside>

    {{-- Results --}}
    <div>

        {{-- Context banner (by-category / by-tag) --}}
        @isset($category)
            <div class="context-banner">📂 Catégorie : <strong>{{ $category->name }}</strong> — <a href="{{ route('recipes.index') }}" style="color:var(--accent)">Voir tout</a></div>
        @endisset
        @isset($tag)
            <div class="context-banner">#{{ $tag->name }} — <a href="{{ route('recipes.index') }}" style="color:var(--accent)">Voir tout</a></div>
        @endisset

        {{-- Results header --}}
        <div class="results-header">
            <div class="results-count">
                <strong>{{ $recipes->total() }}</strong> recette{{ $recipes->total() > 1 ? 's' : '' }} trouvée{{ $recipes->total() > 1 ? 's' : '' }}
                @if($query) pour « <strong>{{ $query }}</strong> » @endif
            </div>
            <div class="active-filters">
                @if(request('q'))
                    <a href="{{ request()->fullUrlWithQuery(['q'=>null,'page'=>null]) }}" class="filter-chip">
                        "{{ Str::limit(request('q'),20) }}" <span class="remove">✕</span>
                    </a>
                @endif
                @if(request('category_id'))
                    @php $fc = $categories->firstWhere('id', request('category_id')); @endphp
                    @if($fc)
                    <a href="{{ request()->fullUrlWithQuery(['category_id'=>null,'page'=>null]) }}" class="filter-chip">
                        {{ $fc->name }} <span class="remove">✕</span>
                    </a>
                    @endif
                @endif
                @if(request('tag_id'))
                    @php $ft = $tags->firstWhere('id', request('tag_id')); @endphp
                    @if($ft)
                    <a href="{{ request()->fullUrlWithQuery(['tag_id'=>null,'page'=>null]) }}" class="filter-chip">
                        #{{ $ft->name }} <span class="remove">✕</span>
                    </a>
                    @endif
                @endif
                @if(request('max_time'))
                    <a href="{{ request()->fullUrlWithQuery(['max_time'=>null,'page'=>null]) }}" class="filter-chip">≤ {{ request('max_time') }}min <span class="remove">✕</span></a>
                @endif
                @if(request('min_rating'))
                    <a href="{{ request()->fullUrlWithQuery(['min_rating'=>null,'page'=>null]) }}" class="filter-chip">{{ request('min_rating') }}●+ <span class="remove">✕</span></a>
                @endif
            </div>
        </div>

        {{-- Cards --}}
        <div class="recipe-grid">
            @forelse($recipes as $recipe)
                <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card">
                    <div class="card-img">
                        @if($recipe->image)
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
                        @else
                            <div class="card-img-placeholder">🍽️</div>
                        @endif
                        @if($recipe->category)
                            <span class="card-cat">{{ $recipe->category->name }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ $recipe->title }}</div>
                        @if($recipe->description)
                            <p style="font-size:.82rem;color:var(--ink-3);line-height:1.5;flex:1">{{ Str::limit($recipe->description, 80) }}</p>
                        @endif
                        <div class="card-meta">
                            @if($recipe->average_rating ?? $recipe->ratings_avg_score)
                                <span style="color:var(--gold)">{{ number_format($recipe->average_rating ?? $recipe->ratings_avg_score, 1) }} ●</span>
                            @endif
                            @if($recipe->prep_time || $recipe->cook_time)
                                <span>⏱ {{ ($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0) }}min</span>
                            @endif
                            @if($recipe->servings)
                                <span>🍽 {{ $recipe->servings }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="icon">🔍</div>
                    <h3>Aucune recette trouvée</h3>
                    <p>Essayez d'ajuster votre recherche ou vos filtres.</p>
                </div>
            @endforelse
        </div>

        @if($recipes->hasPages())
        <div class="pagination-wrap">
            {{ $recipes->onEachSide(1)->links() }}
        </div>
        @endif
    </div>

</div>

<footer>
    <p>© {{ date('Y') }} <a href="{{ route('home') }}">Saveur</a> — fait pour les cuisiniers du monde entier.</p>
</footer>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Browse Recipes — Saveur</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #f9f6f1;
            --surface:   #ffffff;
            --ink:       #18140e;
            --ink-2:     #5a4e3c;
            --ink-3:     #9a8e7e;
            --accent:    #b84a1c;
            --accent-lt: #f5ede7;
            --gold:      #c8972a;
            --gold-lt:   #fef6e4;
            --sage:      #3d5c36;
            --border:    #e8e0d4;
            --r-sm:      8px;
            --r-md:      14px;
            --r-lg:      22px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── NAV ── */
        nav {
            position: sticky; top: 0; z-index: 200;
            background: rgba(249,246,241,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2.5rem; height: 68px;
        }
        .nav-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.9rem; font-weight: 600;
            color: var(--accent); text-decoration: none;
        }
        .nav-links { display: flex; align-items: center; gap: 1.8rem; }
        .nav-links a {
            text-decoration: none; color: var(--ink-2);
            font-size: .9rem; font-weight: 500; transition: color .2s;
        }
        .nav-links a:hover { color: var(--accent); }
        .btn {
            display: inline-flex; align-items: center; gap: .4rem;
            text-decoration: none; padding: .5rem 1.25rem;
            border-radius: 999px; font-family: 'Outfit', sans-serif;
            font-size: .85rem; font-weight: 500;
            cursor: pointer; border: 1.5px solid transparent;
            transition: all .18s; white-space: nowrap;
        }
        .btn-primary { background: var(--accent); color: #fff; border-color: var(--accent); }
        .btn-primary:hover { background: #9e3a12; }
        .btn-outline { background: transparent; color: var(--accent); border-color: var(--accent); }
        .btn-outline:hover { background: var(--accent); color: #fff; }
        .btn-ghost { background: var(--surface); color: var(--ink-2); border-color: var(--border); }
        .btn-ghost:hover { border-color: var(--ink-3); color: var(--ink); }

        /* ── PAGE HEADER ── */
        .search-hero {
            background: linear-gradient(135deg, #ecdec8 0%, #d4b896 100%);
            padding: 3rem 2.5rem 0;
            border-bottom: 1px solid var(--border);
        }
        .search-hero-inner { max-width: 1180px; margin: 0 auto; }
        .search-hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 600; color: var(--ink);
            margin-bottom: .4rem;
        }
        .search-hero p { font-size: .95rem; color: var(--ink-2); margin-bottom: 1.8rem; }

        /* ── SEARCH BAR ── */
        .search-bar-wrap {
            position: relative; max-width: 680px;
            margin-bottom: -1.5rem;
        }
        .search-bar-wrap input {
            width: 100%; padding: 1rem 1.2rem 1rem 3.2rem;
            border: 2px solid var(--border);
            border-radius: var(--r-lg);
            font-family: 'Outfit', sans-serif;
            font-size: 1rem; color: var(--ink);
            background: var(--surface);
            outline: none; transition: border-color .2s;
            box-shadow: 0 4px 20px rgba(0,0,0,.07);
        }
        .search-bar-wrap input:focus { border-color: var(--accent); }
        .search-bar-wrap .search-icon {
            position: absolute; left: 1rem; top: 50%;
            transform: translateY(-50%);
            font-size: 1.1rem; opacity: .4; pointer-events: none;
        }
        .search-bar-wrap button {
            position: absolute; right: .5rem; top: 50%;
            transform: translateY(-50%);
        }

        /* ── LAYOUT ── */
        .browse-layout {
            max-width: 1180px; margin: 0 auto;
            padding: 3.5rem 2.5rem 5rem;
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 2.5rem;
            align-items: start;
        }

        /* ── FILTERS SIDEBAR ── */
        .filters-panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            overflow: hidden;
            position: sticky;
            top: 88px;
        }
        .filters-head {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            background: #faf7f3;
            display: flex; align-items: center; justify-content: space-between;
        }
        .filters-head h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem; font-weight: 600; color: var(--ink);
        }
        .filters-head a {
            font-size: .75rem; color: var(--ink-3); text-decoration: none;
        }
        .filters-head a:hover { color: var(--accent); }
        .filter-section {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
        }
        .filter-section:last-child { border-bottom: none; }
        .filter-label {
            font-size: .72rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .07em;
            color: var(--ink-3); margin-bottom: .6rem;
        }
        .filter-section select,
        .filter-section input[type="number"] {
            width: 100%;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            padding: .55rem .8rem;
            font-family: 'Outfit', sans-serif;
            font-size: .85rem; color: var(--ink);
            outline: none; transition: border-color .18s;
        }
        .filter-section select:focus,
        .filter-section input:focus { border-color: var(--accent); }

        /* Sort pills */
        .sort-pills { display: flex; flex-wrap: wrap; gap: .4rem; }
        .sort-pill {
            display: inline-block;
            padding: .28rem .75rem;
            border: 1.5px solid var(--border);
            border-radius: 999px;
            font-size: .75rem; font-weight: 500;
            color: var(--ink-2); text-decoration: none;
            transition: all .18s;
        }
        .sort-pill:hover { border-color: var(--accent); color: var(--accent); }
        .sort-pill.active {
            background: var(--accent); border-color: var(--accent);
            color: #fff;
        }

        .filter-apply {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border);
        }
        .filter-apply button {
            width: 100%; padding: .65rem;
            background: var(--accent); color: #fff;
            border: none; border-radius: var(--r-sm);
            font-family: 'Outfit', sans-serif;
            font-size: .88rem; font-weight: 500;
            cursor: pointer; transition: background .18s;
        }
        .filter-apply button:hover { background: #9e3a12; }

        /* ── RESULTS ── */
        .results-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.5rem; gap: 1rem; flex-wrap: wrap;
        }
        .results-count {
            font-size: .88rem; color: var(--ink-3);
        }
        .results-count strong { color: var(--ink); }

        /* Active filters chips */
        .active-filters { display: flex; flex-wrap: wrap; gap: .4rem; }
        .filter-chip {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .3rem .75rem;
            background: var(--accent-lt); border: 1px solid #e8c4b0;
            border-radius: 999px;
            font-size: .75rem; font-weight: 500; color: var(--accent);
            text-decoration: none; transition: all .15s;
        }
        .filter-chip:hover { background: var(--accent); color: #fff; }
        .filter-chip .remove { font-size: .8rem; opacity: .7; }

        /* ── RECIPE GRID ── */
        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .recipe-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
            text-decoration: none; color: inherit;
            display: flex; flex-direction: column;
        }
        .recipe-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 32px rgba(0,0,0,.09);
        }
        .card-img {
            aspect-ratio: 4/3;
            background: linear-gradient(135deg, #ecdec8, #c9a87a);
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }
        .card-img img { width: 100%; height: 100%; object-fit: cover; }
        .card-img-placeholder { font-size: 3rem; opacity: .2; }
        .card-cat {
            position: absolute; top: .75rem; left: .75rem;
            background: var(--accent); color: #fff;
            font-size: .65rem; font-weight: 600;
            letter-spacing: .07em; text-transform: uppercase;
            padding: .22rem .65rem; border-radius: 999px;
        }

        .card-body { padding: 1rem 1.1rem 1.25rem; flex: 1; display: flex; flex-direction: column; }
        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem; font-weight: 600;
            color: var(--ink); line-height: 1.3;
            margin-bottom: .4rem;
        }
        .card-meta {
            display: flex; align-items: center; gap: .65rem;
            font-size: .75rem; color: var(--ink-3);
            flex-wrap: wrap; margin-top: auto; padding-top: .8rem;
        }
        .card-meta span { display: flex; align-items: center; gap: .2rem; }
        .card-stars { color: var(--gold); font-size: .8rem; letter-spacing: .03em; }

        /* ── EMPTY STATE ── */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center; padding: 4rem 2rem;
        }
        .empty-state .icon { font-size: 3.5rem; opacity: .3; margin-bottom: 1rem; }
        .empty-state h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem; color: var(--ink-2);
            margin-bottom: .5rem;
        }
        .empty-state p { font-size: .88rem; color: var(--ink-3); }

        /* ── PAGINATION ── */
        .pagination-wrap {
            margin-top: 2.5rem;
            display: flex; justify-content: center;
        }
        .pagination-wrap nav { display: flex; gap: .4rem; align-items: center; }
        .pagination-wrap .page-item a,
        .pagination-wrap .page-item span {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 36px; height: 36px; padding: 0 .6rem;
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            font-size: .85rem; color: var(--ink-2);
            text-decoration: none; transition: all .18s;
            background: var(--surface);
        }
        .pagination-wrap .page-item a:hover { border-color: var(--accent); color: var(--accent); }
        .pagination-wrap .page-item.active span {
            background: var(--accent); border-color: var(--accent); color: #fff;
        }
        .pagination-wrap .page-item.disabled span { opacity: .35; }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid var(--border);
            text-align: center; padding: 2rem;
            color: var(--ink-3); font-size: .82rem;
        }
        footer a { color: var(--accent); text-decoration: none; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            nav { padding: 0 1.25rem; }
            .search-hero { padding: 2rem 1.25rem 0; }
            .browse-layout { grid-template-columns: 1fr; padding: 2rem 1.25rem 3rem; }
            .filters-panel { position: static; }
        }
    </style>
</head>
<body>

{{-- ── NAV ── --}}
<nav>
    <a href="{{ route('home') }}" class="nav-brand">Saveur</a>
    <div class="nav-links">
        <a href="{{ route('recipes.index') }}">Recipes</a>
        <a href="{{ route('recipes.search') }}" style="color:var(--accent)">Browse</a>
        @auth
            <a href="{{ route('recipes.my') }}">My Recipes</a>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> New Recipe</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-ghost">Log out</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline">Log in</a>
            <a href="{{ route('signup') }}" class="btn btn-primary">Join free</a>
        @endauth
    </div>
</nav>

{{-- ── HERO + SEARCH BAR ── --}}
<div class="search-hero">
    <div class="search-hero-inner">
        <h1>Browse Recipes</h1>
        <p>Search by keyword, filter by category, tag, time or rating.</p>

        <form method="GET" action="{{ route('recipes.search') }}">
            {{-- preserve other filters while searching --}}
            @foreach(request()->except('q', 'page') as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            <div class="search-bar-wrap">
                <span class="search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
                <input type="text" name="q"
                       value="{{ request('q') }}"
                       placeholder="Search by title, ingredient, or description…"
                       autocomplete="off">
                <button type="submit" class="btn btn-primary" style="font-size:.82rem;padding:.45rem 1rem">Search</button>
            </div>
        </form>
    </div>
</div>

{{-- ── BROWSE LAYOUT ── --}}
<div class="browse-layout">

    {{-- ══ FILTERS SIDEBAR ══ --}}
    <aside>
        <form method="GET" action="{{ route('recipes.search') }}">
            {{-- preserve search query --}}
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}">
            @endif

            <div class="filters-panel">
                <div class="filters-head">
                    <h3><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg> Filters</h3>
                    <a href="{{ route('recipes.search') }}">Clear all</a>
                </div>

                {{-- Category --}}
                <div class="filter-section">
                    <div class="filter-label">Category</div>
                    <select name="category_id">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tag --}}
                <div class="filter-section">
                    <div class="filter-label">Tag</div>
                    <select name="tag_id">
                        <option value="">All tags</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}"
                                {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                #{{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Max time --}}
                <div class="filter-section">
                    <div class="filter-label">Max total time (min)</div>
                    <input type="number" name="max_time" min="5" step="5"
                           value="{{ request('max_time') }}"
                           placeholder="e.g. 60">
                </div>

                {{-- Min rating --}}
                <div class="filter-section">
                    <div class="filter-label">Minimum rating</div>
                    <select name="min_rating">
                        <option value="">Any rating</option>
                        @foreach([5,4,3,2,1] as $r)
                            <option value="{{ $r }}" {{ request('min_rating') == $r ? 'selected' : '' }}>
                                {{ str_repeat('●', $r) }}{{ str_repeat('○', 5-$r) }} {{ $r }}+
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sort --}}
                <div class="filter-section">
                    <div class="filter-label">Sort by</div>
                    <div class="sort-pills">
                        @foreach(['date' => 'Newest', 'rating' => 'Rating', 'popularity' => 'Popular', 'cook_time' => 'Quickest'] as $val => $label)
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $val, 'page' => null]) }}"
                               class="sort-pill {{ request('sort', 'date') === $val ? 'active' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                    <input type="hidden" name="sort" value="{{ request('sort', 'date') }}">
                </div>

                <div class="filter-apply">
                    <button type="submit">Apply Filters</button>
                </div>
            </div>
        </form>
    </aside>

    {{-- ══ RESULTS ══ --}}
    <div>

        {{-- Results header --}}
        <div class="results-header">
            <div class="results-count">
                <strong>{{ $recipes->total() }}</strong>
                {{ Str::plural('recipe', $recipes->total()) }} found
                @if(request('q'))
                    for "<strong>{{ request('q') }}</strong>"
                @endif
            </div>

            {{-- Active filter chips --}}
            <div class="active-filters">
                @if(request('q'))
                    <a href="{{ request()->fullUrlWithQuery(['q' => null, 'page' => null]) }}" class="filter-chip">
                        "{{ Str::limit(request('q'), 20) }}" <span class="remove"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>
                    </a>
                @endif
                @if(request('category_id'))
                    @php $cat = $categories->firstWhere('id', request('category_id')); @endphp
                    @if($cat)
                    <a href="{{ request()->fullUrlWithQuery(['category_id' => null, 'page' => null]) }}" class="filter-chip">
                        {{ $cat->name }} <span class="remove"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>
                    </a>
                    @endif
                @endif
                @if(request('tag_id'))
                    @php $tag = $tags->firstWhere('id', request('tag_id')); @endphp
                    @if($tag)
                    <a href="{{ request()->fullUrlWithQuery(['tag_id' => null, 'page' => null]) }}" class="filter-chip">
                        #{{ $tag->name }} <span class="remove"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>
                    </a>
                    @endif
                @endif
                @if(request('max_time'))
                    <a href="{{ request()->fullUrlWithQuery(['max_time' => null, 'page' => null]) }}" class="filter-chip">
                        ≤ {{ request('max_time') }}min <span class="remove"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>
                    </a>
                @endif
                @if(request('min_rating'))
                    <a href="{{ request()->fullUrlWithQuery(['min_rating' => null, 'page' => null]) }}" class="filter-chip">
                        {{ request('min_rating') }}●+ <span class="remove"><svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>
                    </a>
                @endif
            </div>
        </div>

        {{-- Recipe cards grid --}}
        <div class="recipe-grid">
            @forelse($recipes as $recipe)
                <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card">
                    <div class="card-img">
                        @if($recipe->image)
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
                        @else
                            <div class="card-img-placeholder"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" style="opacity:.18"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/></svg></div>
                        @endif
                        @if($recipe->category)
                            <span class="card-cat">{{ $recipe->category->name }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="card-title">{{ $recipe->title }}</div>
                        @if($recipe->description)
                            <p style="font-size:.82rem;color:var(--ink-3);line-height:1.5;margin-top:.3rem;flex:1">
                                {{ Str::limit($recipe->description, 80) }}
                            </p>
                        @endif
                        <div class="card-meta">
                            @if($recipe->average_rating)
                                <span>
                                    <span class="card-stars" style="color:#c8972a">
                                        @for($i=1;$i<=5;$i++){{ $i <= round($recipe->average_rating) ? '●' : '○' }}@endfor
                                    </span>
                                    {{ number_format($recipe->average_rating, 1) }}
                                </span>
                            @endif
                            @if($recipe->prep_time || $recipe->cook_time)
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ ($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0) }}min</span>
                            @endif
                            @if($recipe->servings)
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="opacity:.35"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg> {{ $recipe->servings }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
                    <h3>No recipes found</h3>
                    <p>Try adjusting your search terms or filters.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($recipes->hasPages())
        <div class="pagination-wrap">
            {{ $recipes->onEachSide(1)->links() }}
        </div>
        @endif

    </div>

</div>

<footer>
    <p>© {{ date('Y') }} <a href="{{ route('home') }}">Saveur</a> — made for home cooks everywhere.</p>
</footer>

</body>
</html>

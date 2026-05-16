{{-- resources/views/recipes/index.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Parcourir les recettes — Saveur</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg:         #faf9f6;
            --surface:    #ffffff;
            --ink:        #1c1917;
            --ink-2:      #44403c;
            --ink-3:      #a8a29e;
            --accent:     #b84a1c;
            --accent-lt:  #fff7ed;
            --gold:       #d97706;
            --border:     #e7e5e4;
            --shadow-xl:  0 25px 50px -12px rgb(0 0 0 / 0.1);
            --r-xl:       40px;
        }

        body { font-family: 'Outfit', sans-serif; background: var(--bg); color: var(--ink); line-height: 1.6; -webkit-font-smoothing: antialiased; }

        /* Lucide icon base */
        [data-lucide] { display: inline-block; vertical-align: middle; }

        /* ── Navigation ── */
        nav {
            position: sticky; top: 0; z-index: 200;
            background: rgba(255,255,255,0.85); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 5%; height: 72px;
        }
        .nav-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem; font-weight: 600;
            color: var(--accent); text-decoration: none; letter-spacing: -0.02em;
            display: flex; align-items: center; gap: 10px;
        }
        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-links a {
            text-decoration: none; color: var(--ink-2);
            font-size: 0.95rem; font-weight: 500; transition: color 0.2s;
            display: flex; align-items: center; gap: 6px;
        }
        .nav-links a:hover { color: var(--accent); }
        .nav-links a [data-lucide] { width: 16px; height: 16px; }

        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none; padding: 0.6rem 1.4rem; border-radius: 12px;
            font-size: 0.9rem; font-weight: 600; cursor: pointer;
            transition: all 0.2s; border: 1px solid transparent;
        }
        .btn [data-lucide] { width: 15px; height: 15px; }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: #9a3412; transform: translateY(-1px); }

        /* ── Flash Messages ── */
        .flash {
            position: fixed; top: 88px; right: 24px; z-index: 999;
            display: flex; flex-direction: column; gap: 10px; pointer-events: none;
        }
        .flash-msg {
            color: #fff; padding: 14px 22px; border-radius: 14px;
            font-size: 0.9rem; font-weight: 500;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            display: flex; align-items: center; gap: 10px;
            animation: slideIn 0.4s cubic-bezier(0.165,0.84,0.44,1) forwards,
                       fadeOut 0.4s ease 2.6s forwards;
            pointer-events: auto;
        }
        .flash-msg [data-lucide] { width: 18px; height: 18px; flex-shrink: 0; }
        .flash-msg.success { background: #166534; }
        .flash-msg.error   { background: #9a3412; }
        @keyframes slideIn { from { opacity:0; transform:translateX(30px); } to { opacity:1; transform:translateX(0); } }
        @keyframes fadeOut { from { opacity:1; } to { opacity:0; pointer-events:none; } }

        /* ── Search Hero ── */
        .search-hero {
            background: linear-gradient(135deg, #fdfcfb 0%, #f5f0eb 50%, #faf9f6 100%);
            background-image:
                radial-gradient(circle at 20% 80%, rgba(184,74,28,0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(217,119,6,0.03) 0%, transparent 50%),
                radial-gradient(#e7e5e4 0.75px, transparent 0.75px);
            background-size: 100% 100%, 100% 100%, 24px 24px;
            padding: 6rem 5% 5rem; text-align: center; position: relative; overflow: hidden;
        }
        .search-hero::before {
            content: ''; position: absolute; top: -50%; left: -10%;
            width: 60%; height: 200%;
            background: radial-gradient(ellipse, rgba(184,74,28,0.03) 0%, transparent 70%);
            pointer-events: none;
        }
        .search-hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.8rem,6vw,4rem);
            margin-bottom: 0.5rem; letter-spacing: -0.02em;
        }
        .search-hero p { color: var(--ink-3); font-size: 1.15rem; font-weight: 300; margin-bottom: 2.5rem; max-width: 500px; margin-left: auto; margin-right: auto; }

        .search-wrapper { max-width: 960px; margin: 0 auto; position: relative; z-index: 10; }
        .search-container {
            background: var(--surface); padding: 10px; border-radius: var(--r-xl);
            box-shadow: var(--shadow-xl), 0 0 0 1px rgba(0,0,0,0.02);
            border: 1px solid var(--border);
            display: flex; align-items: center; gap: 4px;
            transition: box-shadow 0.3s, transform 0.3s;
        }
        .search-container:focus-within { box-shadow: var(--shadow-xl), 0 0 0 3px rgba(184,74,28,0.08); transform: translateY(-2px); }

        .search-group {
            flex: 1; min-width: 180px;
            border-right: 1px solid var(--border); padding: 8px 18px;
            display: flex; flex-direction: column; justify-content: center;
            transition: background 0.2s; border-radius: 20px;
        }
        .search-group:hover { background: var(--bg); }
        .search-group:last-of-type { border-right: none; }
        .search-group label {
            font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em; color: var(--ink-3); margin-bottom: 4px;
            display: flex; align-items: center; gap: 6px;
        }
        .search-group label [data-lucide] { width: 12px; height: 12px; }
        .search-group input,
        .search-group select {
            border: none; outline: none; width: 100%;
            font-family: inherit; font-size: 0.95rem; color: var(--ink);
            background: transparent; font-weight: 500;
        }
        .search-group input::placeholder { color: var(--ink-3); font-weight: 400; }

        .search-btn {
            background: var(--accent); color: white; border: none; border-radius: 28px;
            padding: 14px 28px; font-family: inherit; font-size: 0.95rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s cubic-bezier(0.165,0.84,0.44,1);
            display: flex; align-items: center; gap: 8px; white-space: nowrap; flex-shrink: 0;
        }
        .search-btn [data-lucide] { width: 17px; height: 17px; transition: transform 0.2s; }
        .search-btn:hover { background: #9a3412; transform: scale(1.04); box-shadow: 0 8px 20px rgba(184,74,28,0.3); }
        .search-btn:hover [data-lucide] { transform: translateX(3px); }
        .search-btn:active { transform: scale(0.98); }

        /* Quick Tags */
        .quick-tags { display: flex; justify-content: center; gap: 10px; margin-top: 1.5rem; flex-wrap: wrap; }
        .quick-tag {
            background: rgba(255,255,255,0.7); backdrop-filter: blur(8px);
            border: 1px solid var(--border); padding: 6px 16px; border-radius: 20px;
            font-size: 0.82rem; color: var(--ink-2); text-decoration: none;
            display: flex; align-items: center; gap: 6px;
            transition: all 0.2s ease;
        }
        .quick-tag [data-lucide] { width: 13px; height: 13px; }
        .quick-tag:hover { background: var(--accent); color: white; border-color: var(--accent); transform: translateY(-1px); }

        @media (max-width: 768px) {
            .search-hero { padding: 4rem 5% 3rem; }
            .search-container { flex-direction: column; border-radius: 24px; padding: 16px; gap: 8px; }
            .search-group { border-right: none; border-bottom: 1px solid var(--border); padding: 12px 8px; width: 100%; }
            .search-group:last-of-type { border-bottom: none; }
            .search-btn { width: 100%; justify-content: center; margin-top: 8px; }
        }

        /* ── Results Meta ── */
        .browse-layout { max-width: 1300px; margin: 0 auto; padding: 4rem 5%; }
        .results-meta {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border);
        }
        .results-meta h2 {
            font-size: 1.25rem; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
        }
        .results-meta h2 [data-lucide] { width: 20px; height: 20px; color: var(--accent); }
        .results-meta h2 span { color: var(--accent); font-family: 'Cormorant Garamond', serif; font-size: 1.4em; font-weight: 600; }
        .active-filters { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .chip {
            background: var(--accent-lt); color: var(--accent);
            padding: 5px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 600;
            border: 1px solid rgba(184,74,28,0.15);
            display: flex; align-items: center; gap: 5px;
        }
        .chip [data-lucide] { width: 12px; height: 12px; }
        .reset-link {
            font-size: 0.85rem; color: var(--accent); text-decoration: none;
            font-weight: 600; padding: 5px 12px; border-radius: 8px;
            display: flex; align-items: center; gap: 5px;
            transition: background 0.2s;
        }
        .reset-link [data-lucide] { width: 14px; height: 14px; }
        .reset-link:hover { background: var(--accent-lt); }

        /* ── Recipe Grid ── */
        .recipe-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2.5rem; }

        .recipe-card {
            background: var(--surface); border-radius: 24px; overflow: hidden;
            text-decoration: none; color: inherit; display: block;
            transition: all 0.5s cubic-bezier(0.165,0.84,0.44,1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid transparent;
        }
        .recipe-card:hover { transform: translateY(-10px) scale(1.01); box-shadow: 0 30px 60px rgba(0,0,0,0.1); border-color: var(--border); }

        .card-img {
            width: 100%; aspect-ratio: 4/3;
            position: relative; overflow: hidden; border-radius: 24px 24px 0 0;
            background: linear-gradient(135deg, #f5f5f4, #e7e5e4);
        }
        .card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s cubic-bezier(0.165,0.84,0.44,1); }
        .recipe-card:hover .card-img img { transform: scale(1.1); }
        .card-img::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 50%;
            background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
            opacity: 0; transition: opacity 0.4s; pointer-events: none;
        }
        .recipe-card:hover .card-img::after { opacity: 1; }

        /* No-image placeholder */
        .card-img-placeholder {
            height: 100%; display: grid; place-items: center;
        }
        .card-img-placeholder [data-lucide] { width: 64px; height: 64px; color: #c4b5a5; }

        /* Badges */
        .card-badge {
            position: absolute; top: 16px; left: 16px;
            background: rgba(255,255,255,0.92); backdrop-filter: blur(12px);
            padding: 6px 14px; border-radius: 14px;
            font-size: 0.75rem; font-weight: 700; color: var(--ink);
            box-shadow: 0 2px 8px rgba(0,0,0,0.08); z-index: 2;
            display: flex; align-items: center; gap: 5px;
        }
        .card-badge [data-lucide] { width: 12px; height: 12px; color: var(--accent); }

        /* Favorite button */
        .fav-form { position: absolute; top: 16px; right: 16px; z-index: 10; }
        .card-fav {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.95); border-radius: 50%;
            display: grid; place-items: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            transition: all 0.3s cubic-bezier(0.165,0.84,0.44,1);
            cursor: pointer; border: none; color: var(--ink-2);
            text-decoration: none;
        }
        .card-fav [data-lucide] { width: 18px; height: 18px; transition: all 0.3s; }
        .card-fav:hover { transform: scale(1.15) rotate(-5deg); box-shadow: 0 4px 16px rgba(184,74,28,0.25); color: var(--accent); }
        .card-fav.active { color: var(--accent); background: var(--accent-lt); }
        .card-fav.active [data-lucide] { fill: var(--accent); }

        .card-difficulty {
            position: absolute; bottom: 16px; left: 16px;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(8px);
            color: white; padding: 4px 12px; border-radius: 10px;
            font-size: 0.72rem; font-weight: 600;
            display: flex; align-items: center; gap: 5px;
            opacity: 0; transform: translateY(10px);
            transition: all 0.4s ease; z-index: 2;
        }
        .card-difficulty [data-lucide] { width: 12px; height: 12px; }
        .recipe-card:hover .card-difficulty { opacity: 1; transform: translateY(0); }

        .card-view-hint {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%,-50%) scale(0.8);
            background: rgba(255,255,255,0.95); color: var(--accent);
            padding: 10px 24px; border-radius: 30px;
            font-weight: 600; font-size: 0.9rem;
            display: flex; align-items: center; gap: 7px;
            opacity: 0; transition: all 0.4s cubic-bezier(0.165,0.84,0.44,1);
            pointer-events: none; z-index: 3;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .card-view-hint [data-lucide] { width: 16px; height: 16px; }
        .recipe-card:hover .card-view-hint { opacity: 1; transform: translate(-50%,-50%) scale(1); }

        /* Card body */
        .card-body { padding: 1.75rem 1.5rem; }
        .card-title { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 600; margin-bottom: 10px; transition: color 0.3s; line-height: 1.3; }
        .recipe-card:hover .card-title { color: var(--accent); }

        .card-author { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
        .card-author-avatar {
            width: 28px; height: 28px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--gold));
            display: grid; place-items: center; color: white; font-size: 0.75rem; font-weight: 600;
        }
        .card-author-name { font-size: 0.85rem; color: var(--ink-3); font-weight: 500; }

        .card-info {
            display: flex; align-items: center; gap: 12px;
            color: var(--ink-3); font-size: 0.85rem; font-weight: 500;
            padding-top: 14px; border-top: 1px solid var(--border);
        }
        .info-item { display: flex; align-items: center; gap: 5px; }
        .info-item [data-lucide] { width: 14px; height: 14px; flex-shrink: 0; }
        .info-item.rating [data-lucide] { color: var(--gold); fill: var(--gold); }
        .info-item.time   [data-lucide] { color: #6b7280; }
        .info-item.cal    [data-lucide] { color: #ef4444; }
        .separator { color: var(--border); }

        /* Empty state */
        .empty-state { grid-column: 1/-1; text-align: center; padding: 6rem 0; }
        .empty-state [data-lucide] { width: 72px; height: 72px; color: var(--border); margin-bottom: 1.5rem; display: block; margin-left: auto; margin-right: auto; }
        .empty-state p { font-size: 1.1rem; color: var(--ink-3); }

        /* Pagination */
        .pagination-wrap { margin-top: 4rem; display: flex; justify-content: center; }

        footer {
            padding: 4rem 5%; background: white; border-top: 1px solid var(--border);
            text-align: center; color: var(--ink-3);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        footer [data-lucide] { width: 15px; height: 15px; color: var(--accent); fill: var(--accent); }
    </style>
</head>
<body>

{{-- ── Flash Messages ── --}}
@if(session('success') || session('error'))
<div class="flash">
    @if(session('success'))
        <div class="flash-msg success">
            <i data-lucide="check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flash-msg error">
            <i data-lucide="x-circle"></i>
            {{ session('error') }}
        </div>
    @endif
</div>
@endif

{{-- ── Navigation ── --}}
<nav>
    <a href="{{ route('home') }}" class="nav-brand">
        <i data-lucide="chef-hat"></i> Saveur
    </a>
    <div class="nav-links">
        <a href="{{ route('recipes.index') }}">
            <i data-lucide="book-open"></i> Recettes
        </a>
        @auth
          
            <a href="{{ route('recipes.create') }}" class="btn btn-primary">
                <i data-lucide="plus"></i> Partager
            </a>
        @else
            <a href="{{ route('login') }}" class="btn">
                <i data-lucide="log-in"></i> Connexion
            </a>
            <a href="{{ route('signup') }}" class="btn btn-primary">
                <i data-lucide="user-plus"></i> S'inscrire
            </a>
        @endauth
    </div>
</nav>

{{-- ── Search Hero ── --}}
<header class="search-hero">
    <h1>Qu'allez-vous cuisiner ?</h1>
    <p>Découvrez des recettes savoureuses, partagées par notre communauté de passionnés</p>

    <div class="search-wrapper">
        <form action="{{ route('recipes.index') }}" method="GET" class="search-container">

            <div class="search-group">
                <label><i data-lucide="search"></i> Recherche</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Pizza, poulet, dessert...">
            </div>

            <div class="search-group">
                <label><i data-lucide="layout-grid"></i> Catégorie</label>
                <select name="category_id">
                    <option value="">Toutes les envies</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="search-group">
                <label><i data-lucide="timer"></i> Temps Max</label>
                <select name="max_time">
                    <option value="">Peu importe</option>
                    <option value="15"  {{ request('max_time') == 15  ? 'selected' : '' }}>Express (15 min)</option>
                    <option value="30"  {{ request('max_time') == 30  ? 'selected' : '' }}>Rapide (30 min)</option>
                    <option value="60"  {{ request('max_time') == 60  ? 'selected' : '' }}>Moins d'1h</option>
                </select>
            </div>

            <button type="submit" class="search-btn">
                Trouver <i data-lucide="arrow-right"></i>
            </button>
        </form>
    </div>

    <div class="quick-tags">
        <a href="?q=pizza"      class="quick-tag"><i data-lucide="pizza"></i> Pizza</a>
        <a href="?q=poulet"     class="quick-tag"><i data-lucide="drumstick"></i> Poulet</a>
        <a href="?q=dessert"    class="quick-tag"><i data-lucide="cake-slice"></i> Dessert</a>
        <a href="?q=végétarien" class="quick-tag"><i data-lucide="salad"></i> Végétarien</a>
        <a href="?q=rapide"     class="quick-tag"><i data-lucide="zap"></i> Rapide</a>
        <a href="?q=soupe"      class="quick-tag"><i data-lucide="soup"></i> Soupe</a>
    </div>
</header>

{{-- ── Main Results ── --}}
<main class="browse-layout">

    <div class="results-meta">
        <h2>
            <i data-lucide="utensils"></i>
            <span>{{ $recipes->total() }}</span> Recettes trouvées
        </h2>
        <div class="active-filters">
            @if(request('q'))
                <span class="chip"><i data-lucide="search"></i> "{{ request('q') }}"</span>
            @endif
            @if(request('category_id'))
                <span class="chip"><i data-lucide="layout-grid"></i> Catégorie</span>
            @endif
            @if(request('max_time'))
                <span class="chip"><i data-lucide="timer"></i> ≤ {{ request('max_time') }} min</span>
            @endif
            <a href="{{ route('recipes.index') }}" class="reset-link">
                <i data-lucide="rotate-ccw"></i> Réinitialiser
            </a>
        </div>
    </div>

    <div class="recipe-grid">
        @forelse($recipes as $recipe)

            <div style="position:relative;">

                {{-- ── Favorite Button ── --}}
                @auth
                    <form class="fav-form" action="{{ route('favorites') }}" method="POST">
                        @csrf
                        <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                        <button
                            type="submit"
                            class="card-fav {{ $recipe->isFavoritedBy(auth()->user()) ? 'active' : '' }}"
                            title="{{ $recipe->isFavoritedBy(auth()->user()) ? 'Retirer des favoris' : 'Ajouter aux favoris' }}"
                        >
                            <i data-lucide="heart"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="card-fav fav-form" title="Connectez-vous pour ajouter aux favoris">
                        <i data-lucide="heart"></i>
                    </a>
                @endauth

                {{-- ── Recipe Card ── --}}
                <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card">
                    <div class="card-img">

                        @if($recipe->image)
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" loading="lazy">
                        @else
                            <div class="card-img-placeholder">
                                <i data-lucide="chef-hat"></i>
                            </div>
                        @endif

                        <div class="card-badge">
                            <i data-lucide="tag"></i>
                            {{ $recipe->category->name ?? 'Recette' }}
                        </div>

                        <div class="card-difficulty">
                            <i data-lucide="bar-chart-2"></i> Facile
                        </div>

                        <div class="card-view-hint">
                            <i data-lucide="eye"></i> Voir la recette
                        </div>
                    </div>

                    <div class="card-body">
                        <h3 class="card-title">{{ $recipe->title }}</h3>

                        <div class="card-author">
                            <div class="card-author-avatar">
                                {{ substr($recipe->user->name ?? 'C', 0, 1) }}
                            </div>
                            <span class="card-author-name">{{ $recipe->user->name ?? 'Chef' }}</span>
                        </div>

                        <div class="card-info">
                            <span class="info-item rating">
                                <i data-lucide="star"></i>
                                {{ number_format($recipe->average_rating ?? 5.0, 1) }}
                            </span>
                            <span class="separator">|</span>
                            <span class="info-item time">
                                <i data-lucide="clock"></i>
                                {{ ($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0) }} min
                            </span>
                            <span class="separator">|</span>
                            <span class="info-item cal">
                                <i data-lucide="flame"></i>
                                {{ $recipe->calories ?? '—' }} kcal
                            </span>
                        </div>
                    </div>
                </a>

            </div>{{-- end wrapper --}}

        @empty
            <div class="empty-state">
                <i data-lucide="search-x"></i>
                <p>Oups ! Aucune recette trouvée pour cette recherche.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-wrap">
        {{ $recipes->appends(request()->query())->links() }}
    </div>
</main>

<footer>
    <i data-lucide="heart"></i>
    <p>&copy; {{ date('Y') }} Saveur. Créé avec passion pour les gourmands.</p>
</footer>

<script>
    // Auto-dismiss flash after 3s
    setTimeout(() => {
        document.querySelectorAll('.flash-msg').forEach(el => el.remove());
    }, 3000);
</script>

</body>
</html>
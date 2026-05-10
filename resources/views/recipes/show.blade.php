{{-- resources/views/recipes/show.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $recipe->title }} — Saveur</title>
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
            --sage-lt:   #eaf2e8;
            --border:    #e8e0d4;
            --r-sm:      8px;
            --r-md:      14px;
            --r-lg:      22px;
        }

        body { font-family: 'Outfit', sans-serif; background: var(--bg); color: var(--ink); min-height: 100vh; -webkit-font-smoothing: antialiased; }

        .flash        { background: var(--sage); color: #fff; text-align: center; padding: .6rem 1rem; font-size: .85rem; letter-spacing: .02em; }
        .flash-error  { background: #c0392b; }

        nav {
            position: sticky; top: 0; z-index: 200;
            background: rgba(249,246,241,0.92); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2.5rem; height: 68px;
        }
        .nav-brand { font-family: 'Cormorant Garamond', serif; font-size: 1.9rem; font-weight: 600; color: var(--accent); text-decoration: none; }
        .nav-links  { display: flex; align-items: center; gap: 1.8rem; }
        .nav-links a { text-decoration: none; color: var(--ink-2); font-size: .9rem; font-weight: 500; transition: color .2s; }
        .nav-links a:hover { color: var(--accent); }

        .btn { display: inline-flex; align-items: center; gap: .4rem; text-decoration: none; padding: .5rem 1.25rem; border-radius: 999px; font-family: 'Outfit', sans-serif; font-size: .85rem; font-weight: 500; cursor: pointer; border: 1.5px solid transparent; transition: all .18s; white-space: nowrap; }
        .btn-primary { background: var(--accent); color: #fff; border-color: var(--accent); }
        .btn-primary:hover { background: #9e3a12; }
        .btn-outline { background: transparent; color: var(--accent); border-color: var(--accent); }
        .btn-outline:hover { background: var(--accent); color: #fff; }
        .btn-ghost   { background: var(--surface); color: var(--ink-2); border-color: var(--border); }
        .btn-ghost:hover { border-color: var(--ink-3); color: var(--ink); }
        .btn-danger  { background: transparent; color: #c0392b; border-color: #c0392b; }
        .btn-danger:hover { background: #c0392b; color: #fff; }
        .btn-fav     { background: var(--accent-lt); color: var(--accent); border-color: var(--accent); }
        .btn-fav.active { background: var(--accent); color: #fff; }
        .btn-sm { font-size: .78rem; padding: .38rem .95rem; }

        /* HERO */
        .recipe-hero { width: 100%; aspect-ratio: 21/7; background: linear-gradient(160deg, #ecdec8 0%, #c9a87a 100%); position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; }
        .recipe-hero img { width: 100%; height: 100%; object-fit: cover; }
        .recipe-hero-placeholder { font-size: 7rem; opacity: .15; }
        .recipe-hero-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(24,20,14,.65) 0%, transparent 55%); }
        .recipe-hero-meta { position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); width: 100%; max-width: 1180px; padding: 0 2.5rem; display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; }
        .hero-title-block .cat-pill { display: inline-block; background: var(--accent); color: #fff; font-size: .7rem; font-weight: 600; letter-spacing: .07em; text-transform: uppercase; padding: .28rem .8rem; border-radius: 999px; margin-bottom: .6rem; }
        .hero-title-block h1 { font-family: 'Cormorant Garamond', serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 600; color: #fff; line-height: 1.1; text-shadow: 0 2px 12px rgba(0,0,0,.3); }
        .hero-title-block .author-line { color: rgba(255,255,255,.75); font-size: .85rem; margin-top: .5rem; }
        .hero-title-block .author-line strong { color: #fff; }
        .hero-quick-stats { display: flex; gap: .8rem; flex-shrink: 0; flex-wrap: wrap; justify-content: flex-end; }
        .hero-stat-pill { background: rgba(255,255,255,.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,.25); border-radius: var(--r-md); padding: .6rem 1rem; text-align: center; color: #fff; }
        .hero-stat-pill .val { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 600; line-height: 1; }
        .hero-stat-pill .key { font-size: .65rem; font-weight: 500; text-transform: uppercase; letter-spacing: .06em; opacity: .7; margin-top: .2rem; }

        /* BREADCRUMB */
        .breadcrumb { max-width: 1180px; margin: 0 auto; padding: 1.2rem 2.5rem .5rem; display: flex; align-items: center; gap: .5rem; font-size: .8rem; color: var(--ink-3); }
        .breadcrumb a { text-decoration: none; color: var(--ink-3); }
        .breadcrumb a:hover { color: var(--accent); }

        /* LAYOUT */
        .recipe-layout { max-width: 1180px; margin: 0 auto; padding: 2rem 2.5rem 5rem; display: grid; grid-template-columns: 1fr 320px; gap: 3rem; align-items: start; }

        /* DRAFT */
        .draft-notice { background: #fffbeb; border: 1px solid #f6d860; border-radius: var(--r-md); padding: .9rem 1.2rem; display: flex; align-items: center; gap: .75rem; font-size: .85rem; color: #7a5c00; margin-bottom: 1.8rem; }

        /* DESCRIPTION */
        .recipe-description { font-size: 1.05rem; font-weight: 300; color: var(--ink-2); line-height: 1.8; margin-bottom: 2rem; }

        /* TAGS */
        .tags-row { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 2rem; }
        .tag-pill { display: inline-flex; align-items: center; background: var(--bg); border: 1px solid var(--border); border-radius: 999px; padding: .28rem .8rem; font-size: .78rem; color: var(--ink-3); text-decoration: none; transition: all .18s; }
        .tag-pill:hover { border-color: var(--accent); color: var(--accent); }

        /* INGREDIENTS */
        .section-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: var(--accent); margin-bottom: 1rem; }
        .ingredients-list { list-style: none; display: flex; flex-direction: column; gap: .55rem; margin-bottom: 2.5rem; }
        .ingredients-list li { display: flex; align-items: baseline; gap: .7rem; font-size: .95rem; color: var(--ink-2); padding: .55rem 0; border-bottom: 1px solid var(--border); line-height: 1.5; }
        .ingredients-list li::before { content: ''; width: 5px; height: 5px; background: var(--accent); border-radius: 50%; flex-shrink: 0; margin-top: .12rem; }

        /* STEPS */
        .steps-list { list-style: none; display: flex; flex-direction: column; gap: 1.2rem; margin-bottom: 2.5rem; }
        .steps-list li { display: flex; gap: 1rem; align-items: flex-start; }
        .step-num { width: 32px; height: 32px; border-radius: 50%; background: var(--accent); color: #fff; display: flex; align-items: center; justify-content: center; font-size: .78rem; font-weight: 700; flex-shrink: 0; margin-top: .05rem; }
        .step-content { font-size: .95rem; color: var(--ink-2); line-height: 1.75; flex: 1; }

        /* OWNER ACTIONS */
        .owner-actions { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; margin-bottom: 1.8rem; padding: .9rem 1.2rem; background: var(--gold-lt); border: 1px solid #f0d88a; border-radius: var(--r-md); }
        .owner-actions-label { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; color: var(--gold); margin-right: auto; }

        /* SIDEBAR */
        .sidebar { display: flex; flex-direction: column; gap: 1.2rem; }
        .sidebar-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; }
        .sidebar-card-head { padding: .85rem 1.2rem; background: #faf7f3; border-bottom: 1px solid var(--border); font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--ink-3); }
        .sidebar-card-body { padding: 1.2rem; }

        /* TIMING */
        .timing-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; }
        .timing-cell { text-align: center; padding: .75rem; background: var(--bg); border-radius: var(--r-sm); }
        .timing-cell .val { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 600; color: var(--ink); line-height: 1; }
        .timing-cell .lbl { font-size: .65rem; text-transform: uppercase; letter-spacing: .07em; color: var(--ink-3); margin-top: .25rem; }

        /* AUTHOR */
        .author-card-inner { display: flex; align-items: center; gap: .9rem; }
        .author-avatar { width: 44px; height: 44px; border-radius: 50%; background: var(--accent-lt); color: var(--accent); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem; flex-shrink: 0; }
        .author-name { font-weight: 600; color: var(--ink); font-size: .92rem; }
        .author-sub  { font-size: .75rem; color: var(--ink-3); margin-top: .15rem; }

        /* RATING */
        .rating-display { display: flex; align-items: center; gap: .6rem; margin-bottom: .3rem; }
        .stars-big { font-size: 1.3rem; color: var(--gold); letter-spacing: .05em; }
        .rating-val { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 600; color: var(--ink); line-height: 1; }
        .rating-count { font-size: .78rem; color: var(--ink-3); }

        /* STAR PICKER */
        .star-picker { display: flex; flex-direction: row-reverse; gap: .2rem; justify-content: center; font-size: 1.5rem; }
        .star-picker input { display: none; }
        .star-picker label { color: var(--border); cursor: pointer; transition: color .15s; }
        .star-picker input:checked ~ label,
        .star-picker label:hover,
        .star-picker label:hover ~ label { color: var(--gold); }

        footer { border-top: 1px solid var(--border); padding: 2rem 2.5rem; text-align: center; font-size: .82rem; color: var(--ink-3); }
        footer a { color: var(--accent); text-decoration: none; }

        @media (max-width: 800px) {
            .recipe-layout { grid-template-columns: 1fr; }
            nav { padding: 0 1.25rem; }
            .recipe-hero-meta { flex-direction: column; align-items: flex-start; }
            .hero-quick-stats { justify-content: flex-start; }
        }
    </style>
</head>
<body>

{{-- Flash --}}
@if(session('success'))
    <div class="flash">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash flash-error">{{ session('error') }}</div>
@endif

{{-- Nav --}}
<nav>
    <a href="{{ route('home') }}" class="nav-brand">Saveur</a>
    <div class="nav-links">
        <a href="{{ route('recipes.index') }}">Recettes</a>
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Admin</a>
            @else
                <a href="{{ route('recipes.my') }}">Mes recettes</a>
                <a href="{{ route('recipes.favorites') }}">Favoris</a>
                <a href="{{ route('recipes.create') }}" class="btn btn-primary">+ Nouvelle</a>
            @endif
            <a href="{{ route('profile.edit') }}">{{ Auth::user()->name }}</a>
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

{{-- Hero Banner --}}
<div class="recipe-hero">
    @if($recipe->image)
        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
    @else
        <div class="recipe-hero-placeholder">🍽️</div>
    @endif
    <div class="recipe-hero-overlay"></div>
    <div class="recipe-hero-meta">
        <div class="hero-title-block">
            @if($recipe->category)
                <span class="cat-pill">{{ $recipe->category->name }}</span>
            @endif
            <h1>{{ $recipe->title }}</h1>
            @if($recipe->user)
                <div class="author-line">
                    Par <strong>{{ $recipe->user->name }}</strong>
                    · {{ $recipe->created_at->format('d M Y') }}
                </div>
            @endif
        </div>
        <div class="hero-quick-stats">
            @if($recipe->prep_time)
                <div class="hero-stat-pill">
                    <div class="val">{{ $recipe->prep_time }}<small style="font-size:.55em"> min</small></div>
                    <div class="key">Prép.</div>
                </div>
            @endif
            @if($recipe->cook_time)
                <div class="hero-stat-pill">
                    <div class="val">{{ $recipe->cook_time }}<small style="font-size:.55em"> min</small></div>
                    <div class="key">Cuisson</div>
                </div>
            @endif
            @if($recipe->servings)
                <div class="hero-stat-pill">
                    <div class="val">{{ $recipe->servings }}</div>
                    <div class="key">Portions</div>
                </div>
            @endif
            @php $avg = $recipe->ratings->avg('score') ?? 0; @endphp
            @if($recipe->ratings->count() > 0)
                <div class="hero-stat-pill">
                    <div class="val">{{ number_format($avg, 1) }}</div>
                    <div class="key">Note</div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('home') }}">Accueil</a>
    <span>/</span>
    <a href="{{ route('recipes.index') }}">Recettes</a>
    @if($recipe->category)
        <span>/</span>
        <a href="{{ route('recipes.by-category', $recipe->category) }}">{{ $recipe->category->name }}</a>
    @endif
    <span>/</span>
    <span style="color:var(--ink-2)">{{ Str::limit($recipe->title, 40) }}</span>
</div>

{{-- Main Layout --}}
<div class="recipe-layout">

    {{-- LEFT: Main content --}}
    <div>

        {{-- Brouillon --}}
        @if(!$recipe->is_published)
        <div class="draft-notice">
            ⚠️ <span>Cette recette est en <strong>brouillon</strong> — non visible par le public.</span>
        </div>
        @endif

        {{-- Owner actions --}}
        @auth
        @if(Auth::id() === $recipe->user_id || Auth::user()->role === 'admin')
        <div class="owner-actions">
            <span class="owner-actions-label">Gérer la recette</span>
            <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline btn-sm">✏️ Modifier</a>
            <form method="POST" action="{{ route('recipes.destroy', $recipe) }}"
                  onsubmit="return confirm('Supprimer « {{ addslashes($recipe->title) }} » ? Cette action est irréversible.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">🗑 Supprimer</button>
            </form>
        </div>
        @endif
        @endauth

        {{-- Description --}}
        @if($recipe->description)
        <p class="recipe-description">{{ $recipe->description }}</p>
        @endif

        {{-- Tags --}}
        @if($recipe->tags->isNotEmpty())
        <div class="tags-row">
            @foreach($recipe->tags as $tag)
                <a href="{{ route('recipes.by-tag', $tag) }}" class="tag-pill">#{{ $tag->name }}</a>
            @endforeach
        </div>
        @endif

        {{-- Ingredients --}}
        @if($recipe->ingredients)
        <div class="section-label">Ingrédients</div>
        <ul class="ingredients-list">
            @foreach(array_filter(explode("\n", trim($recipe->ingredients))) as $ingredient)
                <li>{{ trim($ingredient) }}</li>
            @endforeach
        </ul>
        @endif

        {{-- Steps --}}
        @if($recipe->steps)
        <div class="section-label">Instructions</div>
        <ol class="steps-list">
            @foreach(array_filter(explode("\n", trim($recipe->steps))) as $index => $step)
                <li>
                    <div class="step-num">{{ $index + 1 }}</div>
                    <div class="step-content">{{ trim($step) }}</div>
                </li>
            @endforeach
        </ol>
        @endif

    </div>

    {{-- RIGHT: Sidebar --}}
    <aside class="sidebar">

        {{-- Timing --}}
        @if($recipe->prep_time || $recipe->cook_time || $recipe->servings)
        <div class="sidebar-card">
            <div class="sidebar-card-head">En un coup d'œil</div>
            <div class="sidebar-card-body" style="padding:.75rem">
                <div class="timing-grid">
                    @if($recipe->prep_time)
                    <div class="timing-cell">
                        <div class="val">{{ $recipe->prep_time }}<small style="font-size:.55em;color:var(--ink-3)"> min</small></div>
                        <div class="lbl">Préparation</div>
                    </div>
                    @endif
                    @if($recipe->cook_time)
                    <div class="timing-cell">
                        <div class="val">{{ $recipe->cook_time }}<small style="font-size:.55em;color:var(--ink-3)"> min</small></div>
                        <div class="lbl">Cuisson</div>
                    </div>
                    @endif
                    @if($recipe->prep_time && $recipe->cook_time)
                    <div class="timing-cell">
                        <div class="val">{{ $recipe->prep_time + $recipe->cook_time }}<small style="font-size:.55em;color:var(--ink-3)"> min</small></div>
                        <div class="lbl">Total</div>
                    </div>
                    @endif
                    @if($recipe->servings)
                    <div class="timing-cell">
                        <div class="val">{{ $recipe->servings }}</div>
                        <div class="lbl">Portions</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Favori --}}
        @auth
        @if(Auth::id() !== $recipe->user_id)
        <div class="sidebar-card">
            <div class="sidebar-card-body" style="padding:.85rem">
                <form method="POST" action="{{ route('recipes.favorite', $recipe) }}">
                    @csrf
                    <button type="submit" class="btn btn-fav {{ $isFavorited ? 'active' : '' }}" style="width:100%;justify-content:center">
                        {{ $isFavorited ? '❤️ Dans vos favoris' : '🤍 Ajouter aux favoris' }}
                    </button>
                </form>
            </div>
        </div>
        @endif
        @endauth

        {{-- Author --}}
        @if($recipe->user)
        <div class="sidebar-card">
            <div class="sidebar-card-head">Recette par</div>
            <div class="sidebar-card-body">
                <div class="author-card-inner">
                    <div class="author-avatar">{{ strtoupper(substr($recipe->user->name, 0, 1)) }}</div>
                    <div>
                        <div class="author-name">{{ $recipe->user->name }}</div>
                        <div class="author-sub">Membre depuis {{ $recipe->user->created_at->format('Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Rating --}}
        <div class="sidebar-card">
            <div class="sidebar-card-head">Note</div>
            <div class="sidebar-card-body">
                @php
                    $avg   = $recipe->ratings->avg('score') ?? 0;
                    $count = $recipe->ratings->count();
                @endphp
                @if($count > 0)
                <div class="rating-display">
                    <span class="stars-big">
                        @for($i = 1; $i <= 5; $i++){{ $i <= round($avg) ? '●' : '○' }}@endfor
                    </span>
                    <span class="rating-val">{{ number_format($avg, 1) }}</span>
                </div>
                <div class="rating-count">{{ $count }} {{ $count > 1 ? 'avis' : 'avis' }}</div>
                @else
                <p style="font-size:.85rem;color:var(--ink-3);margin-bottom:.75rem">Pas encore d'avis. Soyez le premier !</p>
                @endif

                {{-- Formulaire de note --}}
                @auth
                    @if(Auth::id() !== $recipe->user_id)
                    <form method="POST" action="{{ route('recipes.rate', $recipe) }}" style="margin-top:1rem">
                        @csrf
                        <div style="font-size:.78rem;font-weight:500;color:var(--ink-3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.4rem">
                            {{ $userRating ? 'Votre note : ' . $userRating->score . ' ●' : 'Votre note' }}
                        </div>
                        <div class="star-picker">
                            @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="score" id="star{{ $i }}" value="{{ $i }}"
                                   {{ $userRating && $userRating->score == $i ? 'checked' : '' }}>
                            <label for="star{{ $i }}">●</label>
                            @endfor
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top:.6rem;width:100%;justify-content:center">
                            {{ $userRating ? 'Modifier ma note' : 'Soumettre ma note' }}
                        </button>
                    </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="margin-top:.8rem;width:100%;justify-content:center">
                        Connexion pour noter
                    </a>
                @endauth
            </div>
        </div>

        {{-- More like this --}}
        @if($recipe->category || $recipe->tags->isNotEmpty())
        <div class="sidebar-card">
            <div class="sidebar-card-head">Plus comme ça</div>
            <div class="sidebar-card-body">
                @if($recipe->category)
                <a href="{{ route('recipes.by-category', $recipe->category) }}"
                   style="display:inline-flex;align-items:center;gap:.4rem;text-decoration:none;background:var(--accent-lt);color:var(--accent);font-size:.8rem;font-weight:600;padding:.35rem .9rem;border-radius:999px;margin-bottom:.85rem;">
                    Recettes {{ $recipe->category->name }} →
                </a>
                @endif
                @if($recipe->tags->isNotEmpty())
                <div style="display:flex;flex-wrap:wrap;gap:.4rem">
                    @foreach($recipe->tags as $tag)
                    <a href="{{ route('recipes.by-tag', $tag) }}" class="tag-pill">#{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

    </aside>
</div>

<footer>
    <p>© {{ date('Y') }} <a href="{{ route('home') }}">Saveur</a> — fait avec ❤️ pour les cuisiniers du monde entier.</p>
</footer>

</body>
</html>

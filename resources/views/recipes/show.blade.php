<!DOCTYPE html>
<html lang="en">
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

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── FLASH ── */
        .flash {
            background: var(--sage); color: #fff;
            text-align: center; padding: .6rem 1rem;
            font-size: .85rem; letter-spacing: .02em;
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
        .btn-ghost   { background: var(--surface); color: var(--ink-2); border-color: var(--border); }
        .btn-ghost:hover { border-color: var(--ink-3); color: var(--ink); }
        .btn-danger  { background: transparent; color: #c0392b; border-color: #c0392b; }
        .btn-danger:hover { background: #c0392b; color: #fff; }
        .btn-sm { font-size: .78rem; padding: .38rem .95rem; }

        /* ── HERO BANNER ── */
        .recipe-hero {
            width: 100%;
            aspect-ratio: 21/7;
            background: linear-gradient(160deg, #ecdec8 0%, #c9a87a 100%);
            position: relative;
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }
        .recipe-hero img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .recipe-hero-placeholder {
            font-size: 7rem; opacity: .15;
        }
        .recipe-hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(24,20,14,.65) 0%, transparent 55%);
        }
        .recipe-hero-meta {
            position: absolute; bottom: 2rem; left: 50%;
            transform: translateX(-50%);
            width: 100%; max-width: 1180px;
            padding: 0 2.5rem;
            display: flex; align-items: flex-end; justify-content: space-between;
            gap: 1rem;
        }
        .hero-title-block .cat-pill {
            display: inline-block;
            background: var(--accent); color: #fff;
            font-size: .7rem; font-weight: 600;
            letter-spacing: .07em; text-transform: uppercase;
            padding: .28rem .8rem; border-radius: 999px;
            margin-bottom: .6rem;
        }
        .hero-title-block h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 600; color: #fff;
            line-height: 1.1; text-shadow: 0 2px 12px rgba(0,0,0,.3);
        }
        .hero-title-block .author-line {
            color: rgba(255,255,255,.75);
            font-size: .85rem; margin-top: .5rem;
        }
        .hero-title-block .author-line strong { color: #fff; }
        .hero-quick-stats {
            display: flex; gap: .8rem; flex-shrink: 0; flex-wrap: wrap;
            justify-content: flex-end;
        }
        .hero-stat-pill {
            background: rgba(255,255,255,.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: var(--r-md);
            padding: .6rem 1rem;
            text-align: center; color: #fff;
        }
        .hero-stat-pill .val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem; font-weight: 600;
            line-height: 1;
        }
        .hero-stat-pill .key {
            font-size: .65rem; font-weight: 500;
            text-transform: uppercase; letter-spacing: .06em;
            opacity: .7; margin-top: .2rem;
        }

        /* ── BREADCRUMB ── */
        .breadcrumb {
            max-width: 1180px; margin: 0 auto;
            padding: 1.2rem 2.5rem .5rem;
            display: flex; align-items: center; gap: .5rem;
            font-size: .8rem; color: var(--ink-3);
        }
        .breadcrumb a { text-decoration: none; color: var(--ink-3); }
        .breadcrumb a:hover { color: var(--accent); }
        .breadcrumb span { opacity: .5; }

        /* ── MAIN LAYOUT ── */
        .recipe-layout {
            max-width: 1180px; margin: 0 auto;
            padding: 2rem 2.5rem 5rem;
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 3rem;
            align-items: start;
        }

        /* ── LEFT COLUMN ── */

        /* Draft notice */
        .draft-notice {
            background: #fffbeb;
            border: 1px solid #f6d860;
            border-radius: var(--r-md);
            padding: .9rem 1.2rem;
            display: flex; align-items: center; gap: .75rem;
            font-size: .85rem; color: #7a5c00;
            margin-bottom: 1.8rem;
        }

        /* Description */
        .recipe-description {
            font-size: 1.05rem; font-weight: 300;
            color: var(--ink-2); line-height: 1.8;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 2rem;
        }

        /* Tags */
        .tags-row {
            display: flex; flex-wrap: wrap; gap: .45rem;
            margin-bottom: 2rem;
        }
        .tag-pill {
            font-size: .75rem; font-weight: 500;
            color: var(--ink-3);
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 999px; padding: .28rem .8rem;
            text-decoration: none; transition: all .18s;
        }
        .tag-pill:hover { background: var(--gold-lt); border-color: var(--gold); color: var(--ink); }

        /* Section headings */
        .section-label {
            display: flex; align-items: center; gap: .75rem;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem; font-weight: 600;
            color: var(--ink); margin-bottom: 1.2rem;
        }
        .section-label::after {
            content: '';
            flex: 1; height: 1px;
            background: var(--border);
        }

        /* Ingredients */
        .ingredients-list {
            list-style: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .5rem;
            margin-bottom: 2.5rem;
        }
        .ingredients-list li {
            display: flex; align-items: flex-start; gap: .65rem;
            font-size: .9rem; color: var(--ink-2);
            padding: .5rem .75rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-sm);
            line-height: 1.4;
        }
        .ingredients-list li::before {
            content: '';
            width: 6px; height: 6px; flex-shrink: 0;
            background: var(--accent); border-radius: 50%;
            margin-top: .45rem;
        }

        /* Steps */
        .steps-list { list-style: none; margin-bottom: 2.5rem; }
        .steps-list li {
            display: flex; gap: 1.2rem;
            padding: 1.2rem 0;
            border-bottom: 1px solid var(--border);
        }
        .steps-list li:last-child { border-bottom: none; }
        .step-num {
            flex-shrink: 0;
            width: 36px; height: 36px;
            background: var(--accent-lt);
            border: 2px solid var(--accent);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem; font-weight: 600;
            color: var(--accent);
        }
        .step-content {
            font-size: .92rem; color: var(--ink-2);
            line-height: 1.75; padding-top: .4rem;
        }

        /* ── OWNER ACTIONS ── */
        .owner-actions {
            display: flex; gap: .6rem; flex-wrap: wrap;
            padding: 1.2rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            margin-bottom: 2rem;
        }
        .owner-actions-label {
            font-size: .7rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .07em;
            color: var(--ink-3); width: 100%;
        }

        /* ── RIGHT SIDEBAR ── */
        .sidebar { display: flex; flex-direction: column; gap: 1.4rem; }

        .sidebar-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            overflow: hidden;
        }
        .sidebar-card-head {
            padding: .9rem 1.2rem;
            border-bottom: 1px solid var(--border);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem; font-weight: 600;
            color: var(--ink);
        }
        .sidebar-card-body { padding: 1.2rem; }

        /* Timing grid */
        .timing-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 1px; background: var(--border);
            border-radius: var(--r-sm); overflow: hidden;
        }
        .timing-cell {
            background: var(--surface);
            padding: .9rem .8rem; text-align: center;
        }
        .timing-cell .val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem; font-weight: 600;
            color: var(--accent); line-height: 1;
        }
        .timing-cell .lbl {
            font-size: .65rem; font-weight: 500;
            text-transform: uppercase; letter-spacing: .06em;
            color: var(--ink-3); margin-top: .25rem;
        }

        /* Author card */
        .author-card-inner {
            display: flex; align-items: center; gap: 1rem;
        }
        .author-avatar {
            width: 48px; height: 48px; border-radius: 50%;
            background: var(--accent-lt); border: 2px solid var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem; font-weight: 600; color: var(--accent);
            flex-shrink: 0;
        }
        .author-name {
            font-weight: 600; font-size: .95rem; color: var(--ink);
        }
        .author-sub {
            font-size: .78rem; color: var(--ink-3); margin-top: .15rem;
        }

        /* Rating display */
        .rating-display {
            display: flex; align-items: center; gap: .6rem;
            margin-bottom: .8rem;
        }
        .stars-big { color: var(--gold); font-size: 1.3rem; letter-spacing: .05em; }
        .rating-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem; font-weight: 600; color: var(--ink);
        }
        .rating-count { font-size: .8rem; color: var(--ink-3); }

        /* Rating form */
        .star-picker {
            display: flex; flex-direction: row-reverse;
            gap: .25rem; margin: .8rem 0;
            width: fit-content;
        }
        .star-picker input { display: none; }
        .star-picker label {
            font-size: 1.6rem; color: var(--border);
            cursor: pointer; transition: color .15s;
        }
        .star-picker input:checked ~ label,
        .star-picker label:hover,
        .star-picker label:hover ~ label {
            color: var(--gold);
        }
        .star-picker input:checked + label { color: var(--gold); }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid var(--border);
            text-align: center; padding: 2rem;
            color: var(--ink-3); font-size: .82rem;
        }
        footer a { color: var(--accent); text-decoration: none; }

        /* ── RESPONSIVE ── */
        @media (max-width: 860px) {
            nav { padding: 0 1.25rem; }
            .recipe-hero { aspect-ratio: 16/9; }
            .recipe-hero-meta { flex-direction: column; align-items: flex-start; bottom: 1.2rem; padding: 0 1.25rem; }
            .hero-quick-stats { justify-content: flex-start; }
            .breadcrumb { padding: 1rem 1.25rem .5rem; }
            .recipe-layout { grid-template-columns: 1fr; gap: 2rem; padding: 1.5rem 1.25rem 3rem; }
            .ingredients-list { grid-template-columns: 1fr; }
            .sidebar { order: -1; }
        }
    </style>
</head>
<body>

{{-- ── FLASH ── --}}
@if(session('success'))
    <div class="flash">{{ session('success') }}</div>
@endif

{{-- ── NAV ── --}}
<nav>
    <a href="{{ route('home') }}" class="nav-brand">Saveur</a>
    <div class="nav-links">
        <a href="{{ route('recipes.index') }}">Recipes</a>
        <a href="{{ route('recipes.search') }}">Browse</a>
        @auth
            <a href="{{ route('recipes.my') }}">My Recipes</a>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary">+ New Recipe</a>
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

{{-- ── HERO BANNER ── --}}
<div class="recipe-hero">
    @if($recipe->image)
        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" />
    @else
        <div class="recipe-hero-placeholder">🍽️</div>
    @endif
    <div class="recipe-hero-overlay"></div>
    <div class="recipe-hero-meta">
        <div class="hero-title-block">
            @if($recipe->category)
                <div class="cat-pill">{{ $recipe->category->name }}</div>
            @endif
            <h1>{{ $recipe->title }}</h1>
            <p class="author-line">
                by <strong>{{ $recipe->user->name ?? 'Unknown' }}</strong>
                &nbsp;·&nbsp; {{ $recipe->created_at->format('M j, Y') }}
            </p>
        </div>
        <div class="hero-quick-stats">
            @if($recipe->prep_time)
            <div class="hero-stat-pill">
                <div class="val">{{ $recipe->prep_time }}<small style="font-size:.7em">m</small></div>
                <div class="key">Prep</div>
            </div>
            @endif
            @if($recipe->cook_time)
            <div class="hero-stat-pill">
                <div class="val">{{ $recipe->cook_time }}<small style="font-size:.7em">m</small></div>
                <div class="key">Cook</div>
            </div>
            @endif
            @if($recipe->servings)
            <div class="hero-stat-pill">
                <div class="val">{{ $recipe->servings }}</div>
                <div class="key">Servings</div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ── BREADCRUMB ── --}}
<div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>/</span>
    <a href="{{ route('recipes.index') }}">Recipes</a>
    @if($recipe->category)
        <span>/</span>
        <a href="{{ route('recipes.by-category', $recipe->category->id) }}">{{ $recipe->category->name }}</a>
    @endif
    <span>/</span>
    <span style="color:var(--ink-2)">{{ Str::limit($recipe->title, 40) }}</span>
</div>

{{-- ── MAIN LAYOUT ── --}}
<div class="recipe-layout">

    {{-- ══ LEFT — CONTENT ══ --}}
    <div class="recipe-main">

        {{-- Draft warning --}}
        @if(!$recipe->is_published)
        <div class="draft-notice">
            ✏️ &nbsp;<strong>Draft</strong> — this recipe is not published yet and is only visible to you.
        </div>
        @endif

        {{-- Owner actions --}}
        @auth
        @if(Auth::id() === $recipe->user_id || Auth::user()->role === 'admin')
        <div class="owner-actions">
            <span class="owner-actions-label">Manage this recipe</span>
            <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
            <form method="POST" action="{{ route('recipes.destroy', $recipe) }}"
                  onsubmit="return confirm('Delete \'{{ addslashes($recipe->title) }}\'? This cannot be undone.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">🗑 Delete</button>
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
                <a href="{{ route('recipes.by-tag', $tag->id) }}" class="tag-pill">#{{ $tag->name }}</a>
            @endforeach
        </div>
        @endif

        {{-- Ingredients --}}
        @if($recipe->ingredients)
        <div class="section-label">Ingredients</div>
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

    {{-- ══ RIGHT — SIDEBAR ══ --}}
    <aside class="sidebar">

        {{-- Timing card --}}
        @if($recipe->prep_time || $recipe->cook_time || $recipe->servings)
        <div class="sidebar-card">
            <div class="sidebar-card-head">At a glance</div>
            <div class="sidebar-card-body" style="padding:.75rem">
                <div class="timing-grid">
                    @if($recipe->prep_time)
                    <div class="timing-cell">
                        <div class="val">{{ $recipe->prep_time }}<small style="font-size:.6em;color:var(--ink-3)"> min</small></div>
                        <div class="lbl">Prep time</div>
                    </div>
                    @endif
                    @if($recipe->cook_time)
                    <div class="timing-cell">
                        <div class="val">{{ $recipe->cook_time }}<small style="font-size:.6em;color:var(--ink-3)"> min</small></div>
                        <div class="lbl">Cook time</div>
                    </div>
                    @endif
                    @if($recipe->prep_time && $recipe->cook_time)
                    <div class="timing-cell">
                        <div class="val">{{ $recipe->prep_time + $recipe->cook_time }}<small style="font-size:.6em;color:var(--ink-3)"> min</small></div>
                        <div class="lbl">Total time</div>
                    </div>
                    @endif
                    @if($recipe->servings)
                    <div class="timing-cell">
                        <div class="val">{{ $recipe->servings }}</div>
                        <div class="lbl">Servings</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Author card --}}
        @if($recipe->user)
        <div class="sidebar-card">
            <div class="sidebar-card-head">Recipe by</div>
            <div class="sidebar-card-body">
                <div class="author-card-inner">
                    <div class="author-avatar">{{ strtoupper(substr($recipe->user->name, 0, 1)) }}</div>
                    <div>
                        <div class="author-name">{{ $recipe->user->name }}</div>
                        <div class="author-sub">Member since {{ $recipe->user->created_at->format('Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Rating card --}}
        <div class="sidebar-card">
            <div class="sidebar-card-head">Rating</div>
            <div class="sidebar-card-body">
                @php
                    $avg = $recipe->ratings->avg('score') ?? 0;
                    $count = $recipe->ratings->count();
                @endphp
                @if($count > 0)
                <div class="rating-display">
                    <span class="stars-big">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= round($avg) ? '★' : '☆' }}
                        @endfor
                    </span>
                    <span class="rating-val">{{ number_format($avg, 1) }}</span>
                </div>
                <div class="rating-count">{{ $count }} {{ Str::plural('review', $count) }}</div>
                @else
                <p style="font-size:.85rem;color:var(--ink-3);margin-bottom:.75rem">No ratings yet. Be the first!</p>
                @endif

                @auth
                @if(Auth::id() !== $recipe->user_id)
                <form method="POST" action="/recipes/{{ $recipe->id }}/rate" style="margin-top:1rem">
                    @csrf
                    <div style="font-size:.78rem;font-weight:500;color:var(--ink-3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.4rem">Your rating</div>
                    <div class="star-picker">
                        @for($i = 5; $i >= 1; $i--)
                        <input type="radio" name="score" id="star{{ $i }}" value="{{ $i }}">
                        <label for="star{{ $i }}">★</label>
                        @endfor
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top:.6rem;width:100%;justify-content:center">Submit rating</button>
                </form>
                @endif
                @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="margin-top:.8rem;width:100%;justify-content:center">Log in to rate</a>
                @endauth
            </div>
        </div>

        {{-- Category / Tags sidebar --}}
        @if($recipe->category || $recipe->tags->isNotEmpty())
        <div class="sidebar-card">
            <div class="sidebar-card-head">More like this</div>
            <div class="sidebar-card-body">
                @if($recipe->category)
                <a href="{{ route('recipes.by-category', $recipe->category->id) }}"
                   style="display:inline-flex;align-items:center;gap:.4rem;text-decoration:none;
                          background:var(--accent-lt);color:var(--accent);
                          font-size:.8rem;font-weight:600;padding:.35rem .9rem;
                          border-radius:999px;margin-bottom:.85rem;">
                    {{ $recipe->category->name }} recipes →
                </a>
                @endif
                @if($recipe->tags->isNotEmpty())
                <div style="display:flex;flex-wrap:wrap;gap:.4rem">
                    @foreach($recipe->tags as $tag)
                    <a href="{{ route('recipes.by-tag', $tag->id) }}" class="tag-pill">#{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

    </aside>
</div>

<footer>
    <p>© {{ date('Y') }} <a href="{{ route('home') }}">Saveur</a> — made with ❤️ for home cooks everywhere.</p>
</footer>

</body>
</html>
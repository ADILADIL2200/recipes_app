<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Saveur — Recipes Worth Making</title>
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

        /* ── FLASH ── */
        .flash {
            background: var(--sage);
            color: #fff;
            text-align: center;
            padding: .6rem 1rem;
            font-size: .85rem;
            letter-spacing: .02em;
        }

        /* ── NAV ── */
        nav {
            position: sticky; top: 0; z-index: 200;
            background: rgba(249, 246, 241, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2.5rem;
            height: 68px;
        }
        .nav-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.9rem;
            font-weight: 600;
            color: var(--accent);
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.8rem;
        }
        .nav-links a {
            text-decoration: none;
            color: var(--ink-2);
            font-size: .9rem;
            font-weight: 500;
            letter-spacing: .01em;
            transition: color .2s;
        }
        .nav-links a:hover { color: var(--accent); }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            text-decoration: none;
            padding: .5rem 1.25rem;
            border-radius: 999px;
            font-family: 'Outfit', sans-serif;
            font-size: .85rem;
            font-weight: 500;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: all .18s;
            white-space: nowrap;
        }
        .btn-primary   { background: var(--accent); color: #fff; border-color: var(--accent); }
        .btn-primary:hover { background: #9e3a12; border-color: #9e3a12; }
        .btn-outline   { background: transparent; color: var(--accent); border-color: var(--accent); }
        .btn-outline:hover { background: var(--accent); color: #fff; }
        .btn-ghost     { background: var(--surface); color: var(--ink-2); border-color: var(--border); }
        .btn-ghost:hover { border-color: var(--ink-3); color: var(--ink); }
        .btn-white     { background: #fff; color: var(--accent); border-color: #fff; }
        .btn-white:hover { background: var(--accent-lt); }

        /* ── HERO ── */
        .hero {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 4rem;
            align-items: center;
            max-width: 1180px;
            margin: 0 auto;
            padding: 5rem 2.5rem 4rem;
        }
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: var(--accent-lt);
            color: var(--accent);
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .35rem .85rem;
            border-radius: 999px;
            margin-bottom: 1.4rem;
        }
        .hero-eyebrow::before {
            content: '';
            display: inline-block;
            width: 6px; height: 6px;
            background: var(--accent);
            border-radius: 50%;
        }
        .hero-text h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(3rem, 5.5vw, 4.6rem);
            font-weight: 400;
            line-height: 1.08;
            color: var(--ink);
            margin-bottom: 1.2rem;
        }
        .hero-text h1 em {
            color: var(--accent);
            font-style: italic;
        }
        .hero-text p {
            color: var(--ink-2);
            font-size: 1.05rem;
            font-weight: 300;
            line-height: 1.75;
            margin-bottom: 2.2rem;
            max-width: 420px;
        }
        .hero-cta { display: flex; gap: .85rem; flex-wrap: wrap; margin-bottom: 3rem; }

        .hero-stats {
            display: flex;
            gap: 2.2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
        }
        .stat-num {
            display: block;
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--accent);
            line-height: 1;
        }
        .stat-label {
            display: block;
            font-size: .72rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--ink-3);
            margin-top: .3rem;
        }

        /* Hero visual */
        .hero-visual {
            position: relative;
        }
        .hero-img-wrap {
            aspect-ratio: 3/4;
            border-radius: var(--r-lg);
            overflow: hidden;
            background: linear-gradient(160deg, #ecdec8 0%, #d9c8a8 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .hero-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
        .hero-img-icon {
            font-size: 5rem;
            opacity: .18;
            font-family: 'Cormorant Garamond', serif;
        }
        .hero-float-badge {
            position: absolute;
            bottom: -1.2rem;
            left: -1.5rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            padding: .9rem 1.2rem;
            display: flex;
            align-items: center;
            gap: .8rem;
            box-shadow: 0 8px 28px rgba(0,0,0,.07);
        }
        .hero-float-badge .badge-icon {
            width: 42px; height: 42px;
            background: var(--accent-lt);
            border-radius: var(--r-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
        }
        .hero-float-badge .badge-label {
            font-size: .72rem; font-weight: 500;
            color: var(--ink-3); text-transform: uppercase; letter-spacing: .06em;
        }
        .hero-float-badge .badge-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem; font-weight: 600;
            color: var(--ink); line-height: 1;
        }
        .hero-float-tag {
            position: absolute;
            top: 1.5rem; right: -1.2rem;
            background: var(--accent);
            color: #fff;
            border-radius: 999px;
            padding: .45rem 1rem;
            font-size: .78rem;
            font-weight: 600;
        }

        /* ── SECTION WRAPPER ── */
        .section { max-width: 1180px; margin: 0 auto; padding: 3.5rem 2.5rem; }
        .section-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            padding-bottom: 1rem;
            margin-bottom: 1.8rem;
            border-bottom: 1px solid var(--border);
        }
        .section-head h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--ink);
        }
        .section-head a {
            font-size: .85rem;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }
        .section-head a:hover { text-decoration: underline; }

        /* ── ADMIN PANEL ── */
        .admin-panel {
            background: var(--ink);
            border-radius: var(--r-lg);
            padding: 2.5rem;
            color: #f9f6f1;
        }
        .admin-panel-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .admin-panel h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: .3rem;
        }
        .admin-panel p { color: rgba(249,246,241,.5); font-size: .88rem; }
        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 1px;
            background: rgba(255,255,255,.08);
            border-radius: var(--r-md);
            overflow: hidden;
            margin-bottom: 1.8rem;
        }
        .admin-stat {
            background: rgba(255,255,255,.04);
            padding: 1.2rem 1rem;
            text-align: center;
        }
        .admin-stat .num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--gold);
            line-height: 1;
        }
        .admin-stat .lbl {
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: rgba(249,246,241,.4);
            margin-top: .35rem;
        }
        .admin-actions { display: flex; gap: .75rem; flex-wrap: wrap; }
        .btn-admin-primary {
            background: var(--accent); color: #fff;
            border: 1.5px solid var(--accent);
            padding: .55rem 1.3rem; border-radius: 999px;
            font-size: .85rem; font-weight: 500;
            text-decoration: none; cursor: pointer;
            transition: all .18s;
            display: inline-flex; align-items: center;
        }
        .btn-admin-primary:hover { background: #9e3a12; }
        .btn-admin-ghost {
            background: rgba(255,255,255,.1); color: rgba(249,246,241,.85);
            border: 1.5px solid rgba(255,255,255,.15);
            padding: .55rem 1.3rem; border-radius: 999px;
            font-size: .85rem; font-weight: 500;
            text-decoration: none; cursor: pointer;
            transition: all .18s;
            display: inline-flex; align-items: center;
        }
        .btn-admin-ghost:hover { background: rgba(255,255,255,.18); }

        /* ── USER WELCOME ── */
        .user-welcome {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: 2rem 2.5rem;
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        .user-avatar {
            flex-shrink: 0;
            width: 60px; height: 60px;
            border-radius: 50%;
            background: var(--accent-lt);
            border: 2px solid var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--accent);
        }
        .user-welcome-text h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 600;
        }
        .user-welcome-text p {
            color: var(--ink-3);
            font-size: .88rem;
            margin-top: .15rem;
        }
        .user-quick-stats {
            display: flex;
            gap: 1.8rem;
            margin-top: .8rem;
            padding-top: .8rem;
            border-top: 1px solid var(--border);
        }
        .u-stat .num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--accent);
            line-height: 1;
        }
        .u-stat .lbl {
            font-size: .7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--ink-3);
            margin-top: .25rem;
        }
        .user-welcome-actions { margin-left: auto; display: flex; gap: .6rem; flex-wrap: wrap; align-self: flex-start; }

        /* ── CATEGORY CHIPS ── */
        .chips { display: flex; flex-wrap: wrap; gap: .55rem; }
        .chip {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .45rem 1.1rem;
            text-decoration: none;
            color: var(--ink-2);
            font-size: .85rem;
            font-weight: 500;
            transition: all .18s;
        }
        .chip:hover { background: var(--accent); color: #fff; border-color: var(--accent); }
        .chip-count {
            background: var(--bg);
            border-radius: 999px;
            padding: .1rem .5rem;
            font-size: .72rem;
            color: var(--ink-3);
            transition: all .18s;
        }
        .chip:hover .chip-count { background: rgba(255,255,255,.22); color: rgba(255,255,255,.85); }

        /* ── RECIPE GRID ── */
        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.4rem;
        }
        .recipe-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            transition: transform .2s, box-shadow .2s;
            display: flex;
            flex-direction: column;
        }
        .recipe-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0,0,0,.08);
        }
        .recipe-card-img {
            aspect-ratio: 16/10;
            background: linear-gradient(135deg, #ecdec8, #d9c0a0);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.8rem;
            overflow: hidden;
            position: relative;
        }
        .recipe-card-img img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .3s;
        }
        .recipe-card:hover .recipe-card-img img { transform: scale(1.04); }
        .cat-badge {
            position: absolute;
            top: .65rem; left: .65rem;
            background: var(--accent);
            color: #fff;
            font-size: .66rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: .22rem .65rem;
            border-radius: 999px;
        }
        .recipe-card-body {
            padding: 1rem 1.15rem 1.15rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .recipe-card-body h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.3;
            color: var(--ink);
            margin-bottom: .5rem;
        }
        .recipe-meta {
            display: flex;
            gap: .8rem;
            font-size: .75rem;
            color: var(--ink-3);
            margin-top: auto;
            padding-top: .75rem;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }
        .recipe-meta span { display: flex; align-items: center; gap: .25rem; }
        .stars { color: var(--gold); }

        /* ── TAG CLOUD ── */
        .tags-cloud { display: flex; flex-wrap: wrap; gap: .5rem; }
        .tag-pill {
            text-decoration: none;
            color: var(--ink-3);
            font-size: .8rem;
            font-weight: 500;
            padding: .32rem .85rem;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: var(--surface);
            transition: all .18s;
        }
        .tag-pill:hover {
            background: var(--gold);
            color: var(--ink);
            border-color: var(--gold);
        }

        /* ── GUEST CTA ── */
        .guest-cta {
            background: var(--accent);
            border-radius: var(--r-lg);
            padding: 4rem 3rem;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .guest-cta::before {
            content: 'Saveur';
            position: absolute;
            font-family: 'Cormorant Garamond', serif;
            font-size: 14rem;
            font-weight: 600;
            color: rgba(255,255,255,.06);
            bottom: -2rem;
            right: -1rem;
            pointer-events: none;
            line-height: 1;
        }
        .guest-cta h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 400;
            font-style: italic;
            margin-bottom: .8rem;
        }
        .guest-cta p {
            opacity: .82;
            font-size: .95rem;
            max-width: 460px;
            margin: 0 auto 2rem;
            line-height: 1.7;
        }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid var(--border);
            text-align: center;
            padding: 2rem;
            color: var(--ink-3);
            font-size: .82rem;
        }
        footer a { color: var(--accent); text-decoration: none; }

        /* ── RESPONSIVE ── */
        @media (max-width: 800px) {
            nav { padding: 0 1.25rem; }
            .hero { grid-template-columns: 1fr; gap: 2rem; padding: 3rem 1.25rem 2rem; }
            .hero-visual { display: none; }
            .hero-text h1 { font-size: 2.6rem; }
            .hero-stats { gap: 1.4rem; flex-wrap: wrap; }
            .section { padding: 2rem 1.25rem; }
            .user-welcome { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .user-welcome-actions { margin-left: 0; }
            .admin-panel { padding: 1.5rem; }
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
            <a href="{{ route('recipes.create') }}" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> New Recipe</a>
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

{{-- ══ ADMIN PANEL ══ --}}
@auth
@if(Auth::user()->role === 'admin')
<div class="section" style="padding-bottom:0">
    <div class="admin-panel">
        <div class="admin-panel-top">
            <div>
                <h3>Admin Dashboard</h3>
                <p>Live platform overview</p>
            </div>
            <div class="admin-actions">
                <a href="{{ route('admin.recipes') }}" class="btn-admin-primary">Manage recipes</a>
                <a href="{{ route('admin.users') }}" class="btn-admin-ghost">Manage users</a>
            </div>
        </div>
        <div class="admin-stats-grid">
            <div class="admin-stat">
                <div class="num">{{ $stats['total_recipes'] }}</div>
                <div class="lbl">Recipes</div>
            </div>
            <div class="admin-stat">
                <div class="num">{{ $stats['pending_recipes'] }}</div>
                <div class="lbl">Pending</div>
            </div>
            <div class="admin-stat">
                <div class="num">{{ $stats['total_users'] }}</div>
                <div class="lbl">Users</div>
            </div>
            <div class="admin-stat">
                <div class="num">{{ $stats['total_ratings'] }}</div>
                <div class="lbl">Ratings</div>
            </div>
            <div class="admin-stat">
                <div class="num">{{ $stats['total_categories'] }}</div>
                <div class="lbl">Categories</div>
            </div>
            <div class="admin-stat">
                <div class="num">{{ $stats['total_tags'] }}</div>
                <div class="lbl">Tags</div>
            </div>
        </div>
    </div>
</div>
@endif
@endauth

{{-- ══ GUEST HERO ══ --}}
@guest
<div class="hero">
    <div class="hero-text">
        <div class="hero-eyebrow">{{ $stats['total_recipes'] }}+ recipes live</div>
        <h1>Recipes you'll <em>love</em> to make again.</h1>
        <p>Discover home-cooked recipes shared by real cooks — from quick weeknight dinners to long weekend feasts.</p>
        <div class="hero-cta">
            <a href="{{ route('signup') }}" class="btn btn-primary">Start cooking →</a>
            <a href="{{ route('recipes.index') }}" class="btn btn-ghost">Browse recipes</a>
        </div>
        <div class="hero-stats">
            <div>
                <span class="stat-num">{{ $stats['total_recipes'] }}</span>
                <span class="stat-label">Recipes</span>
            </div>
            <div>
                <span class="stat-num">{{ $stats['total_users'] }}</span>
                <span class="stat-label">Cooks</span>
            </div>
            <div>
                <span class="stat-num">{{ $stats['total_ratings'] }}</span>
                <span class="stat-label">Reviews</span>
            </div>
            <div>
                <span class="stat-num">{{ $stats['total_categories'] }}</span>
                <span class="stat-label">Categories</span>
            </div>
        </div>
    </div>
    <div class="hero-visual">
        <div class="hero-img-wrap">
            <div class="hero-img-icon"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="opacity:.35"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
        </div>
        <div class="hero-float-badge">
            <div class="badge-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#c8972a" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
            <div>
                <div class="badge-label">Top rated today</div>
                <div class="badge-val">4.9 / 5.0</div>
            </div>
        </div>
        <div class="hero-float-tag"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg> Trending now</div>
    </div>
</div>
@endguest

{{-- ══ USER WELCOME ══ --}}
@auth
@if(Auth::user()->role !== 'admin')
<div class="section" style="padding-bottom:0">
    <div class="user-welcome">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="user-welcome-text">
            <h3>Welcome back, {{ Auth::user()->name }}</h3>
            <p>Ready to cook something new?</p>
            <div class="user-quick-stats">
                <div class="u-stat">
                    <div class="num">{{ $userStats['my_recipes_count'] ?? 0 }}</div>
                    <div class="lbl">My Recipes</div>
                </div>
                <div class="u-stat">
                    <div class="num">{{ $userStats['my_favorites_count'] ?? 0 }}</div>
                    <div class="lbl">Favorites</div>
                </div>
            </div>
        </div>
        <div class="user-welcome-actions">
            <a href="{{ route('recipes.create') }}" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> New Recipe</a>
            <a href="{{ route('recipes.my') }}" class="btn btn-ghost">My Recipes</a>
        </div>
    </div>
</div>
@endif
@endauth

{{-- ══ CATEGORIES ══ --}}
@if($categories->isNotEmpty())
<div class="section">
    <div class="section-head">
        <h2>Browse by category</h2>
    </div>
    <div class="chips">
        @foreach($categories as $cat)
        <a href="{{ route('recipes.by-category', $cat->id) }}" class="chip">
            {{ $cat->name }}
            <span class="chip-count">{{ $cat->recipes_count }}</span>
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- ══ POPULAR RECIPES ══ --}}
@if($popularRecipes->isNotEmpty())
<div class="section">
    <div class="section-head">
        <h2>Most popular</h2>
        <a href="{{ route('recipes.index') }}">View all →</a>
    </div>
    <div class="recipe-grid">
        @foreach($popularRecipes as $recipe)
        <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card">
            <div class="recipe-card-img">
                @if($recipe->image)
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" />
                @else
                    <div style="opacity:.25"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="opacity:.35"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                @endif
                @if($recipe->category)
                    <span class="cat-badge">{{ $recipe->category->name }}</span>
                @endif
            </div>
            <div class="recipe-card-body">
                <h3>{{ $recipe->title }}</h3>
                <div class="recipe-meta">
                    @if($recipe->average_rating)
                        <span class="stars">
                            @for($i=1;$i<=5;$i++){{ $i <= round($recipe->average_rating) ? '●' : '○' }}@endfor
                        </span>
                        <span>{{ number_format($recipe->average_rating, 1) }}</span>
                    @endif
                    @if($recipe->cook_time)
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ $recipe->cook_time }} min</span>
                    @endif
                    @if($recipe->servings)
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="opacity:.35"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg> {{ $recipe->servings }}</span>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- ══ RECENT RECIPES ══ --}}
@if($recentRecipes->isNotEmpty())
<div class="section">
    <div class="section-head">
        <h2>Just added</h2>
        <a href="{{ route('recipes.index') }}">View all →</a>
    </div>
    <div class="recipe-grid">
        @foreach($recentRecipes as $recipe)
        <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card">
            <div class="recipe-card-img">
                @if($recipe->image)
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" />
                @else
                    <div style="opacity:.25"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="opacity:.35"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                @endif
                @if($recipe->category)
                    <span class="cat-badge">{{ $recipe->category->name }}</span>
                @endif
            </div>
            <div class="recipe-card-body">
                <h3>{{ $recipe->title }}</h3>
                <div class="recipe-meta">
                    @if($recipe->average_rating)
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#c8972a" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg> {{ number_format($recipe->average_rating, 1) }}</span>
                    @endif
                    @if($recipe->cook_time)
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ $recipe->cook_time }} min</span>
                    @endif
                    <span>{{ $recipe->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- ══ USER FAVORITES ══ --}}
@auth
@if(Auth::user()->role !== 'admin' && $userFavorites->isNotEmpty())
<div class="section">
    <div class="section-head">
        <h2>Your favorites</h2>
        <a href="{{ route('recipes.favorites') }}">See all →</a>
    </div>
    <div class="recipe-grid">
        @foreach($userFavorites as $recipe)
        <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card">
            <div class="recipe-card-img">
                @if($recipe->image)
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" />
                @else
                    <div style="opacity:.25"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div>
                @endif
                @if($recipe->category)
                    <span class="cat-badge">{{ $recipe->category->name }}</span>
                @endif
            </div>
            <div class="recipe-card-body">
                <h3>{{ $recipe->title }}</h3>
                <div class="recipe-meta">
                    @if($recipe->cook_time) <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ $recipe->cook_time }} min</span> @endif
                    @if($recipe->servings)  <span><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" style="opacity:.35"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg> {{ $recipe->servings }}</span> @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif
@endauth

{{-- ══ TAG CLOUD ══ --}}
@if($tags->isNotEmpty())
<div class="section">
    <div class="section-head">
        <h2>Explore tags</h2>
    </div>
    <div class="tags-cloud">
        @foreach($tags as $tag)
        <a href="{{ route('recipes.by-tag', $tag->id) }}" class="tag-pill">
            #{{ $tag->name }} <small style="opacity:.55">({{ $tag->recipes_count }})</small>
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- ══ GUEST CTA ══ --}}
@guest
<div class="section">
    <div class="guest-cta">
        <h2>Ready to share your recipes?</h2>
        <p>Join thousands of home cooks already publishing on Saveur. Free, forever.</p>
        <a href="{{ route('signup') }}" class="btn btn-white">Create a free account →</a>
    </div>
</div>
@endguest

<footer>
    <p>© {{ date('Y') }} <a href="{{ route('home') }}">Saveur</a> — made for home cooks everywhere.</p>
</footer>

</body>
</html>

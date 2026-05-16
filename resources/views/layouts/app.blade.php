{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Cuisto') — Cuisto</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #f8f5f0;
            --surface:   #ffffff;
            --ink:       #1a1510;
            --ink-2:     #4a4030;
            --ink-3:     #8c8070;
            --accent:    #b84a1c;
            --accent-dk: #9e3a12;
            --accent-lt: #f5ede7;
            --sage:      #3d5c36;
            --sage-lt:   #eaf2e8;
            --danger:    #c0392b;
            --danger-lt: #fdf0ef;
            --gold:      #c8972a;
            --border:    #e6ddd0;
            --border-lt: #f0e8dc;
            --r-sm: 6px; --r-md: 12px; --r-lg: 20px; --r-xl: 28px;
            --shadow-xs: 0 1px 3px rgba(26,21,16,.06);
            --shadow-sm: 0 2px 8px rgba(26,21,16,.08);
            --shadow-md: 0 8px 28px rgba(26,21,16,.10);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            font-size: 15px;
            line-height: 1.65;
        }

        /* Flash */
        .flash       { background: var(--sage); color: #fff; text-align: center; padding: .65rem 1.5rem; font-size: .82rem; font-weight: 500; letter-spacing: .03em; }
        .flash-error { background: var(--danger); }

        /* Navigation */
        nav {
            position: sticky; top: 0; z-index: 200;
            background: rgba(248,245,240,.94);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2.5rem; height: 66px;
        }
        .nav-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem; font-weight: 600;
            color: var(--accent); text-decoration: none;
            letter-spacing: -.015em; transition: opacity .2s;
        }
        .nav-brand:hover { opacity: .8; }

        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-links a {
            text-decoration: none; color: var(--ink-2);
            font-size: .875rem; font-weight: 500; letter-spacing: .01em;
            transition: color .18s; position: relative;
        }
        .nav-links a::after {
            content: ''; position: absolute; bottom: -3px; left: 0; right: 0;
            height: 1.5px; background: var(--accent);
            transform: scaleX(0); transform-origin: left;
            transition: transform .22s ease;
        }
        .nav-links a:hover { color: var(--accent); }
        .nav-links a:hover::after, .nav-links a.active::after { transform: scaleX(1); }
        .nav-links a.active { color: var(--accent); }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: .4rem;
            text-decoration: none; white-space: nowrap;
            padding: .5rem 1.35rem; border-radius: 999px;
            font-family: 'DM Sans', sans-serif;
            font-size: .85rem; font-weight: 500;
            cursor: pointer; border: 1.5px solid transparent;
            transition: all .18s ease; letter-spacing: .01em;
        }
        .btn-primary { background: var(--accent); color: #fff; border-color: var(--accent); box-shadow: 0 2px 12px rgba(184,74,28,.22); }
        .btn-primary:hover { background: var(--accent-dk); box-shadow: 0 4px 18px rgba(184,74,28,.30); transform: translateY(-1px); }
        .btn-outline { background: transparent; color: var(--accent); border-color: var(--accent); }
        .btn-outline:hover { background: var(--accent); color: #fff; }
        .btn-ghost   { background: var(--surface); color: var(--ink-2); border-color: var(--border); }
        .btn-ghost:hover { border-color: var(--ink-3); color: var(--ink); }
        .btn-danger  { background: transparent; color: var(--danger); border-color: var(--danger); }
        .btn-danger:hover { background: var(--danger); color: #fff; }
        .btn-sm { font-size: .78rem; padding: .38rem 1rem; }

        /* Alerts */
        .alert { border-radius: var(--r-md); padding: .9rem 1.2rem; font-size: .85rem; margin-bottom: 1.25rem; border: 1px solid; line-height: 1.55; }
        .alert-success { background: var(--sage-lt); color: var(--sage); border-color: #c3dbbf; }
        .alert-error   { background: var(--danger-lt); color: var(--danger); border-color: #f5b8b0; }

        /* Form elements */
        .form-label { display: block; font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .09em; color: var(--ink-3); margin-bottom: .45rem; }
        .form-input, .form-select, .form-textarea {
            width: 100%; font-family: 'DM Sans', sans-serif; font-size: .88rem;
            color: var(--ink); background: #fff;
            border: 1.5px solid var(--border); border-radius: var(--r-md);
            padding: .72rem 1rem; outline: none;
            transition: border-color .18s, box-shadow .18s, background .18s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(184,74,28,.09); background: var(--surface);
        }
        .form-input::placeholder, .form-textarea::placeholder { color: #c0b4a4; font-weight: 300; }
        .form-textarea { resize: vertical; min-height: 90px; line-height: 1.65; }
        .form-select {
            appearance: none; cursor: pointer; padding-right: 2.5rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239a8e7e' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right .9rem center;
        }

        /* Cards */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); box-shadow: var(--shadow-xs); }
        .card-body { padding: 2rem; }

        /* Layout */
        .page-wrap    { max-width: 1180px; margin: 0 auto; padding: 3rem 2.5rem 5rem; }
        .page-wrap-sm { max-width: 580px;  margin: 0 auto; padding: 4rem 1.5rem 6rem; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        .data-table thead th { background: #faf7f2; border-bottom: 1px solid var(--border); padding: .9rem 1.3rem; text-align: left; font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .09em; color: var(--ink-3); }
        .data-table tbody td { padding: 1rem 1.3rem; border-bottom: 1px solid var(--border-lt); vertical-align: middle; color: var(--ink-2); }
        .data-table tbody tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover td { background: #fdfaf5; }

        /* Badge */
        .badge { display: inline-flex; align-items: center; padding: .2rem .7rem; border-radius: 999px; font-size: .68rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; }
        .badge-accent { background: var(--accent-lt); color: var(--accent); }
        .badge-sage   { background: var(--sage-lt); color: var(--sage); }
        .badge-muted  { background: #f0ece6; color: var(--ink-3); }

        .divider { border: none; border-top: 1px solid var(--border); margin: 1.5rem 0; }

        /* Footer */
        footer { border-top: 1px solid var(--border); padding: 2.25rem 2.5rem; text-align: center; font-size: .8rem; color: var(--ink-3); background: var(--surface); }
        footer a { color: var(--accent); text-decoration: none; font-weight: 500; }
        footer a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            nav { padding: 0 1.25rem; }
            .page-wrap { padding: 2rem 1.25rem 4rem; }
            .nav-links .hide-mobile { display: none; }
        }
    </style>
    @yield('styles')
</head>
<body>

@if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
@if(session('error'))<div class="flash flash-error">{{ session('error') }}</div>@endif

<nav>
    <a href="{{ route('home') }}" class="nav-brand">Cuisto</a>
    <div class="nav-links">
        <a href="{{ route('recipes.index') }}" class="hide-mobile">Recettes</a>
        @auth
            <a href="{{ route('recipes.my') }}" class="hide-mobile">Mes recettes</a>
            <a href="{{ route('recipes.favorites') }}" class="hide-mobile">Favoris</a>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary btn-sm">Nouvelle recette</a>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">Admin</a>
            @endif
            <a href="{{ route('profile.edit') }}" style="font-size:.875rem;color:var(--ink-2);text-decoration:none;font-weight:500">{{ Auth::user()->name }}</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm">Déconnexion</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Connexion</a>
            <a href="{{ route('signup') }}" class="btn btn-primary btn-sm">S'inscrire</a>
        @endauth
    </div>
</nav>

@yield('content')

<footer>
    <p>&copy; {{ date('Y') }} <a href="{{ route('home') }}">Cuisto</a> &mdash; La cuisine, simplement.</p>
</footer>

@yield('scripts')
</body>
</html>

{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Saveur') — Saveur</title>
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
            --accent-dk: #9e3a12;
            --accent-lt: #f5ede7;
            --sage:      #3d5c36;
            --sage-lt:   #eaf2e8;
            --danger:    #c0392b;
            --danger-lt: #fdf0ef;
            --gold:      #c8972a;
            --border:    #e8e0d4;
            --r-sm: 8px; --r-md: 14px; --r-lg: 22px;
            --shadow-sm: 0 1px 4px rgba(24,20,14,.07);
            --shadow-md: 0 4px 20px rgba(24,20,14,.09);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* Flash */
        .flash       { background: var(--sage); color: #fff; text-align: center; padding: .6rem 1rem; font-size: .85rem; letter-spacing: .02em; }
        .flash-error { background: var(--danger); }

        /* Nav */
        nav {
            position: sticky; top: 0; z-index: 200;
            background: rgba(249,246,241,.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2.5rem; height: 68px;
        }
        .nav-brand { font-family: 'Cormorant Garamond', serif; font-size: 1.9rem; font-weight: 600; color: var(--accent); text-decoration: none; letter-spacing: -.01em; }
        .nav-links  { display: flex; align-items: center; gap: 1.8rem; }
        .nav-links a { text-decoration: none; color: var(--ink-2); font-size: .9rem; font-weight: 500; transition: color .2s; }
        .nav-links a:hover, .nav-links a.active { color: var(--accent); }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: .4rem; text-decoration: none; padding: .52rem 1.3rem; border-radius: 999px; font-family: 'Outfit', sans-serif; font-size: .85rem; font-weight: 500; cursor: pointer; border: 1.5px solid transparent; transition: all .18s; white-space: nowrap; }
        .btn-primary { background: var(--accent); color: #fff; border-color: var(--accent); }
        .btn-primary:hover { background: var(--accent-dk); }
        .btn-outline { background: transparent; color: var(--accent); border-color: var(--accent); }
        .btn-outline:hover { background: var(--accent); color: #fff; }
        .btn-ghost   { background: var(--surface); color: var(--ink-2); border-color: var(--border); }
        .btn-ghost:hover { border-color: var(--ink-3); color: var(--ink); }
        .btn-danger  { background: transparent; color: var(--danger); border-color: var(--danger); }
        .btn-danger:hover { background: var(--danger); color: #fff; }
        .btn-sm { font-size: .78rem; padding: .38rem .95rem; }

        /* Alert boxes */
        .alert { border-radius: var(--r-md); padding: .85rem 1.1rem; font-size: .85rem; margin-bottom: 1.25rem; border: 1px solid; }
        .alert-success { background: var(--sage-lt); color: var(--sage); border-color: #c3dbbf; }
        .alert-error   { background: var(--danger-lt); color: var(--danger); border-color: #f5b8b0; }

        /* Form elements */
        .form-label { display: block; font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; color: var(--ink-3); margin-bottom: .4rem; }
        .form-input, .form-select, .form-textarea {
            width: 100%; font-family: 'Outfit', sans-serif; font-size: .9rem;
            color: var(--ink); background: var(--bg);
            border: 1.5px solid var(--border); border-radius: var(--r-md);
            padding: .7rem 1rem; outline: none;
            transition: border-color .18s, box-shadow .18s, background .18s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(184,74,28,.1); background: var(--surface);
        }
        .form-input::placeholder, .form-textarea::placeholder { color: #c5b8a8; }
        .form-textarea { resize: vertical; min-height: 90px; line-height: 1.6; }
        .form-select { appearance: none; cursor: pointer; padding-right: 2.4rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239a8e7e' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right .8rem center; }

        /* Card */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); box-shadow: var(--shadow-sm); }
        .card-body { padding: 2rem; }

        /* Page wrapper */
        .page-wrap { max-width: 1180px; margin: 0 auto; padding: 3rem 2.5rem 5rem; }
        .page-wrap-sm { max-width: 560px; margin: 0 auto; padding: 4rem 1.5rem 6rem; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; font-size: .88rem; }
        .data-table thead th { background: #faf7f3; border-bottom: 1px solid var(--border); padding: .85rem 1.25rem; text-align: left; font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--ink-3); }
        .data-table tbody td { padding: 1rem 1.25rem; border-bottom: 1px solid #f3ede4; vertical-align: middle; color: var(--ink-2); }
        .data-table tbody tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover td { background: #fdfaf6; }

        /* Badge */
        .badge { display: inline-flex; align-items: center; padding: .22rem .7rem; border-radius: 999px; font-size: .7rem; font-weight: 600; letter-spacing: .04em; }
        .badge-accent { background: var(--accent-lt); color: var(--accent); }
        .badge-sage   { background: var(--sage-lt); color: var(--sage); }
        .badge-muted  { background: #f0ece6; color: var(--ink-3); }

        /* Divider */
        .divider { border: none; border-top: 1px solid var(--border); margin: 1.5rem 0; }

        /* Footer */
        footer { border-top: 1px solid var(--border); padding: 2rem 2.5rem; text-align: center; font-size: .82rem; color: var(--ink-3); }
        footer a { color: var(--accent); text-decoration: none; }

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
    <a href="{{ route('home') }}" class="nav-brand">Saveur</a>
    <div class="nav-links">
        <a href="{{ route('recipes.index') }}" class="hide-mobile">Recettes</a>
        @auth
            <a href="{{ route('recipes.my') }}" class="hide-mobile">Mes recettes</a>
            <a href="{{ route('recipes.favorites') }}" class="hide-mobile">Favoris</a>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary">+ Nouvelle</a>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">Admin</a>
            @endif
            <a href="{{ route('profile.edit') }}" style="font-size:.88rem;color:var(--ink-2);text-decoration:none;font-weight:500">{{ Auth::user()->name }}</a>
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
    <p>&copy; {{ date('Y') }} <a href="{{ route('home') }}">Saveur</a> &mdash; La cuisine, simplement.</p>
</footer>

@yield('scripts')
</body>
</html>

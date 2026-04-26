<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In — Saveur</title>
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            -webkit-font-smoothing: antialiased;
        }

        /* ── LEFT PANEL ── */
        .panel-left {
            background: linear-gradient(160deg, #2a1a0e 0%, #3d2412 40%, #1e1008 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .panel-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            letter-spacing: -0.5px;
            position: relative;
        }
        .panel-brand span { color: #e07e50; }
        .panel-body {
            position: relative;
        }
        .panel-body h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 400;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 1rem;
        }
        .panel-body h2 em { color: #e07e50; font-style: italic; }
        .panel-body p {
            color: rgba(255,255,255,0.5);
            font-size: .95rem;
            font-weight: 300;
            line-height: 1.7;
            max-width: 340px;
        }
        .panel-features {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: .85rem;
        }
        .panel-feature {
            display: flex;
            align-items: center;
            gap: .85rem;
            color: rgba(255,255,255,.7);
            font-size: .88rem;
        }
        .panel-feature-dot {
            width: 28px; height: 28px;
            background: rgba(224,126,80,.2);
            border: 1px solid rgba(224,126,80,.4);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            color: #e07e50;
        }
        .panel-feature-dot svg { width: 13px; height: 13px; }

        /* ── RIGHT PANEL ── */
        .panel-right {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
        }
        .auth-box {
            width: 100%;
            max-width: 400px;
        }
        .auth-box-head {
            margin-bottom: 2.5rem;
        }
        .auth-box-head h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.1;
            margin-bottom: .4rem;
        }
        .auth-box-head p {
            color: var(--ink-3);
            font-size: .9rem;
            font-weight: 300;
        }
        .auth-box-head p a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        /* Alert */
        .alert {
            border-radius: var(--r-sm);
            padding: .85rem 1rem;
            font-size: .85rem;
            margin-bottom: 1.4rem;
            display: flex;
            align-items: flex-start;
            gap: .6rem;
        }
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .alert svg { flex-shrink: 0; margin-top: 1px; }

        /* Form */
        .form-group { margin-bottom: 1.25rem; }
        .form-group label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--ink-3);
            margin-bottom: .5rem;
        }
        .form-input {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            padding: .75rem 1rem;
            font-family: 'Outfit', sans-serif;
            font-size: .95rem;
            color: var(--ink);
            background: var(--surface);
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }
        .form-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(184,74,28,.1);
        }
        .form-input.is-error { border-color: #f87171; }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.8rem;
        }
        .form-check {
            display: flex;
            align-items: center;
            gap: .45rem;
            font-size: .85rem;
            color: var(--ink-2);
            cursor: pointer;
        }
        .form-check input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--accent);
        }
        .form-link {
            font-size: .85rem;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }
        .form-link:hover { text-decoration: underline; }

        .btn-submit {
            width: 100%;
            padding: .85rem;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: var(--r-sm);
            font-family: 'Outfit', sans-serif;
            font-size: .95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .18s, transform .1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .btn-submit:hover { background: #9e3a12; }
        .btn-submit:active { transform: scale(.99); }
        .btn-submit svg { width: 16px; height: 16px; }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.8rem 0;
            color: var(--ink-3);
            font-size: .8rem;
        }
        .auth-divider::before, .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .btn-signup {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            width: 100%;
            padding: .8rem;
            background: transparent;
            color: var(--ink-2);
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            font-family: 'Outfit', sans-serif;
            font-size: .9rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: border-color .18s, color .18s;
        }
        .btn-signup:hover { border-color: var(--accent); color: var(--accent); }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .panel-left { display: none; }
            .panel-right { padding: 2rem 1.5rem; min-height: 100vh; }
        }
    </style>
</head>
<body>

{{-- ── LEFT PANEL ── --}}
<div class="panel-left">
    <a href="{{ route('home') }}" class="panel-brand">Sa<span>veur</span></a>

    <div class="panel-body">
        <h2>Recipes worth <em>making</em> — and sharing.</h2>
        <p>Thousands of home cooks share their best dishes every day. Your next favourite meal is waiting.</p>
    </div>

    <div class="panel-features">
        <div class="panel-feature">
            <div class="panel-feature-dot">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Save and organise your favourite recipes
        </div>
        <div class="panel-feature">
            <div class="panel-feature-dot">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Publish your own creations instantly
        </div>
        <div class="panel-feature">
            <div class="panel-feature-dot">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Rate, review, and discover new dishes
        </div>
    </div>
</div>

{{-- ── RIGHT PANEL ── --}}
<div class="panel-right">
    <div class="auth-box">
        <div class="auth-box-head">
            <h1>Welcome back</h1>
            <p>Don't have an account? <a href="{{ route('signup') }}">Create one free</a></p>
        </div>

        @if(session('error'))
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>@foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
        </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" class="form-input @error('email') is-error @enderror"
                       value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input @error('password') is-error @enderror"
                       placeholder="••••••••" autocomplete="current-password" required>
            </div>

            <div class="form-options">
                <label class="form-check">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
                <a href="#" class="form-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-submit">
                Sign in
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>
        </form>

        <div class="auth-divider">or</div>

        <a href="{{ route('signup') }}" class="btn-signup">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            Create a free account
        </a>
    </div>
</div>

</body>
</html>

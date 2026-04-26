<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account — Saveur</title>
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
            background: linear-gradient(160deg, #1e2e1a 0%, #2d4228 40%, #0f1a0d 100%);
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
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .panel-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            position: relative;
        }
        .panel-brand span { color: #7abf6a; }
        .panel-body { position: relative; }
        .panel-body h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 400;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 1rem;
        }
        .panel-body h2 em { color: #7abf6a; font-style: italic; }
        .panel-body p {
            color: rgba(255,255,255,.5);
            font-size: .95rem;
            font-weight: 300;
            line-height: 1.7;
            max-width: 340px;
        }
        .panel-quote {
            position: relative;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: var(--r-md);
            padding: 1.5rem;
        }
        .panel-quote blockquote {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem;
            font-style: italic;
            color: rgba(255,255,255,.8);
            line-height: 1.6;
            margin-bottom: .75rem;
        }
        .panel-quote cite {
            font-size: .78rem;
            color: rgba(255,255,255,.4);
            font-style: normal;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        /* ── RIGHT PANEL ── */
        .panel-right {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            overflow-y: auto;
        }
        .auth-box {
            width: 100%;
            max-width: 420px;
        }
        .auth-box-head {
            margin-bottom: 2rem;
        }
        .auth-box-head h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--ink);
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
        .alert ul { padding-left: 1rem; }
        .alert li { margin-top: .2rem; }

        .form-row { display: grid; gap: 1rem; grid-template-columns: 1fr 1fr; }
        .form-group { margin-bottom: 1.1rem; }
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

        .password-strength {
            margin-top: .45rem;
            display: flex;
            gap: .25rem;
        }
        .strength-bar {
            height: 3px;
            flex: 1;
            background: var(--border);
            border-radius: 2px;
            transition: background .3s;
        }

        .form-hint {
            font-size: .75rem;
            color: var(--ink-3);
            margin-top: .35rem;
        }

        .terms-check {
            display: flex;
            align-items: flex-start;
            gap: .6rem;
            font-size: .85rem;
            color: var(--ink-2);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }
        .terms-check input[type="checkbox"] {
            width: 15px; height: 15px;
            margin-top: 2px;
            accent-color: var(--accent);
            flex-shrink: 0;
        }
        .terms-check a { color: var(--accent); text-decoration: none; font-weight: 500; }

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
            transition: background .18s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .btn-submit:hover { background: #9e3a12; }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
            color: var(--ink-3);
            font-size: .8rem;
        }
        .auth-divider::before, .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .btn-login {
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
            transition: border-color .18s, color .18s;
        }
        .btn-login:hover { border-color: var(--accent); color: var(--accent); }

        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .panel-left { display: none; }
            .panel-right { padding: 2rem 1.5rem; min-height: 100vh; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- ── LEFT PANEL ── --}}
<div class="panel-left">
    <a href="{{ route('home') }}" class="panel-brand">Sa<span>veur</span></a>

    <div class="panel-body">
        <h2>Your kitchen, your <em>stories</em>.</h2>
        <p>Join a community of passionate home cooks who share, rate, and discover the world's best recipes.</p>
    </div>

    <div class="panel-quote">
        <blockquote>"Cooking is the art of adjustment."</blockquote>
        <cite>Jacques Pépin</cite>
    </div>
</div>

{{-- ── RIGHT PANEL ── --}}
<div class="panel-right">
    <div class="auth-box">
        <div class="auth-box-head">
            <h1>Create your account</h1>
            <p>Already have one? <a href="{{ route('login') }}">Sign in instead</a></p>
        </div>

        @if ($errors->any())
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:2px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="/signup">
            @csrf

            <div class="form-group">
                <label for="name">Full name</label>
                <input type="text" id="name" name="name" class="form-input"
                       value="{{ old('name') }}" placeholder="Marie Dupont" autocomplete="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" class="form-input"
                       value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required>
            </div>

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input"
                           placeholder="Min. 8 characters" autocomplete="new-password" required
                           oninput="updateStrength(this.value)">
                    <div class="password-strength">
                        <div class="strength-bar" id="s1"></div>
                        <div class="strength-bar" id="s2"></div>
                        <div class="strength-bar" id="s3"></div>
                        <div class="strength-bar" id="s4"></div>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label for="password_confirmation">Confirm</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                           placeholder="Repeat password" autocomplete="new-password" required>
                </div>
            </div>
            <div class="form-hint" style="margin-bottom:1.1rem">Use at least 8 characters with a mix of letters and numbers.</div>

            <label class="terms-check">
                <input type="checkbox" required>
                I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
            </label>

            <button type="submit" class="btn-submit">
                Create account
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>
        </form>

        <div class="auth-divider">or</div>

        <a href="{{ route('login') }}" class="btn-login">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            Sign in to existing account
        </a>
    </div>
</div>

<script>
function updateStrength(val) {
    const bars = [document.getElementById('s1'), document.getElementById('s2'), document.getElementById('s3'), document.getElementById('s4')];
    const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    bars.forEach((b,i) => {
        b.style.background = i < score ? colors[score - 1] : 'var(--border)';
    });
}
</script>

</body>
</html>

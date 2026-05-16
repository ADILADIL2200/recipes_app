{{-- resources/views/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Connexion — Cuisto')

@section('styles')
<style>
.auth-page {
    min-height: calc(100vh - 66px);
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: #f8f5f0;
}
.auth-visual {
    position: relative;
    overflow: hidden;
    background: #18140e;
    display: none;
}
@media(min-width: 900px) {
    .auth-visual { display: block; }
    .auth-form-col { padding: 3rem 5rem; }
}
.auth-visual img {
    width: 100%; height: 100%;
    object-fit: cover; opacity: .5;
    transition: transform 12s ease;
}
.auth-visual:hover img { transform: scale(1.04); }
.auth-visual-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(150deg, rgba(184,74,28,.42) 0%, rgba(24,20,14,.78) 100%);
    display: flex; flex-direction: column;
    align-items: flex-start; justify-content: flex-end;
    padding: 3.5rem;
}
.auth-visual-line {
    width: 40px; height: 2px;
    background: rgba(255,255,255,.35);
    margin-bottom: 1.2rem;
}
.auth-visual-quote {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.1rem; font-weight: 400;
    color: #fff; line-height: 1.25;
    margin-bottom: 1.2rem;
    letter-spacing: -.01em;
}
.auth-visual-quote em { font-style: italic; color: rgba(255,255,255,.65); font-weight: 300; }
.auth-visual-attr {
    font-size: .72rem; color: rgba(255,255,255,.38);
    letter-spacing: .12em; text-transform: uppercase;
}

.auth-form-col {
    display: flex; align-items: center; justify-content: center;
    padding: 3rem 2rem;
    background: #f8f5f0;
}
.auth-box { width: 100%; max-width: 420px; }

.auth-logo {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.65rem; font-weight: 600;
    color: var(--accent); text-decoration: none;
    display: inline-block; margin-bottom: 2.75rem;
    letter-spacing: -.015em;
}
.auth-eyebrow {
    width: 32px; height: 2px;
    background: var(--accent); border-radius: 2px;
    margin-bottom: 1rem;
}
.auth-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.25rem; font-weight: 600;
    color: var(--ink); line-height: 1.1;
    margin-bottom: .45rem; letter-spacing: -.015em;
}
.auth-title em { font-style: italic; color: var(--accent); font-weight: 400; }
.auth-sub {
    font-size: .875rem; color: var(--ink-3);
    font-weight: 300; margin-bottom: 2.25rem;
    line-height: 1.6;
}

.auth-field { margin-bottom: 1.25rem; }
.auth-label {
    display: block; font-size: .68rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--ink-3); margin-bottom: .45rem;
}
.auth-input {
    width: 100%; padding: .78rem 1rem;
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: var(--r-md);
    font-family: 'DM Sans', sans-serif;
    font-size: .88rem; color: var(--ink); outline: none;
    transition: border-color .18s, box-shadow .18s;
}
.auth-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(184,74,28,.09);
}
.auth-input::placeholder { color: #c0b4a4; font-weight: 300; }

.auth-row {
    display: flex; align-items: center;
    justify-content: space-between;
    font-size: .82rem; margin-bottom: 1.75rem;
}
.auth-row label { display: flex; align-items: center; gap: .5rem; color: var(--ink-2); cursor: pointer; }
.auth-row input[type=checkbox] { width: 14px; height: 14px; accent-color: var(--accent); }
.auth-row a { color: var(--accent); text-decoration: none; font-size: .8rem; font-weight: 500; }
.auth-row a:hover { text-decoration: underline; }

.btn-auth {
    width: 100%; padding: .9rem;
    background: var(--accent); color: #fff;
    border: none; border-radius: var(--r-md);
    font-family: 'DM Sans', sans-serif;
    font-size: .9rem; font-weight: 600;
    cursor: pointer; letter-spacing: .01em;
    transition: background .18s, box-shadow .18s, transform .15s;
    box-shadow: 0 3px 16px rgba(184,74,28,.28);
}
.btn-auth:hover {
    background: var(--accent-dk);
    box-shadow: 0 5px 22px rgba(184,74,28,.36);
    transform: translateY(-1px);
}
.btn-auth:active { transform: translateY(0); }

.auth-footer {
    text-align: center; margin-top: 2rem;
    font-size: .84rem; color: var(--ink-3);
}
.auth-footer a { color: var(--accent); text-decoration: none; font-weight: 500; }
.auth-footer a:hover { text-decoration: underline; }
</style>
@endsection

@section('content')
<div class="auth-page">

    {{-- Colonne visuelle --}}
    <div class="auth-visual">
        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=900&q=80" alt="">
        <div class="auth-visual-overlay">
            <div class="auth-visual-line"></div>
            <div class="auth-visual-quote">La cuisine, c'est<br><em>l'art de transformer</em><br>le quotidien.</div>
            <div class="auth-visual-attr">Cuisto &mdash; Partagez votre passion</div>
        </div>
    </div>

    {{-- Colonne formulaire --}}
    <div class="auth-form-col">
        <div class="auth-box">

            <a href="{{ route('home') }}" class="auth-logo">Cuisto</a>

            <div class="auth-eyebrow"></div>
            <h1 class="auth-title">Bon <em>retour</em></h1>
            <p class="auth-sub">Connectez-vous à votre espace Cuisto</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="auth-field">
                    <label class="auth-label">Adresse e-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="auth-input" placeholder="vous@exemple.com">
                </div>

                <div class="auth-field">
                    <label class="auth-label">Mot de passe</label>
                    <input type="password" name="password" required
                           class="auth-input" placeholder="Votre mot de passe">
                </div>

                <div class="auth-row">
                    <label>
                        <input type="checkbox" name="remember">
                        Se souvenir de moi
                    </label>
                    <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-auth">Se connecter</button>
            </form>

            <div class="auth-footer">
                Pas encore de compte ? <a href="{{ route('signup') }}">Créer un compte</a>
            </div>

        </div>
    </div>
</div>
@endsection

{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.app')
@section('title', 'Mot de passe oublié — Cuisto')
@section('styles')
<style>
.auth-page { min-height:calc(100vh - 66px); display:grid; grid-template-columns:1fr 1fr; background:#f8f5f0; }
.auth-visual { position:relative; overflow:hidden; background:#18140e; display:none; }
@media(min-width:900px){ .auth-visual{display:block;} .auth-form-col{padding:3rem 5rem;} }
.auth-visual img { width:100%; height:100%; object-fit:cover; opacity:.42; transition:transform 12s ease; }
.auth-visual:hover img { transform:scale(1.04); }
.auth-visual-overlay { position:absolute; inset:0; background:linear-gradient(155deg,rgba(61,92,54,.45) 0%,rgba(24,20,14,.82) 100%); display:flex; flex-direction:column; justify-content:flex-end; padding:3.5rem; }
.auth-visual-line { width:40px; height:2px; background:rgba(255,255,255,.3); margin-bottom:1.2rem; }
.auth-visual-quote { font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:400; color:#fff; line-height:1.25; margin-bottom:1.2rem; letter-spacing:-.01em; }
.auth-visual-quote em { font-style:italic; color:rgba(255,255,255,.58); font-weight:300; }
.auth-visual-attr { font-size:.72rem; color:rgba(255,255,255,.32); letter-spacing:.12em; text-transform:uppercase; }
.auth-form-col { display:flex; align-items:center; justify-content:center; padding:3rem 2rem; background:#f8f5f0; }
.auth-box { width:100%; max-width:400px; }
.auth-logo { font-family:'Cormorant Garamond',serif; font-size:1.65rem; font-weight:600; color:var(--accent); text-decoration:none; display:inline-block; margin-bottom:2.75rem; letter-spacing:-.015em; }
.auth-eyebrow { width:32px; height:2px; background:var(--accent); border-radius:2px; margin-bottom:1rem; }
.auth-title { font-family:'Cormorant Garamond',serif; font-size:2.25rem; font-weight:600; color:var(--ink); line-height:1.1; margin-bottom:.45rem; letter-spacing:-.015em; }
.auth-title em { font-style:italic; color:var(--accent); font-weight:400; }
.auth-sub { font-size:.875rem; color:var(--ink-3); font-weight:300; line-height:1.75; margin-bottom:2.25rem; }
.auth-field { margin-bottom:1.5rem; }
.auth-label { display:block; font-size:.68rem; font-weight:600; text-transform:uppercase; letter-spacing:.1em; color:var(--ink-3); margin-bottom:.45rem; }
.auth-input { width:100%; padding:.78rem 1rem; background:#fff; border:1.5px solid var(--border); border-radius:var(--r-md); font-family:'DM Sans',sans-serif; font-size:.88rem; color:var(--ink); outline:none; transition:border-color .18s,box-shadow .18s; }
.auth-input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(184,74,28,.09); }
.auth-input::placeholder { color:#c0b4a4; font-weight:300; }
.btn-auth { width:100%; padding:.9rem; background:var(--accent); color:#fff; border:none; border-radius:var(--r-md); font-family:'DM Sans',sans-serif; font-size:.9rem; font-weight:600; cursor:pointer; transition:background .18s,box-shadow .18s,transform .15s; box-shadow:0 3px 16px rgba(184,74,28,.28); }
.btn-auth:hover { background:var(--accent-dk); box-shadow:0 5px 22px rgba(184,74,28,.36); transform:translateY(-1px); }
.btn-auth:active { transform:translateY(0); }
.auth-back { display:inline-flex; align-items:center; gap:.45rem; margin-top:1.75rem; font-size:.83rem; color:var(--ink-3); text-decoration:none; transition:color .18s; font-weight:500; }
.auth-back:hover { color:var(--accent); }
.auth-back svg { transition:transform .18s; }
.auth-back:hover svg { transform:translateX(-3px); }
</style>
@endsection
@section('content')
<div class="auth-page">
    <div class="auth-visual">
        <img src="https://images.unsplash.com/photo-1466637574441-749b8f19452f?w=900&q=80" alt="">
        <div class="auth-visual-overlay">
            <div class="auth-visual-line"></div>
            <div class="auth-visual-quote">Un mot de passe oublié<br>n'efface pas<br><em>votre passion.</em></div>
            <div class="auth-visual-attr">Cuisto &mdash; Réinitialisez en quelques secondes</div>
        </div>
    </div>
    <div class="auth-form-col">
        <div class="auth-box">
            <a href="{{ route('home') }}" class="auth-logo">Cuisto</a>
            <div class="auth-eyebrow"></div>
            <h1 class="auth-title">Mot de passe <em>oublié</em></h1>
            <p class="auth-sub">Saisissez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="auth-field">
                    <label class="auth-label">Adresse e-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="auth-input" placeholder="vous@exemple.com">
                </div>
                <button type="submit" class="btn-auth">Envoyer le lien de réinitialisation</button>
            </form>

            <a href="{{ route('login') }}" class="auth-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection

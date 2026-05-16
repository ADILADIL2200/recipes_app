{{-- resources/views/auth/reset-password.blade.php --}}
@extends('layouts.app')
@section('title', 'Nouveau mot de passe — Cuisto')
@section('styles')
<style>
.auth-page { min-height:calc(100vh - 66px); display:grid; grid-template-columns:1fr 1fr; background:#f8f5f0; }
.auth-visual { position:relative; overflow:hidden; background:#18140e; display:none; }
@media(min-width:900px){ .auth-visual{display:block;} .auth-form-col{padding:3rem 5rem;} }
.auth-visual img { width:100%; height:100%; object-fit:cover; opacity:.42; transition:transform 12s ease; }
.auth-visual:hover img { transform:scale(1.04); }
.auth-visual-overlay { position:absolute; inset:0; background:linear-gradient(155deg,rgba(184,74,28,.38) 0%,rgba(24,20,14,.82) 100%); display:flex; flex-direction:column; justify-content:flex-end; padding:3.5rem; }
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
.auth-sub { font-size:.875rem; color:var(--ink-3); font-weight:300; margin-bottom:2.25rem; line-height:1.6; }
.auth-field { margin-bottom:1.25rem; }
.auth-label { display:block; font-size:.68rem; font-weight:600; text-transform:uppercase; letter-spacing:.1em; color:var(--ink-3); margin-bottom:.45rem; }
.auth-input { width:100%; padding:.78rem 1rem; background:#fff; border:1.5px solid var(--border); border-radius:var(--r-md); font-family:'DM Sans',sans-serif; font-size:.88rem; color:var(--ink); outline:none; transition:border-color .18s,box-shadow .18s; }
.auth-input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(184,74,28,.09); }
.auth-input::placeholder { color:#c0b4a4; font-weight:300; }
.btn-auth { width:100%; padding:.9rem; background:var(--accent); color:#fff; border:none; border-radius:var(--r-md); font-family:'DM Sans',sans-serif; font-size:.9rem; font-weight:600; cursor:pointer; transition:background .18s,box-shadow .18s,transform .15s; box-shadow:0 3px 16px rgba(184,74,28,.28); margin-top:.5rem; }
.btn-auth:hover { background:var(--accent-dk); box-shadow:0 5px 22px rgba(184,74,28,.36); transform:translateY(-1px); }
.btn-auth:active { transform:translateY(0); }
</style>
@endsection
@section('content')
<div class="auth-page">
    <div class="auth-visual">
        <img src="https://images.unsplash.com/photo-1495521821757-a1efb6729352?w=900&q=80" alt="">
        <div class="auth-visual-overlay">
            <div class="auth-visual-line"></div>
            <div class="auth-visual-quote">Nouveau départ,<br><em>nouvelles saveurs</em><br>vous attendent.</div>
            <div class="auth-visual-attr">Cuisto &mdash; Votre cuisine, votre espace</div>
        </div>
    </div>
    <div class="auth-form-col">
        <div class="auth-box">
            <a href="{{ route('home') }}" class="auth-logo">Cuisto</a>
            <div class="auth-eyebrow"></div>
            <h1 class="auth-title">Nouveau <em>mot de passe</em></h1>
            <p class="auth-sub">Choisissez un mot de passe sécurisé pour votre compte.</p>

            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="auth-field">
                    <label class="auth-label">Adresse e-mail</label>
                    <input type="email" name="email" value="{{ old('email', $email) }}" required class="auth-input">
                </div>
                <div class="auth-field">
                    <label class="auth-label">Nouveau mot de passe</label>
                    <input type="password" name="password" required class="auth-input" placeholder="Minimum 8 caractères">
                </div>
                <div class="auth-field">
                    <label class="auth-label">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" required class="auth-input" placeholder="Répétez le mot de passe">
                </div>
                <button type="submit" class="btn-auth">Réinitialiser le mot de passe</button>
            </form>
        </div>
    </div>
</div>
@endsection

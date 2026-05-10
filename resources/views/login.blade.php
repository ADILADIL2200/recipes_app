{{-- resources/views/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Connexion')

@section('styles')
<style>
.auth-wrap {
    min-height: calc(100vh - 68px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1.5rem;
}
.auth-card {
    width: 100%;
    max-width: 460px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}
.auth-header {
    padding: 2.5rem 2.5rem 0;
    border-bottom: 1px solid var(--border);
    padding-bottom: 2rem;
    margin-bottom: 2rem;
}
.auth-header h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.1;
}
.auth-header h1 em { font-style: italic; color: var(--accent); }
.auth-header p { font-size: .88rem; color: var(--ink-3); margin-top: .35rem; font-weight: 300; }
.auth-body { padding: 0 2.5rem 2.5rem; }
.auth-field { margin-bottom: 1.25rem; }
.auth-footer-link {
    text-align: center;
    font-size: .85rem;
    color: var(--ink-3);
    padding: 1.5rem 2.5rem;
    border-top: 1px solid var(--border);
    background: #faf7f3;
}
.auth-footer-link a { color: var(--accent); text-decoration: none; font-weight: 500; }
.auth-footer-link a:hover { text-decoration: underline; }
.remember-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; font-size: .85rem; }
.remember-row label { display: flex; align-items: center; gap: .5rem; color: var(--ink-2); cursor: pointer; }
.remember-row input[type="checkbox"] {
    width: 15px; height: 15px;
    accent-color: var(--accent);
    cursor: pointer;
}
.remember-row a { color: var(--accent); text-decoration: none; font-size: .83rem; }
.remember-row a:hover { text-decoration: underline; }
.btn-auth {
    width: 100%;
    justify-content: center;
    padding: .85rem;
    font-size: .92rem;
    border-radius: var(--r-md);
    background: var(--accent);
    color: #fff;
    border: none;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    font-weight: 600;
    transition: background .18s;
    letter-spacing: .01em;
}
.btn-auth:hover { background: var(--accent-dk); }
</style>
@endsection

@section('content')
<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-header">
            <div style="display:inline-block;width:36px;height:3px;background:var(--accent);border-radius:2px;margin-bottom:1rem"></div>
            <h1>Bon <em>retour</em></h1>
            <p>Connectez-vous à votre espace Saveur</p>
        </div>

        <div class="auth-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="auth-field">
                    <label class="form-label">Adresse e-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="form-input" placeholder="vous@exemple.com">
                </div>

                <div class="auth-field">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" required
                           class="form-input" placeholder="Votre mot de passe">
                </div>

                <div class="remember-row">
                    <label>
                        <input type="checkbox" name="remember">
                        Se souvenir de moi
                    </label>
                    <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn btn-auth">Se connecter</button>
            </form>

        </div>

        <div class="auth-footer-link">
            Pas encore de compte ? <a href="{{ route('signup') }}">Créer un compte</a>
        </div>

    </div>
</div>
@endsection

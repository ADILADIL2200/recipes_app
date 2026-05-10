{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('styles')
<style>
.auth-wrap { min-height: calc(100vh - 68px); display: flex; align-items: center; justify-content: center; padding: 3rem 1.5rem; }
.auth-card { width: 100%; max-width: 460px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); box-shadow: var(--shadow-md); overflow: hidden; }
.auth-header { padding: 2.5rem 2.5rem 2rem; border-bottom: 1px solid var(--border); margin-bottom: 2rem; }
.auth-header h1 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 600; color: var(--ink); line-height: 1.1; }
.auth-header h1 em { font-style: italic; color: var(--accent); }
.auth-header p { font-size: .88rem; color: var(--ink-3); margin-top: .35rem; font-weight: 300; line-height: 1.6; }
.auth-body { padding: 0 2.5rem 2.5rem; }
.auth-field { margin-bottom: 1.5rem; }
.auth-footer-link { text-align: center; font-size: .85rem; color: var(--ink-3); padding: 1.5rem 2.5rem; border-top: 1px solid var(--border); background: #faf7f3; }
.auth-footer-link a { color: var(--accent); text-decoration: none; font-weight: 500; }
.auth-footer-link a:hover { text-decoration: underline; }
.btn-auth { width: 100%; justify-content: center; padding: .85rem; font-size: .92rem; border-radius: var(--r-md); background: var(--accent); color: #fff; border: none; cursor: pointer; font-family: 'Outfit', sans-serif; font-weight: 600; transition: background .18s; }
.btn-auth:hover { background: var(--accent-dk); }
</style>
@endsection

@section('content')
<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-header">
            <div style="display:inline-block;width:36px;height:3px;background:var(--accent);border-radius:2px;margin-bottom:1rem"></div>
            <h1>Mot de passe <em>oublié</em></h1>
            <p>Saisissez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
        </div>

        <div class="auth-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="auth-field">
                    <label class="form-label">Adresse e-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="form-input" placeholder="vous@exemple.com">
                </div>

                <button type="submit" class="btn btn-auth">Envoyer le lien</button>
            </form>

        </div>

        <div class="auth-footer-link">
            <a href="{{ route('login') }}">&larr; Retour à la connexion</a>
        </div>

    </div>
</div>
@endsection

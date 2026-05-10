{{-- resources/views/auth/reset-password.blade.php --}}
@extends('layouts.app')

@section('title', 'Nouveau mot de passe')

@section('styles')
<style>
.auth-wrap { min-height: calc(100vh - 68px); display: flex; align-items: center; justify-content: center; padding: 3rem 1.5rem; }
.auth-card { width: 100%; max-width: 460px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); box-shadow: var(--shadow-md); overflow: hidden; }
.auth-header { padding: 2.5rem 2.5rem 2rem; border-bottom: 1px solid var(--border); margin-bottom: 2rem; }
.auth-header h1 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 600; color: var(--ink); line-height: 1.1; }
.auth-header h1 em { font-style: italic; color: var(--accent); }
.auth-header p { font-size: .88rem; color: var(--ink-3); margin-top: .35rem; font-weight: 300; }
.auth-body { padding: 0 2.5rem 2.5rem; }
.auth-field { margin-bottom: 1.25rem; }
.btn-auth { width: 100%; justify-content: center; padding: .85rem; font-size: .92rem; border-radius: var(--r-md); background: var(--accent); color: #fff; border: none; cursor: pointer; font-family: 'Outfit', sans-serif; font-weight: 600; transition: background .18s; }
.btn-auth:hover { background: var(--accent-dk); }
</style>
@endsection

@section('content')
<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-header">
            <div style="display:inline-block;width:36px;height:3px;background:var(--accent);border-radius:2px;margin-bottom:1rem"></div>
            <h1>Nouveau <em>mot de passe</em></h1>
            <p>Choisissez un mot de passe sécurisé pour votre compte.</p>
        </div>

        <div class="auth-body">

            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="auth-field">
                    <label class="form-label">Adresse e-mail</label>
                    <input type="email" name="email" value="{{ old('email', $email) }}" required
                           class="form-input">
                </div>

                <div class="auth-field">
                    <label class="form-label">Nouveau mot de passe</label>
                    <input type="password" name="password" required
                           class="form-input" placeholder="Minimum 8 caractères">
                </div>

                <div class="auth-field" style="margin-bottom:1.75rem">
                    <label class="form-label">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" required
                           class="form-input" placeholder="Répétez le mot de passe">
                </div>

                <button type="submit" class="btn btn-auth">Réinitialiser le mot de passe</button>
            </form>

        </div>

    </div>
</div>
@endsection

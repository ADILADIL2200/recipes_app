{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Mon Profil')

@section('styles')
<style>
.profile-grid { display: grid; grid-template-columns: 260px 1fr; gap: 2rem; align-items: start; }
.profile-sidebar { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; position: sticky; top: 88px; }
.profile-sidebar-head { padding: 2rem; text-align: center; border-bottom: 1px solid var(--border); }
.avatar-ring { width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 1rem; overflow: hidden; background: var(--accent-lt); border: 2px solid var(--border); display: flex; align-items: center; justify-content: center; }
.avatar-ring img { width: 100%; height: 100%; object-fit: cover; }
.avatar-initials { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; font-weight: 600; color: var(--accent); }
.profile-sidebar-name { font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 600; color: var(--ink); }
.profile-sidebar-email { font-size: .8rem; color: var(--ink-3); margin-top: .2rem; }
.profile-sidebar-nav { padding: .5rem 0; }
.profile-sidebar-nav a { display: flex; align-items: center; gap: .6rem; padding: .7rem 1.5rem; font-size: .88rem; color: var(--ink-2); text-decoration: none; transition: all .15s; }
.profile-sidebar-nav a:hover, .profile-sidebar-nav a.active { background: var(--accent-lt); color: var(--accent); }

.form-section { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; margin-bottom: 1.25rem; }
.form-section-head { padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border); background: #faf7f3; }
.form-section-head h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 600; color: var(--ink); }
.form-section-head p { font-size: .8rem; color: var(--ink-3); margin-top: .15rem; }
.form-section-body { padding: 1.75rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-field { margin-bottom: 1.1rem; }
.form-field:last-child { margin-bottom: 0; }
.form-actions { display: flex; align-items: center; justify-content: flex-end; gap: .75rem; padding-top: 1rem; border-top: 1px solid var(--border); margin-top: 1.5rem; }

.file-upload-btn { display: inline-flex; align-items: center; gap: .5rem; padding: .5rem 1rem; background: var(--bg); border: 1.5px solid var(--border); border-radius: var(--r-md); font-size: .82rem; color: var(--ink-2); cursor: pointer; transition: all .18s; font-family: 'Outfit', sans-serif; }
.file-upload-btn:hover { border-color: var(--accent); color: var(--accent); }
input[type="file"] { display: none; }

@media (max-width: 768px) {
    .profile-grid { grid-template-columns: 1fr; }
    .profile-sidebar { position: static; }
    .form-row { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')
<div class="page-wrap">

    <div style="margin-bottom:2rem">
        <div style="display:inline-block;width:36px;height:3px;background:var(--accent);border-radius:2px;margin-bottom:.75rem"></div>
        <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.2rem;font-weight:600;color:var(--ink)">Mon <em style="font-style:italic;color:var(--accent)">profil</em></h1>
        <p style="font-size:.9rem;color:var(--ink-3);margin-top:.3rem">Gérez vos informations personnelles et votre mot de passe</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            <ul style="padding-left:1.1rem;margin-top:.2rem">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="profile-grid">

            {{-- Sidebar --}}
            <div class="profile-sidebar">
                <div class="profile-sidebar-head">
                    <div class="avatar-ring">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                        @else
                            <span class="avatar-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="profile-sidebar-name">{{ $user->name }}</div>
                    <div class="profile-sidebar-email">{{ $user->email }}</div>
                </div>
                <nav class="profile-sidebar-nav">
                    <a href="{{ route('profile.edit') }}" class="active">Informations</a>
                    <a href="{{ route('recipes.my') }}">Mes recettes</a>
                    <a href="{{ route('recipes.favorites') }}">Favoris</a>
                </nav>
            </div>

            {{-- Main --}}
            <div>

                {{-- Avatar --}}
                <div class="form-section">
                    <div class="form-section-head">
                        <h3>Photo de profil</h3>
                        <p>JPG, PNG ou WebP — max 2 Mo</p>
                    </div>
                    <div class="form-section-body" style="display:flex;align-items:center;gap:1.5rem">
                        <div class="avatar-ring" style="width:64px;height:64px;flex-shrink:0">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="">
                            @else
                                <span class="avatar-initials" style="font-size:1.4rem">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div>
                            <label for="avatarInput" class="file-upload-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                Changer la photo
                            </label>
                            <input type="file" id="avatarInput" name="avatar" accept="image/jpg,image/jpeg,image/png,image/webp">
                            <p style="font-size:.75rem;color:var(--ink-3);margin-top:.5rem">Résolution recommandée : 400×400 px</p>
                        </div>
                    </div>
                </div>

                {{-- Infos --}}
                <div class="form-section">
                    <div class="form-section-head">
                        <h3>Informations personnelles</h3>
                    </div>
                    <div class="form-section-body">
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Nom complet</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input">
                            </div>
                            <div class="form-field">
                                <label class="form-label">Adresse e-mail</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input">
                            </div>
                        </div>
                        <div class="form-field">
                            <label class="form-label">Biographie <span style="font-weight:300;text-transform:none;letter-spacing:0">— facultatif</span></label>
                            <textarea name="bio" rows="3" maxlength="500" class="form-textarea" placeholder="Parlez-nous de vous, votre cuisine, vos inspirations...">{{ old('bio', $user->bio) }}</textarea>
                            <div style="font-size:.72rem;color:var(--ink-3);text-align:right;margin-top:.3rem">Max 500 caractères</div>
                        </div>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-section">
                    <div class="form-section-head">
                        <h3>Mot de passe</h3>
                        <p>Laisser vide pour ne pas modifier</p>
                    </div>
                    <div class="form-section-body">
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Nouveau mot de passe</label>
                                <input type="password" name="password" class="form-input" placeholder="Minimum 8 caractères">
                            </div>
                            <div class="form-field">
                                <label class="form-label">Confirmer</label>
                                <input type="password" name="password_confirmation" class="form-input" placeholder="Répétez le mot de passe">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('home') }}" class="btn btn-ghost">&larr; Retour</a>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection

{{-- resources/views/recipes/edit.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modifier {{ $recipe->title }} — Cuisto</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #f9f6f1; --surface: #ffffff;
            --ink: #18140e; --ink-2: #5a4e3c; --ink-3: #9a8e7e;
            --accent: #b84a1c; --accent-lt: #f5ede7;
            --border: #e8e0d4; --gold: #c8972a;
            --r-sm: 8px; --r-md: 14px; --r-lg: 22px;
        }
        body { font-family: 'Outfit', sans-serif; background: var(--bg); color: var(--ink); min-height: 100vh; -webkit-font-smoothing: antialiased; }

        .flash       { background: #3d5c36; color: #fff; text-align: center; padding: .6rem 1rem; font-size: .85rem; }
        .flash-error { background: #c0392b; }

        nav { position: sticky; top: 0; z-index: 200; background: rgba(249,246,241,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 2.5rem; height: 68px; }
        .nav-brand { font-family: 'Cormorant Garamond', serif; font-size: 1.9rem; font-weight: 600; color: var(--accent); text-decoration: none; }
        .nav-links  { display: flex; align-items: center; gap: 1.8rem; }
        .nav-links a { text-decoration: none; color: var(--ink-2); font-size: .9rem; font-weight: 500; transition: color .2s; }
        .nav-links a:hover { color: var(--accent); }
        .btn { display: inline-flex; align-items: center; gap: .4rem; text-decoration: none; padding: .5rem 1.25rem; border-radius: 999px; font-size: .85rem; font-weight: 500; cursor: pointer; border: 1.5px solid transparent; transition: all .18s; white-space: nowrap; }
        .btn-primary { background: var(--accent); color: #fff; border-color: var(--accent); }
        .btn-primary:hover { background: #9e3a12; }
        .btn-ghost { background: var(--surface); color: var(--ink-2); border-color: var(--border); }
        .btn-ghost:hover { border-color: var(--ink-3); color: var(--ink); }

        .page-wrap { max-width: 760px; margin: 0 auto; padding: 3rem 2rem 5rem; }
        .page-head  { margin-bottom: 2rem; }
        .page-head h1 { font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; font-weight: 600; color: var(--ink); }
        .page-head p  { color: var(--ink-3); font-size: .9rem; margin-top: .3rem; }

        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); padding: 1.8rem; margin-bottom: 1.2rem; }
        .card-title { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: var(--accent); margin-bottom: 1.2rem; }

        .field { display: flex; flex-direction: column; gap: .4rem; margin-bottom: 1.1rem; }
        .field:last-child { margin-bottom: 0; }
        label.lbl { font-size: .78rem; font-weight: 600; color: var(--ink-3); text-transform: uppercase; letter-spacing: .07em; }
        .hint { font-weight: 400; text-transform: none; letter-spacing: 0; font-size: .72rem; }

        input[type=text], input[type=number], select, textarea {
            width: 100%; font-family: 'Outfit', sans-serif; font-size: .88rem;
            color: var(--ink); background: var(--bg);
            border: 1.5px solid var(--border); border-radius: var(--r-sm);
            padding: .65rem 1rem; outline: none;
            transition: border-color .2s, box-shadow .2s;
            line-height: 1.5;
        }
        input:focus, select:focus, textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(184,74,28,.1); background: #fff; }
        textarea { resize: vertical; min-height: 100px; }
        select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239a8e7e' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right .8rem center; padding-right: 2.4rem; }
        .err-msg { font-size: .75rem; color: #c0392b; margin-top: .2rem; }

        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
        @media(max-width:500px) { .grid-3 { grid-template-columns: 1fr; } }

        .unit-wrap { position: relative; }
        .unit-wrap input { padding-right: 2.8rem; }
        .unit { position: absolute; right: .85rem; top: 50%; transform: translateY(-50%); font-size: .7rem; color: var(--ink-3); pointer-events: none; }

        /* Tags */
        .tags-wrap { display: flex; flex-wrap: wrap; gap: .4rem; }
        .tag-lbl input { position: absolute; opacity: 0; pointer-events: none; }
        .tag-pill { display: inline-flex; align-items: center; padding: .3rem .8rem; border-radius: 999px; border: 1.5px solid var(--border); background: #fff; font-size: .8rem; color: var(--ink-3); cursor: pointer; transition: all .18s; user-select: none; }
        .tag-pill:hover { border-color: var(--accent); color: var(--accent); }
        .tag-lbl input:checked + .tag-pill { background: var(--accent-lt); border-color: var(--accent); color: var(--accent); font-weight: 600; }

        /* Image preview */
        .img-preview { width: 100%; max-height: 260px; object-fit: cover; border-radius: var(--r-md); border: 1px solid var(--border); margin-top: .8rem; }
        .current-img { width: 100%; max-height: 200px; object-fit: cover; border-radius: var(--r-md); border: 1px solid var(--border); margin-bottom: .75rem; }

        /* Publish toggle */
        .publish-row { display: flex; align-items: center; justify-content: space-between; }
        .publish-row .info strong { font-size: .88rem; font-weight: 600; color: var(--ink); display: block; margin-bottom: .2rem; }
        .publish-row .info span   { font-size: .78rem; color: var(--ink-3); }
        .toggle { position: relative; width: 46px; height: 25px; flex-shrink: 0; }
        .toggle input { opacity: 0; width: 0; height: 0; position: absolute; }
        .toggle-track { position: absolute; inset: 0; background: var(--border); border-radius: 999px; transition: background .2s; cursor: pointer; }
        .toggle-thumb { position: absolute; left: 3px; top: 3px; width: 19px; height: 19px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 4px rgba(0,0,0,.18); pointer-events: none; }
        .toggle input:checked ~ .toggle-track { background: var(--accent); }
        .toggle input:checked ~ .toggle-thumb { transform: translateX(21px); }

        /* Form actions */
        .form-actions { display: flex; align-items: center; justify-content: space-between; padding-top: 1rem; }
        .btn-submit { background: var(--accent); color: #fff; border: none; border-radius: 999px; padding: .75rem 2.2rem; font-family: 'Outfit', sans-serif; font-size: .9rem; font-weight: 600; cursor: pointer; transition: background .18s; }
        .btn-submit:hover { background: #9e3a12; }

        /* Validation errors banner */
        .errors-banner { background: #fff0ee; border: 1.5px solid #f5b8b0; border-radius: var(--r-md); padding: 1rem 1.2rem; margin-bottom: 1.5rem; font-size: .85rem; color: #c0392b; }
        .errors-banner ul { padding-left: 1.2rem; margin-top: .4rem; }

        footer { border-top: 1px solid var(--border); padding: 2rem 2.5rem; text-align: center; font-size: .82rem; color: var(--ink-3); }
        footer a { color: var(--accent); text-decoration: none; }
    </style>
</head>
<body>

@if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
@if(session('error'))<div class="flash flash-error">{{ session('error') }}</div>@endif

<nav>
    <a href="{{ route('home') }}" class="nav-brand">Cuisto</a>
    <div class="nav-links">
        <a href="{{ route('recipes.show', $recipe) }}">← Voir la recette</a>
        <a href="{{ route('recipes.my') }}">Mes recettes</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn btn-ghost">Déconnexion</button>
        </form>
    </div>
</nav>

<div class="page-wrap">

    <div class="page-head">
        <div style="display:inline-block;width:28px;height:2px;background:var(--accent);border-radius:2px;margin-bottom:.75rem"></div>
        <h1>Modifier la recette</h1>
        <p>{{ $recipe->title }}</p>
        <div style="display:flex;align-items:center;gap:.75rem;margin-top:.75rem">
            <span style="display:inline-flex;align-items:center;gap:.35rem;font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:999px;background:{{ $recipe->is_published ? '#eaf2e8' : '#fef6e4' }};color:{{ $recipe->is_published ? '#3d5c36' : '#a87d1f' }}">
                {{ $recipe->is_published ? '✓ Publiée' : '○ Brouillon' }}
            </span>
            <span style="font-size:.75rem;color:var(--ink-3)">Dernière modification {{ $recipe->updated_at->diffForHumans() }}</span>
        </div>
    </div>

    @if($errors->any())
    <div class="errors-banner">
        ⚠️ Veuillez corriger les erreurs suivantes :
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('recipes.update', $recipe) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Informations de base --}}
        <div class="card">
            <div class="card-title">Informations de base</div>

            <div class="field">
                <label class="lbl" for="title">Titre <span style="color:var(--accent)">*</span></label>
                <input type="text" id="title" name="title"
                       value="{{ old('title', $recipe->title) }}"
                       maxlength="255" required>
                @error('title')<div class="err-msg">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label class="lbl">Catégorie <span style="color:var(--accent)">*</span></label>
                <select name="category_id" required>
                    <option value="">— Choisir une catégorie —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $recipe->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<div class="err-msg">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label class="lbl">Description <span class="hint">— facultatif</span></label>
                <textarea name="description" rows="3" maxlength="400"
                          placeholder="Brève présentation du plat...">{{ old('description', $recipe->description) }}</textarea>
                @error('description')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Tags --}}
        <div class="card">
            <div class="card-title">Tags</div>
            @if($tags->isEmpty())
                <p style="font-size:.85rem;color:var(--ink-3)">Aucun tag disponible.</p>
            @else
            <div class="tags-wrap">
                @foreach($tags as $tag)
                <label class="tag-lbl">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                           {{ in_array($tag->id, old('tags', $recipe->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <span class="tag-pill">{{ $tag->name }}</span>
                </label>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Ingrédients & Instructions --}}
        <div class="card">
            <div class="card-title">Ingrédients & Instructions</div>

            <div class="field">
                <label class="lbl">Ingrédients <span style="color:var(--accent)">*</span> <span class="hint">— un par ligne</span></label>
                <textarea name="ingredients" rows="6" required
                          placeholder="200 g de farine&#10;3 œufs&#10;...">{{ old('ingredients', $recipe->ingredients) }}</textarea>
                @error('ingredients')<div class="err-msg">{{ $message }}</div>@enderror
            </div>

            <div class="field" style="margin-top:1rem">
                <label class="lbl">Instructions <span style="color:var(--accent)">*</span> <span class="hint">— une étape par ligne</span></label>
                <textarea name="steps" rows="6" required
                          placeholder="Préchauffer le four à 180 °C.&#10;Mélanger les ingrédients...&#10;...">{{ old('steps', $recipe->steps) }}</textarea>
                @error('steps')<div class="err-msg">{{ $message }}</div>@enderror
            </div>

            <div class="grid-3" style="margin-top:1rem">
                <div class="field">
                    <label class="lbl">Préparation</label>
                    <div class="unit-wrap">
                        <input type="number" name="prep_time" min="0"
                               value="{{ old('prep_time', $recipe->prep_time) }}" placeholder="15">
                        <span class="unit">min</span>
                    </div>
                </div>
                <div class="field">
                    <label class="lbl">Cuisson</label>
                    <div class="unit-wrap">
                        <input type="number" name="cook_time" min="0"
                               value="{{ old('cook_time', $recipe->cook_time) }}" placeholder="45">
                        <span class="unit">min</span>
                    </div>
                </div>
                <div class="field">
                    <label class="lbl">Portions</label>
                    <div class="unit-wrap">
                        <input type="number" name="servings" min="1"
                               value="{{ old('servings', $recipe->servings) }}" placeholder="4">
                        <span class="unit">pers.</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Photo --}}
        <div class="card">
            <div class="card-title">Photo</div>

            @if($recipe->image)
            <p style="font-size:.8rem;color:var(--ink-3);margin-bottom:.5rem">Photo actuelle :</p>
            <img src="{{ asset('storage/' . $recipe->image) }}"
                 alt="{{ $recipe->title }}" class="current-img">
            <p style="font-size:.78rem;color:var(--ink-3);margin-bottom:.75rem">
                Choisissez une nouvelle photo pour remplacer celle-ci, ou laissez vide pour la garder.
            </p>
            @endif

            <div class="field">
                <label class="lbl">Nouvelle photo <span class="hint">— JPG, PNG, WebP — max 5 Mo</span></label>
                <input type="file" name="image" accept="image/jpg,image/jpeg,image/png,image/webp"
                       onchange="previewImg(this)"
                       style="background:#fff;padding:.5rem;cursor:pointer">
                <img id="imgPreview" class="img-preview" src="" alt="" style="display:none">
                @error('image')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Publication --}}
        <div class="card">
            <div class="card-title">Publication</div>
            <div class="publish-row">
                <div class="info">
                    <strong>Publier la recette</strong>
                    <span>Si désactivé, la recette sera sauvegardée en brouillon.</span>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="is_published" value="1"
                           {{ old('is_published', $recipe->is_published) ? 'checked' : '' }}>
                    <span class="toggle-track"></span>
                    <span class="toggle-thumb"></span>
                </label>
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-ghost">← Annuler</a>
            <div style="display:flex;align-items:center;gap:.75rem">
                <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline" style="font-size:.82rem">👁 Voir la recette</a>
                <button type="submit" class="btn-submit">💾 Enregistrer les modifications</button>
            </div>
        </div>

    </form>
</div>

<footer>
    <p>© {{ date('Y') }} <a href="{{ route('home') }}">Cuisto</a> — La cuisine, simplement.</p>
</footer>

<script>
function previewImg(inp) {
    if (!inp.files?.[0]) return;
    if (inp.files[0].size > 5 * 1024 * 1024) {
        alert('La photo dépasse 5 Mo.');
        inp.value = '';
        return;
    }
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('imgPreview');
        img.src = e.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(inp.files[0]);
}
</script>
</body>
</html>

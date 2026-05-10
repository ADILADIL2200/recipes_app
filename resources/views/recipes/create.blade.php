{{-- resources/views/recipes/create.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nouvelle recette — Saveur</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap');

    :root {
        --cream:        #faf7f3;
        --sand:         #e8e0d4;
        --sand-dark:    #d0c5b4;
        --muted:        #9a8e7e;
        --text-light:   #6b5f4f;
        --text:         #3d3025;
        --text-dark:    #18140e;
        --accent:       #b84a1c;
        --accent-dark:  #9e3a12;
        --accent-pale:  #f5ede7;
        --danger:       #c0392b;
        --white:        #ffffff;
        --shadow-sm:    0 1px 4px rgba(24,20,14,.07);
        --shadow-md:    0 4px 20px rgba(24,20,14,.09);
        --r-md:         10px;
        --r-lg:         16px;
        --r-xl:         20px;
        --font-d:       'Cormorant Garamond', Georgia, serif;
        --font-b:       'DM Sans', system-ui, sans-serif;
        --ease:         .28s cubic-bezier(.4,0,.2,1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; }

    .sfwiz {
        font-family: var(--font-b);
        background: var(--cream);
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow: hidden;
    }

    /* Header */
    .sfwiz-header {
        flex-shrink: 0;
        background: var(--white);
        border-bottom: 1px solid var(--sand);
        padding: 0 2.5rem;
        display: flex; align-items: center; justify-content: space-between;
        height: 62px; gap: 1.5rem;
    }
    .sfwiz-logo { font-family: var(--font-d); font-size: 1.35rem; font-weight: 500; color: var(--text-dark); letter-spacing: -.01em; flex-shrink: 0; }
    .sfwiz-logo span { color: var(--accent); font-style: italic; }

    /* Progress steps */
    .sfwiz-steps-nav { flex: 1; max-width: 500px; display: flex; align-items: center; }
    .sfwiz-step-item { display: flex; align-items: center; gap: .42rem; flex-shrink: 0; }
    .sfwiz-step-dot { width: 26px; height: 26px; border-radius: 50%; border: 1.5px solid var(--sand-dark); background: var(--white); display: flex; align-items: center; justify-content: center; font-size: .65rem; font-weight: 600; color: var(--muted); transition: all var(--ease); }
    .sfwiz-step-dot .check { display: none; }
    .sfwiz-step-item.is-active .sfwiz-step-dot { background: var(--accent); border-color: var(--accent); color: #fff; box-shadow: 0 0 0 4px rgba(184,74,28,.14); }
    .sfwiz-step-item.is-done .sfwiz-step-dot { background: var(--accent); border-color: var(--accent); color: #fff; }
    .sfwiz-step-item.is-done .sfwiz-step-dot .num { display: none; }
    .sfwiz-step-item.is-done .sfwiz-step-dot .check { display: block; }
    .sfwiz-step-label { font-size: .7rem; font-weight: 500; color: var(--muted); transition: color var(--ease); }
    .sfwiz-step-item.is-active .sfwiz-step-label, .sfwiz-step-item.is-done .sfwiz-step-label { color: var(--text); }
    .sfwiz-step-line { flex: 1; height: 1px; background: var(--sand); margin: 0 .45rem; min-width: 12px; transition: background var(--ease); }
    .sfwiz-step-line.is-done { background: var(--accent); opacity: .4; }

    .sfwiz-cancel { flex-shrink: 0; font-size: .8rem; color: var(--muted); text-decoration: none; display: flex; align-items: center; gap: .3rem; transition: color var(--ease); }
    .sfwiz-cancel:hover { color: var(--text); }

    /* Progress bar */
    .sfwiz-progressbar { flex-shrink: 0; height: 2px; background: var(--sand); }
    .sfwiz-pb-fill { height: 100%; background: var(--accent); transition: width .5s cubic-bezier(.4,0,.2,1); }

    /* Body */
    .sfwiz-body { flex: 1; overflow: hidden; position: relative; }
    .sfwiz-slides { display: flex; height: 100%; transition: transform .42s cubic-bezier(.4,0,.2,1); will-change: transform; }
    .sfwiz-slide { flex-shrink: 0; width: 100%; height: 100%; overflow-y: auto; display: flex; justify-content: center; padding: 2.2rem 1.25rem 1.5rem; }
    .sfwiz-slide::-webkit-scrollbar { width: 4px; }
    .sfwiz-slide::-webkit-scrollbar-thumb { background: var(--sand-dark); border-radius: 4px; }
    .sfwiz-slide-inner { width: 100%; max-width: 580px; }

    /* Step heading */
    .sfwiz-step-head { margin-bottom: 1.6rem; }
    .sfwiz-step-badge { display: inline-flex; align-items: center; gap: .3rem; font-size: .62rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--accent); background: var(--accent-pale); padding: .2rem .65rem; border-radius: 999px; margin-bottom: .7rem; }
    .sfwiz-step-head h2 { font-family: var(--font-d); font-size: 2rem; font-weight: 500; color: var(--text-dark); line-height: 1.1; }
    .sfwiz-step-head h2 em { font-style: italic; color: var(--accent); }
    .sfwiz-step-head p { font-size: .84rem; color: var(--muted); margin-top: .3rem; font-weight: 300; line-height: 1.55; }

    /* Card */
    .sfwiz-card { background: var(--white); border: 1px solid var(--sand); border-radius: var(--r-xl); box-shadow: var(--shadow-sm); margin-bottom: .85rem; overflow: hidden; }
    .sfwiz-card-body { padding: 1.4rem; }

    /* Fields */
    .sfwiz-field { display: flex; flex-direction: column; gap: .4rem; margin-bottom: 1.1rem; }
    .sfwiz-field:last-child { margin-bottom: 0; }
    .sfwiz-label { font-size: .68rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); display: flex; align-items: center; gap: .3rem; }
    .sfwiz-label-hint { font-weight: 300; text-transform: none; letter-spacing: 0; font-size: .7rem; }
    .sfwiz-req { color: var(--accent); }

    .sfwiz-input, .sfwiz-select, .sfwiz-textarea {
        width: 100%; font-family: var(--font-b); font-size: .88rem;
        color: var(--text-dark); background: var(--cream);
        border: 1.5px solid var(--sand); border-radius: var(--r-md);
        padding: .68rem 1rem; outline: none;
        transition: border-color var(--ease), box-shadow var(--ease), background var(--ease);
        line-height: 1.5;
    }
    .sfwiz-input:focus, .sfwiz-select:focus, .sfwiz-textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(184,74,28,.10); background: var(--white); }
    .sfwiz-input::placeholder, .sfwiz-textarea::placeholder { color: #c5b8a8; font-weight: 300; }
    .sfwiz-input.err, .sfwiz-select.err, .sfwiz-textarea.err { border-color: var(--danger); background: #fff9f9; }
    .sfwiz-textarea { resize: vertical; min-height: 96px; line-height: 1.7; }
    .sfwiz-select { appearance: none; cursor: pointer; padding-right: 2.4rem; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%239a8e7e' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right .8rem center; }

    .sfwiz-error { font-size: .72rem; color: var(--danger); display: flex; align-items: center; gap: .28rem; }
    .sfwiz-counter { font-size: .68rem; color: var(--muted); text-align: right; font-weight: 300; }

    .sfwiz-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: .9rem; }
    @media (max-width:500px) { .sfwiz-grid-3 { grid-template-columns: 1fr; } }

    .sfwiz-unit-wrap { position: relative; }
    .sfwiz-unit-wrap .sfwiz-input { padding-right: 3rem; }
    .sfwiz-unit { position: absolute; right: .85rem; top: 50%; transform: translateY(-50%); font-size: .7rem; font-weight: 500; color: var(--muted); pointer-events: none; }

    /* Tags */
    .sfwiz-tags { display: flex; flex-wrap: wrap; gap: .45rem; }
    .sfwiz-tag input[type="checkbox"] { position: absolute; opacity: 0; pointer-events: none; }
    .sfwiz-tag-pill { display: inline-flex; align-items: center; padding: .3rem .78rem; border-radius: 999px; border: 1.5px solid var(--sand); background: var(--white); font-size: .8rem; color: var(--text-light); cursor: pointer; transition: all var(--ease); user-select: none; }
    .sfwiz-tag-pill:hover { border-color: var(--accent); color: var(--accent); }
    .sfwiz-tag input:checked + .sfwiz-tag-pill { background: var(--accent-pale); border-color: var(--accent); color: var(--accent); font-weight: 500; }

    .sfwiz-divider { border: none; border-top: 1px solid var(--sand); margin: 1.1rem 0; }

    /* Upload */
    .sfwiz-upload { border: 2px dashed var(--sand); border-radius: var(--r-lg); padding: 2rem 1.5rem; display: flex; flex-direction: column; align-items: center; gap: .6rem; text-align: center; cursor: pointer; background: var(--cream); transition: all var(--ease); }
    .sfwiz-upload:hover, .sfwiz-upload.dz { border-color: var(--accent); background: #fdf8f5; }
    .sfwiz-upload-icon { width: 50px; height: 50px; border-radius: 50%; background: var(--white); border: 1px solid var(--sand); display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-sm); }
    .sfwiz-upload-title { font-size: .86rem; font-weight: 500; color: var(--text); }
    .sfwiz-upload-title span { color: var(--accent); }
    .sfwiz-upload-hint { font-size: .72rem; color: var(--muted); font-weight: 300; }
    .sfwiz-prev-img { width: 100%; max-height: 230px; object-fit: cover; border-radius: var(--r-lg); border: 1px solid var(--sand); margin-top: .65rem; display: none; }
    .sfwiz-prev-rm { display: none; margin-top: .35rem; font-size: .72rem; color: var(--muted); background: none; border: none; cursor: pointer; font-family: var(--font-b); }
    .sfwiz-prev-rm:hover { color: var(--danger); }

    /* Publish toggle */
    .sfwiz-publish { display: flex; align-items: center; justify-content: space-between; gap: 1rem; background: var(--white); border: 1px solid var(--sand); border-radius: var(--r-xl); padding: 1.1rem 1.4rem; box-shadow: var(--shadow-sm); }
    .sfwiz-publish-info strong { display: flex; align-items: center; gap: .4rem; font-size: .87rem; font-weight: 500; color: var(--text-dark); margin-bottom: .15rem; }
    .sfwiz-publish-info p { font-size: .76rem; color: var(--muted); font-weight: 300; }
    .sfwiz-toggle { position: relative; width: 46px; height: 25px; flex-shrink: 0; }
    .sfwiz-toggle input { opacity: 0; width: 0; height: 0; position: absolute; }
    .sfwiz-toggle-track { position: absolute; inset: 0; background: var(--sand); border-radius: 999px; transition: background var(--ease); cursor: pointer; }
    .sfwiz-toggle-thumb { position: absolute; left: 3px; top: 3px; width: 19px; height: 19px; background: var(--white); border-radius: 50%; transition: transform var(--ease); box-shadow: 0 1px 4px rgba(0,0,0,.18); pointer-events: none; }
    .sfwiz-toggle input:checked ~ .sfwiz-toggle-track { background: var(--accent); }
    .sfwiz-toggle input:checked ~ .sfwiz-toggle-thumb { transform: translateX(21px); }

    /* Recap */
    .sfwiz-recap { display: flex; align-items: center; gap: 1.1rem; background: var(--white); border: 1px solid var(--sand); border-radius: var(--r-xl); padding: 1.1rem 1.4rem; box-shadow: var(--shadow-sm); margin-bottom: .85rem; }
    .sfwiz-recap-thumb { width: 68px; height: 68px; border-radius: 12px; background: var(--cream); border: 1px solid var(--sand); flex-shrink: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; }
    .sfwiz-recap-title { font-family: var(--font-d); font-size: 1.15rem; font-weight: 500; color: var(--text-dark); }
    .sfwiz-recap-cat { font-size: .76rem; color: var(--muted); margin-top: .12rem; }

    /* Footer */
    .sfwiz-footer { flex-shrink: 0; background: var(--white); border-top: 1px solid var(--sand); padding: .85rem 2.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
    .sfwiz-footer-left, .sfwiz-footer-right { display: flex; align-items: center; gap: .7rem; }
    .sfwiz-step-info { font-size: .74rem; color: var(--muted); font-weight: 300; }
    .sfwiz-step-info strong { font-weight: 600; color: var(--text); }

    .sfwiz-btn-back { display: inline-flex; align-items: center; gap: .38rem; padding: .62rem 1.3rem; background: transparent; color: var(--text-light); border: 1.5px solid var(--sand); border-radius: 999px; font-family: var(--font-b); font-size: .84rem; font-weight: 400; cursor: pointer; text-decoration: none; transition: all var(--ease); }
    .sfwiz-btn-back:hover { border-color: var(--sand-dark); color: var(--text); }
    .sfwiz-btn-next, .sfwiz-btn-submit { display: inline-flex; align-items: center; gap: .42rem; padding: .7rem 1.9rem; background: var(--accent); color: #fff; border: none; border-radius: 999px; font-family: var(--font-b); font-size: .86rem; font-weight: 600; cursor: pointer; transition: background var(--ease); box-shadow: 0 2px 10px rgba(184,74,28,.28); }
    .sfwiz-btn-next:hover, .sfwiz-btn-submit:hover { background: var(--accent-dark); }
    .sfwiz-btn-draft { background: none; border: none; font-family: var(--font-b); font-size: .78rem; color: var(--muted); cursor: pointer; text-decoration: underline; text-decoration-color: transparent; transition: all var(--ease); padding: 0; }
    .sfwiz-btn-draft:hover { color: var(--text); text-decoration-color: var(--sand-dark); }

    /* Server-side validation errors banner */
    .sfwiz-server-errors { background: #fff0ee; border: 1.5px solid #f5b8b0; border-radius: var(--r-md); padding: .9rem 1.2rem; font-size: .82rem; color: var(--danger); flex-shrink: 0; }
    .sfwiz-server-errors ul { padding-left: 1.2rem; margin-top: .3rem; }

    @keyframes sfShake { 0%,100%{transform:translateX(0)} 20%{transform:translateX(-6px)} 40%{transform:translateX(6px)} 60%{transform:translateX(-4px)} 80%{transform:translateX(4px)} }

    @media (max-width:560px) {
        .sfwiz-header { padding: 0 1rem; }
        .sfwiz-step-label { display: none; }
        .sfwiz-footer { padding: .85rem 1rem; }
        .sfwiz-slide { padding: 1.4rem .9rem 1.2rem; }
    }
    </style>
</head>
<body>
<div class="sfwiz" id="sfWizard">

    {{-- Header --}}
    <header class="sfwiz-header">
        <div class="sfwiz-logo">Saveur<span>.</span></div>

        <nav class="sfwiz-steps-nav">
            @foreach([1=>'Infos',2=>'Tags',3=>'Recette',4=>'Photo',5=>'Publication'] as $n => $lbl)
            <div class="sfwiz-step-item {{ $n === 1 ? 'is-active' : '' }}" data-step="{{ $n }}">
                <div class="sfwiz-step-dot">
                    <span class="num">{{ $n }}</span>
                    <svg class="check" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <span class="sfwiz-step-label">{{ $lbl }}</span>
            </div>
            @if($n < 5)<div class="sfwiz-step-line" data-line="{{ $n }}"></div>@endif
            @endforeach
        </nav>

        <a href="{{ route('home') }}" class="sfwiz-cancel">✕ Annuler</a>
    </header>

    {{-- Progress bar --}}
    <div class="sfwiz-progressbar">
        <div class="sfwiz-pb-fill" id="sfPBFill" style="width:20%"></div>
    </div>

    {{-- Erreurs serveur (validation Laravel) --}}
    @if($errors->any())
    <div class="sfwiz-server-errors">
        ⚠️ Veuillez corriger les erreurs suivantes :
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" novalidate id="sfForm" style="display:contents">
        @csrf

        <div class="sfwiz-body">
            <div class="sfwiz-slides" id="sfSlides">

                {{-- SLIDE 1 — Infos --}}
                <div class="sfwiz-slide" id="sfSlide1">
                    <div class="sfwiz-slide-inner">
                        <div class="sfwiz-step-head">
                            <div class="sfwiz-step-badge">Étape 1 sur 5</div>
                            <h2>Informations <em>de base</em></h2>
                            <p>Titre, catégorie et courte description de votre plat.</p>
                        </div>
                        <div class="sfwiz-card">
                            <div class="sfwiz-card-body">
                                <div class="sfwiz-field">
                                    <label class="sfwiz-label" for="title">Titre <span class="sfwiz-req">*</span></label>
                                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                                           placeholder="ex. Soupe à l'oignon gratinée" maxlength="120" data-required
                                           class="sfwiz-input {{ $errors->has('title') ? 'err' : '' }}"
                                           oninput="sfCtr('title',120)">
                                    <div style="display:flex;justify-content:space-between;align-items:center">
                                        @error('title')<span class="sfwiz-error">{{ $message }}</span>@else<span></span>@enderror
                                        <span class="sfwiz-counter" id="title-ctr">{{ strlen(old('title','')) }} / 120</span>
                                    </div>
                                </div>
                                <div class="sfwiz-field">
                                    <label class="sfwiz-label">Catégorie <span class="sfwiz-req">*</span></label>
                                    <select name="category_id" data-required class="sfwiz-select {{ $errors->has('category_id') ? 'err' : '' }}">
                                        <option value="">— Choisir une catégorie —</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')<span class="sfwiz-error">{{ $message }}</span>@enderror
                                </div>
                                <div class="sfwiz-field">
                                    <label class="sfwiz-label">Description <span class="sfwiz-label-hint">— facultatif</span></label>
                                    <textarea name="description" rows="3" maxlength="400"
                                              placeholder="Brève présentation, origine, ce qui rend ce plat spécial..."
                                              class="sfwiz-textarea"
                                              oninput="sfCtr('description',400)">{{ old('description') }}</textarea>
                                    <span class="sfwiz-counter" id="description-ctr" style="text-align:right">{{ strlen(old('description','')) }} / 400</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SLIDE 2 — Tags --}}
                <div class="sfwiz-slide" id="sfSlide2">
                    <div class="sfwiz-slide-inner">
                        <div class="sfwiz-step-head">
                            <div class="sfwiz-step-badge">Étape 2 sur 5</div>
                            <h2>Tags <em>&amp; thèmes</em></h2>
                            <p>Sélectionnez les tags qui correspondent le mieux à votre recette.</p>
                        </div>
                        <div class="sfwiz-card">
                            <div class="sfwiz-card-body">
                                @if($tags->isEmpty())
                                    <p style="font-size:.85rem;color:var(--muted)">Aucun tag disponible pour l'instant.</p>
                                @else
                                <div class="sfwiz-tags">
                                    @foreach ($tags as $tag)
                                    <label class="sfwiz-tag">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                               {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                        <span class="sfwiz-tag-pill">{{ $tag->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @endif
                                @error('tags')<div style="margin-top:.7rem"><span class="sfwiz-error">{{ $message }}</span></div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SLIDE 3 — Recette --}}
                <div class="sfwiz-slide" id="sfSlide3">
                    <div class="sfwiz-slide-inner">
                        <div class="sfwiz-step-head">
                            <div class="sfwiz-step-badge">Étape 3 sur 5</div>
                            <h2>Ingrédients <em>&amp; instructions</em></h2>
                            <p>Listez les ingrédients et décrivez les étapes de préparation.</p>
                        </div>
                        <div class="sfwiz-card">
                            <div class="sfwiz-card-body">
                                <div class="sfwiz-field">
                                    <label class="sfwiz-label">Ingrédients <span class="sfwiz-req">*</span> <span class="sfwiz-label-hint">— un par ligne</span></label>
                                    <textarea name="ingredients" rows="6" data-required
                                              placeholder="200 g de farine&#10;3 œufs entiers&#10;25 cl de lait entier&#10;..."
                                              class="sfwiz-textarea {{ $errors->has('ingredients') ? 'err' : '' }}">{{ old('ingredients') }}</textarea>
                                    @error('ingredients')<span class="sfwiz-error">{{ $message }}</span>@enderror
                                </div>
                                <hr class="sfwiz-divider">
                                <div class="sfwiz-field">
                                    <label class="sfwiz-label">Instructions <span class="sfwiz-req">*</span> <span class="sfwiz-label-hint">— une étape par ligne</span></label>
                                    <textarea name="steps" rows="6" data-required
                                              placeholder="Préchauffer le four à 180 °C.&#10;Dans un grand saladier, mélanger...&#10;..."
                                              class="sfwiz-textarea {{ $errors->has('steps') ? 'err' : '' }}">{{ old('steps') }}</textarea>
                                    @error('steps')<span class="sfwiz-error">{{ $message }}</span>@enderror
                                </div>
                                <hr class="sfwiz-divider">
                                <div class="sfwiz-grid-3">
                                    <div class="sfwiz-field">
                                        <label class="sfwiz-label">Préparation</label>
                                        <div class="sfwiz-unit-wrap">
                                            <input type="number" name="prep_time" value="{{ old('prep_time') }}" min="0" placeholder="15" class="sfwiz-input">
                                            <span class="sfwiz-unit">min</span>
                                        </div>
                                    </div>
                                    <div class="sfwiz-field">
                                        <label class="sfwiz-label">Cuisson</label>
                                        <div class="sfwiz-unit-wrap">
                                            <input type="number" name="cook_time" value="{{ old('cook_time') }}" min="0" placeholder="45" class="sfwiz-input">
                                            <span class="sfwiz-unit">min</span>
                                        </div>
                                    </div>
                                    <div class="sfwiz-field">
                                        <label class="sfwiz-label">Portions</label>
                                        <div class="sfwiz-unit-wrap">
                                            <input type="number" name="servings" value="{{ old('servings') }}" min="1" placeholder="4" class="sfwiz-input">
                                            <span class="sfwiz-unit">pers.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SLIDE 4 — Photo --}}
                <div class="sfwiz-slide" id="sfSlide4">
                    <div class="sfwiz-slide-inner">
                        <div class="sfwiz-step-head">
                            <div class="sfwiz-step-badge">Étape 4 sur 5</div>
                            <h2>Photo <em>du plat</em></h2>
                            <p>JPG, PNG ou WebP — max 5 Mo. Une belle image donne envie.</p>
                        </div>
                        <div class="sfwiz-card">
                            <div class="sfwiz-card-body">
                                <label class="sfwiz-upload" id="sfDZ" for="imageInput">
                                    <div class="sfwiz-upload-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#b84a1c" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    </div>
                                    <div class="sfwiz-upload-title"><span>Cliquer pour choisir</span> ou glisser-déposer</div>
                                    <div class="sfwiz-upload-hint">Résolution recommandée : 1200 × 800 px</div>
                                    <input type="file" name="image" id="imageInput" accept="image/*" style="display:none" onchange="sfPrevImg(this)">
                                </label>
                                <img id="sfPI" class="sfwiz-prev-img" src="" alt="">
                                <div style="text-align:right">
                                    <button type="button" class="sfwiz-prev-rm" id="sfRmBtn" onclick="sfRmImg()">✕ Supprimer</button>
                                </div>
                                @error('image')<div style="margin-top:.5rem"><span class="sfwiz-error">{{ $message }}</span></div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SLIDE 5 — Publication --}}
                <div class="sfwiz-slide" id="sfSlide5">
                    <div class="sfwiz-slide-inner">
                        <div class="sfwiz-step-head">
                            <div class="sfwiz-step-badge">Étape 5 sur 5</div>
                            <h2>Prêt à <em>publier&nbsp;?</em></h2>
                            <p>Publiez maintenant ou sauvegardez en brouillon pour plus tard.</p>
                        </div>
                        <div class="sfwiz-recap">
                            <div class="sfwiz-recap-thumb" id="sfRecapThumb">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#d0c5b4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <div>
                                <div class="sfwiz-recap-title" id="sfRecapTitle">Votre recette</div>
                                <div class="sfwiz-recap-cat" id="sfRecapCat">—</div>
                            </div>
                        </div>
                        <div class="sfwiz-publish">
                            <div class="sfwiz-publish-info">
                                <strong>✅ Publier maintenant</strong>
                                <p>Visible immédiatement pour la communauté.</p>
                            </div>
                            <label class="sfwiz-toggle">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                <span class="sfwiz-toggle-track"></span>
                                <span class="sfwiz-toggle-thumb"></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>{{-- /slides --}}
        </div>{{-- /body --}}

    </form>

    {{-- Footer (outside form, inside sfwiz flex) --}}
    <footer class="sfwiz-footer">
            <div class="sfwiz-footer-left">
                <button type="button" class="sfwiz-btn-back" id="sfBack" onclick="sfGo(-1)" style="display:none">← Précédent</button>
                <div class="sfwiz-step-info">
                    <strong id="sfStepLbl">Informations de base</strong>
                    <span id="sfStepCnt" style="opacity:.55"> — 1 / 5</span>
                </div>
            </div>
            <div class="sfwiz-footer-right">
                <button type="button" class="sfwiz-btn-draft" id="sfDraft">Enregistrer en brouillon</button>
                <button type="button" class="sfwiz-btn-next" id="sfNext" onclick="sfGo(1)">
                    Suivant →
                </button>
                <button type="button" class="sfwiz-btn-next" id="sfSubmit" style="display:none" onclick="document.getElementById('sfForm').submit()">
                    ✓ Enregistrer
                </button>
            </div>
        </footer>

</div>{{-- /sfwiz --}}

<script>
(function(){
    const TOTAL  = 5;
    const LABELS = ['Informations de base','Tags & thèmes','Ingrédients & instructions','Photo du plat','Publication'];
    let cur = 1;

    const slides  = document.getElementById('sfSlides');
    const pbFill  = document.getElementById('sfPBFill');
    const btnBack = document.getElementById('sfBack');
    const btnNext = document.getElementById('sfNext');
    const btnSub  = document.getElementById('sfSubmit');
    const btnDraft= document.getElementById('sfDraft');
    const lbl     = document.getElementById('sfStepLbl');
    const cnt     = document.getElementById('sfStepCnt');

    // Si erreur serveur, aller directement au bon slide
    @if($errors->any())
    if ({{ $errors->has('title') || $errors->has('category_id') || $errors->has('description') ? 1 : 0 }}) cur = 1;
    else if ({{ $errors->has('tags') ? 1 : 0 }}) cur = 2;
    else if ({{ $errors->has('ingredients') || $errors->has('steps') ? 1 : 0 }}) cur = 3;
    else if ({{ $errors->has('image') ? 1 : 0 }}) cur = 4;
    @endif

    function render() {
        slides.style.transform = `translateX(-${(cur-1)*100}%)`;
        pbFill.style.width = (cur/TOTAL*100) + '%';
        for (let i = 1; i <= TOTAL; i++) {
            const dot  = document.querySelector(`[data-step="${i}"]`);
            const line = document.querySelector(`[data-line="${i}"]`);
            if (dot) { dot.classList.toggle('is-active', i === cur); dot.classList.toggle('is-done', i < cur); }
            if (line) line.classList.toggle('is-done', i < cur);
        }
        btnBack.style.display   = cur > 1      ? 'inline-flex' : 'none';
        btnNext.style.display   = cur < TOTAL  ? 'inline-flex' : 'none';
        btnSub.style.display    = cur === TOTAL ? 'inline-flex' : 'none';
        lbl.textContent = LABELS[cur-1];
        cnt.textContent = ' — ' + cur + ' / ' + TOTAL;
        if (cur === TOTAL) sfRecap();
    }

    window.sfGo = function(dir) {
        if (dir === 1 && !sfValidate(cur)) return;
        const nx = cur + dir;
        if (nx < 1 || nx > TOTAL) return;
        cur = nx;
        render();
        const sl = document.getElementById('sfSlide' + cur);
        if (sl) sl.scrollTop = 0;
    };

    function sfValidate(step) {
        let ok = true;
        const slide = document.getElementById('sfSlide' + step);
        if (!slide) return true;
        slide.querySelectorAll('[data-required]').forEach(el => {
            if (!el.value.trim()) {
                ok = false;
                el.classList.add('err');
                el.style.animation = 'none';
                void el.offsetWidth;
                el.style.animation = 'sfShake .35s';
                el.addEventListener('input', () => el.classList.remove('err'), {once:true});
            }
        });
        return ok;
    }

    function sfRecap() {
        const t = document.getElementById('title')?.value || 'Votre recette';
        const catEl = document.querySelector('[name="category_id"]');
        const cat   = catEl ? catEl.options[catEl.selectedIndex]?.text : '—';
        document.getElementById('sfRecapTitle').textContent = t;
        document.getElementById('sfRecapCat').textContent   = (cat && cat !== '— Choisir une catégorie —') ? cat : '—';
        const imgEl = document.getElementById('sfPI');
        const thumb = document.getElementById('sfRecapThumb');
        if (imgEl && imgEl.src && imgEl.style.display !== 'none') {
            thumb.innerHTML = `<img src="${imgEl.src}" style="width:100%;height:100%;object-fit:cover">`;
        }
    }

    btnDraft.addEventListener('click', () => {
        const h = document.createElement('input');
        h.type='hidden'; h.name='draft'; h.value='1';
        document.getElementById('sfForm').appendChild(h);
        document.getElementById('sfForm').submit();
    });

    render();
})();

function sfCtr(id, max) {
    const el = document.getElementById(id) || document.querySelector(`[name="${id}"]`);
    const ct = document.getElementById(id + '-ctr');
    if (!el || !ct) return;
    const n = el.value.length;
    ct.textContent = n + ' / ' + max;
    ct.style.color = n > max*.88 ? '#b84a1c' : '#9a8e7e';
}

function sfPrevImg(inp) {
    if (!inp.files?.[0]) return;
    if (inp.files[0].size > 5*1024*1024) { alert('La photo dépasse 5 Mo.'); inp.value=''; return; }
    const r = new FileReader();
    r.onload = e => {
        const img = document.getElementById('sfPI');
        const btn = document.getElementById('sfRmBtn');
        img.src = e.target.result; img.style.display = 'block';
        btn.style.display = 'inline-flex';
        document.getElementById('sfDZ').style.display = 'none';
    };
    r.readAsDataURL(inp.files[0]);
}

function sfRmImg() {
    document.getElementById('imageInput').value = '';
    const img = document.getElementById('sfPI');
    img.src = ''; img.style.display = 'none';
    document.getElementById('sfRmBtn').style.display = 'none';
    document.getElementById('sfDZ').style.display = 'flex';
}

const dz = document.getElementById('sfDZ');
if (dz) {
    ['dragenter','dragover'].forEach(e=>dz.addEventListener(e,ev=>{ev.preventDefault();dz.classList.add('dz');}));
    ['dragleave','drop'].forEach(e=>dz.addEventListener(e,ev=>{ev.preventDefault();dz.classList.remove('dz');}));
    dz.addEventListener('drop',e=>{
        const f=e.dataTransfer?.files?.[0];
        if(f&&f.type.startsWith('image/')){
            const inp=document.getElementById('imageInput');
            const dt=new DataTransfer(); dt.items.add(f); inp.files=dt.files;
            sfPrevImg(inp);
        }
    });
}
</script>
</body>
</html>

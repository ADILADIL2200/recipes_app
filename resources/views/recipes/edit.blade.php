<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <title>Edit — {{ $recipe->title }} — Saveur</title>
 <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
 <style>
 *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

 :root {
 --bg: #f9f6f1;
 --surface: #ffffff;
 --ink: #18140e;
 --ink-2: #5a4e3c;
 --ink-3: #9a8e7e;
 --accent: #b84a1c;
 --accent-lt: #f5ede7;
 --gold: #c8972a;
 --sage: #3d5c36;
 --border: #e8e0d4;
 --r-sm: 8px;
 --r-md: 14px;
 --r-lg: 22px;
 --danger: #c0392b;
 }

 body {
 font-family: 'Outfit', sans-serif;
 background: var(--bg);
 color: var(--ink);
 min-height: 100vh;
 -webkit-font-smoothing: antialiased;
 }

 /* ── FLASH ── */
 .flash {
 background: var(--sage); color: #fff;
 text-align: center; padding: .6rem 1rem;
 font-size: .85rem; letter-spacing: .02em;
 }
 .flash-error { background: var(--danger); }

 /* ── NAV ── */
 nav {
 position: sticky; top: 0; z-index: 200;
 background: rgba(249,246,241,0.92);
 backdrop-filter: blur(12px);
 border-bottom: 1px solid var(--border);
 display: flex; align-items: center; justify-content: space-between;
 padding: 0 2.5rem; height: 68px;
 }
 .nav-brand {
 font-family: 'Cormorant Garamond', serif;
 font-size: 1.9rem; font-weight: 600;
 color: var(--accent); text-decoration: none;
 }
 .nav-links { display: flex; align-items: center; gap: 1.8rem; }
 .nav-links a {
 text-decoration: none; color: var(--ink-2);
 font-size: .9rem; font-weight: 500; transition: color .2s;
 }
 .nav-links a:hover { color: var(--accent); }
 .btn {
 display: inline-flex; align-items: center; gap: .4rem;
 text-decoration: none; padding: .5rem 1.25rem;
 border-radius: 999px; font-family: 'Outfit', sans-serif;
 font-size: .85rem; font-weight: 500;
 cursor: pointer; border: 1.5px solid transparent;
 transition: all .18s; white-space: nowrap;
 }
 .btn-primary { background: var(--accent); color: #fff; border-color: var(--accent); }
 .btn-primary:hover { background: #9e3a12; }
 .btn-outline { background: transparent; color: var(--accent); border-color: var(--accent); }
 .btn-outline:hover { background: var(--accent); color: #fff; }
 .btn-ghost { background: var(--surface); color: var(--ink-2); border-color: var(--border); }
 .btn-ghost:hover { border-color: var(--ink-3); color: var(--ink); }

 /* ── PAGE HEADER ── */
 .page-header {
 background: linear-gradient(135deg, #ecdec8 0%, #d4b896 100%);
 padding: 3rem 2.5rem 2.5rem;
 border-bottom: 1px solid var(--border);
 }
 .page-header-inner {
 max-width: 860px; margin: 0 auto;
 }
 .page-header .breadcrumb {
 display: flex; align-items: center; gap: .5rem;
 font-size: .8rem; color: var(--ink-2);
 margin-bottom: 1rem; padding: 0;
 }
 .page-header .breadcrumb a { text-decoration: none; color: var(--ink-2); }
 .page-header .breadcrumb a:hover { color: var(--accent); }
 .page-header h1 {
 font-family: 'Cormorant Garamond', serif;
 font-size: clamp(1.8rem, 4vw, 2.6rem);
 font-weight: 600; color: var(--ink); line-height: 1.15;
 }
 .page-header p {
 font-size: .9rem; color: var(--ink-2); margin-top: .5rem;
 }

 /* ── MAIN FORM LAYOUT ── */
 .form-wrap {
 max-width: 860px; margin: 0 auto;
 padding: 2.5rem 2.5rem 5rem;
 }

 /* ── FORM CARD ── */
 .form-card {
 background: var(--surface);
 border: 1px solid var(--border);
 border-radius: var(--r-lg);
 overflow: hidden;
 margin-bottom: 1.5rem;
 }
 .form-card-head {
 padding: 1rem 1.5rem;
 border-bottom: 1px solid var(--border);
 background: #faf7f3;
 display: flex; align-items: center; gap: .6rem;
 font-family: 'Cormorant Garamond', serif;
 font-size: 1.15rem; font-weight: 600; color: var(--ink);
 }
 .form-card-body { padding: 1.5rem; }

 /* ── FORM FIELDS ── */
 .field { margin-bottom: 1.25rem; }
 .field:last-child { margin-bottom: 0; }
 label.field-label {
 display: block;
 font-size: .8rem; font-weight: 600;
 text-transform: uppercase; letter-spacing: .06em;
 color: var(--ink-3); margin-bottom: .45rem;
 }
 .field-hint {
 font-size: .75rem; color: var(--ink-3); margin-top: .3rem;
 }
 input[type="text"],
 input[type="number"],
 select,
 textarea {
 width: 100%;
 background: var(--bg);
 border: 1.5px solid var(--border);
 border-radius: var(--r-sm);
 padding: .65rem .9rem;
 font-family: 'Outfit', sans-serif;
 font-size: .9rem; color: var(--ink);
 transition: border-color .18s;
 outline: none;
 }
 input:focus, select:focus, textarea:focus {
 border-color: var(--accent);
 background: var(--surface);
 }
 textarea { resize: vertical; line-height: 1.6; }
 .field-error {
 margin-top: .35rem; font-size: .78rem; color: var(--danger);
 }
 input.is-error, select.is-error, textarea.is-error {
 border-color: var(--danger);
 }

 /* grid for time fields */
 .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }

 /* ── TAGS ── */
 .tags-grid {
 display: flex; flex-wrap: wrap; gap: .6rem;
 }
 .tag-check {
 display: none;
 }
 .tag-label {
 display: inline-flex; align-items: center;
 padding: .35rem .9rem;
 border: 1.5px solid var(--border);
 border-radius: 999px;
 font-size: .82rem; font-weight: 500;
 color: var(--ink-2); background: var(--bg);
 cursor: pointer; transition: all .18s;
 user-select: none;
 }
 .tag-label:hover {
 border-color: var(--gold); color: var(--ink);
 }
 .tag-check:checked + .tag-label {
 background: var(--gold);
 border-color: var(--gold);
 color: #fff;
 }

 /* ── IMAGE PREVIEW ── */
 .img-current {
 display: flex; align-items: center; gap: 1rem;
 padding: .75rem 1rem;
 background: var(--bg);
 border: 1px solid var(--border);
 border-radius: var(--r-sm);
 margin-bottom: .75rem;
 }
 .img-current img {
 width: 80px; height: 56px;
 object-fit: cover; border-radius: var(--r-sm);
 }
 .img-current p { font-size: .8rem; color: var(--ink-3); }
 .img-current strong { color: var(--ink-2); font-size: .85rem; }

 /* ── PUBLISH TOGGLE ── */
 .publish-row {
 display: flex; align-items: center; gap: .85rem;
 padding: 1rem 1.5rem;
 background: var(--bg);
 border-top: 1px solid var(--border);
 }
 .toggle-wrap {
 position: relative; width: 44px; height: 24px; flex-shrink: 0;
 }
 .toggle-input { display: none; }
 .toggle-track {
 display: block; width: 100%; height: 100%;
 background: var(--border); border-radius: 999px;
 cursor: pointer; transition: background .2s;
 }
 .toggle-track::after {
 content: ''; position: absolute;
 top: 3px; left: 3px;
 width: 18px; height: 18px;
 background: #fff; border-radius: 50%;
 transition: transform .2s;
 box-shadow: 0 1px 4px rgba(0,0,0,.15);
 }
 .toggle-input:checked + .toggle-track { background: var(--sage); }
 .toggle-input:checked + .toggle-track::after { transform: translateX(20px); }
 .publish-label { font-size: .9rem; color: var(--ink-2); }
 .publish-label strong { color: var(--ink); }

 /* ── ACTION BAR ── */
 .action-bar {
 display: flex; align-items: center; justify-content: space-between;
 gap: 1rem; flex-wrap: wrap;
 padding: 1.25rem 1.5rem;
 background: var(--surface);
 border: 1px solid var(--border);
 border-radius: var(--r-lg);
 }
 .action-bar-left { display: flex; gap: .75rem; align-items: center; }

 /* ── ERRORS SUMMARY ── */
 .error-summary {
 background: #fdf2f2;
 border: 1px solid #f5c6c6;
 border-radius: var(--r-md);
 padding: 1rem 1.25rem;
 margin-bottom: 1.5rem;
 }
 .error-summary p {
 font-size: .85rem; font-weight: 600;
 color: var(--danger); margin-bottom: .5rem;
 }
 .error-summary ul { list-style: none; }
 .error-summary li {
 font-size: .82rem; color: var(--danger);
 padding: .15rem 0;
 }
 .error-summary li::before { content: '· '; }

 /* ── FOOTER ── */
 footer {
 border-top: 1px solid var(--border);
 text-align: center; padding: 2rem;
 color: var(--ink-3); font-size: .82rem;
 }
 footer a { color: var(--accent); text-decoration: none; }

 /* ── RESPONSIVE ── */
 @media (max-width: 700px) {
 nav { padding: 0 1.25rem; }
 .page-header { padding: 2rem 1.25rem 1.5rem; }
 .form-wrap { padding: 1.5rem 1.25rem 3rem; }
 .grid-3 { grid-template-columns: 1fr 1fr; }
 }
 </style>
</head>
<body>

{{-- ── FLASH ── --}}
@if(session('success'))
 <div class="flash">{{ session('success') }}</div>
@endif
@if(session('error'))
 <div class="flash flash-error">{{ session('error') }}</div>
@endif

{{-- ── NAV ── --}}
<nav>
 <a href="{{ route('home') }}" class="nav-brand">Saveur</a>
 <div class="nav-links">
 <a href="{{ route('recipes.index') }}">Recipes</a>
 <a href="{{ route('recipes.search') }}">Browse</a>
 @auth
 <a href="{{ route('recipes.my') }}">My Recipes</a>
 <a href="{{ route('recipes.create') }}" class="btn btn-primary">+ New Recipe</a>
 <form method="POST" action="{{ route('logout') }}" style="display:inline">
 @csrf
 <button type="submit" class="btn btn-ghost">Log out</button>
 </form>
 @else
 <a href="{{ route('login') }}" class="btn btn-outline">Log in</a>
 <a href="{{ route('signup') }}" class="btn btn-primary">Join free</a>
 @endauth
 </div>
</nav>

{{-- ── PAGE HEADER ── --}}
<div class="page-header">
 <div class="page-header-inner">
 <div class="breadcrumb">
 <a href="{{ route('home') }}">Home</a>
 <span>/</span>
 <a href="{{ route('recipes.my') }}">My Recipes</a>
 <span>/</span>
 <a href="{{ route('recipes.show', $recipe) }}">{{ Str::limit($recipe->title, 35) }}</a>
 <span>/</span>
 <span>Edit</span>
 </div>
 <h1>️ Edit Recipe</h1>
 <p>Update the details of <strong>{{ $recipe->title }}</strong></p>
 </div>
</div>

{{-- ── FORM ── --}}
<div class="form-wrap">

 {{-- Validation errors --}}
 @if($errors->any())
 <div class="error-summary">
 <p>Please fix the following errors:</p>
 <ul>
 @foreach($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 </div>
 @endif

 <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data">
 @csrf
 @method('PUT')

 {{-- ── BASIC INFO ── --}}
 <div class="form-card">
 <div class="form-card-head"> Basic Information</div>
 <div class="form-card-body">

 <div class="field">
 <label class="field-label" for="title">Title *</label>
 <input type="text" id="title" name="title"
 value="{{ old('title', $recipe->title) }}"
 class="{{ $errors->has('title') ? 'is-error' : '' }}"
 placeholder="Give your recipe a great name…">
 @error('title') <div class="field-error">{{ $message }}</div> @enderror
 </div>

 <div class="field">
 <label class="field-label" for="category_id">Category *</label>
 <select id="category_id" name="category_id"
 class="{{ $errors->has('category_id') ? 'is-error' : '' }}">
 <option value="">— Select a category —</option>
 @foreach($categories as $category)
 <option value="{{ $category->id }}"
 {{ old('category_id', $recipe->category_id) == $category->id ? 'selected' : '' }}>
 {{ $category->name }}
 </option>
 @endforeach
 </select>
 @error('category_id') <div class="field-error">{{ $message }}</div> @enderror
 </div>

 <div class="field">
 <label class="field-label" for="description">Description</label>
 <textarea id="description" name="description" rows="3"
 placeholder="A short introduction to your recipe…">{{ old('description', $recipe->description) }}</textarea>
 </div>

 </div>
 </div>

 {{-- ── TAGS ── --}}
 <div class="form-card">
 <div class="form-card-head">️ Tags</div>
 <div class="form-card-body">
 <div class="tags-grid">
 @foreach($tags as $tag)
 <input type="checkbox" class="tag-check"
 id="tag_{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}"
 {{ in_array($tag->id, old('tags', $recipe->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
 <label class="tag-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
 @endforeach
 </div>
 @error('tags') <div class="field-error" style="margin-top:.5rem">{{ $message }}</div> @enderror
 </div>
 </div>

 {{-- ── RECIPE CONTENT ── --}}
 <div class="form-card">
 <div class="form-card-head"> Recipe Content</div>
 <div class="form-card-body">

 <div class="field">
 <label class="field-label" for="ingredients">Ingredients *</label>
 <textarea id="ingredients" name="ingredients" rows="7"
 class="{{ $errors->has('ingredients') ? 'is-error' : '' }}"
 placeholder="One ingredient per line&#10;e.g. 2 cups flour&#10;1 tsp salt">{{ old('ingredients', $recipe->ingredients) }}</textarea>
 <div class="field-hint">One ingredient per line.</div>
 @error('ingredients') <div class="field-error">{{ $message }}</div> @enderror
 </div>

 <div class="field">
 <label class="field-label" for="steps">Instructions *</label>
 <textarea id="steps" name="steps" rows="9"
 class="{{ $errors->has('steps') ? 'is-error' : '' }}"
 placeholder="Step 1: Preheat oven to 180°C…&#10;Step 2: …">{{ old('steps', $recipe->steps) }}</textarea>
 <div class="field-hint">One step per line.</div>
 @error('steps') <div class="field-error">{{ $message }}</div> @enderror
 </div>

 </div>
 </div>

 {{-- ── TIMINGS ── --}}
 <div class="form-card">
 <div class="form-card-head">⏱️ Timings & Servings</div>
 <div class="form-card-body">
 <div class="grid-3">
 <div class="field">
 <label class="field-label" for="prep_time">Prep Time (min)</label>
 <input type="number" id="prep_time" name="prep_time" min="0"
 value="{{ old('prep_time', $recipe->prep_time) }}"
 placeholder="15">
 @error('prep_time') <div class="field-error">{{ $message }}</div> @enderror
 </div>
 <div class="field">
 <label class="field-label" for="cook_time">Cook Time (min)</label>
 <input type="number" id="cook_time" name="cook_time" min="0"
 value="{{ old('cook_time', $recipe->cook_time) }}"
 placeholder="30">
 @error('cook_time') <div class="field-error">{{ $message }}</div> @enderror
 </div>
 <div class="field">
 <label class="field-label" for="servings">Servings</label>
 <input type="number" id="servings" name="servings" min="1"
 value="{{ old('servings', $recipe->servings) }}"
 placeholder="4">
 @error('servings') <div class="field-error">{{ $message }}</div> @enderror
 </div>
 </div>
 </div>
 </div>

 {{-- ── IMAGE ── --}}
 <div class="form-card">
 <div class="form-card-head">️ Recipe Photo</div>
 <div class="form-card-body">
 @if($recipe->image)
 <div class="img-current">
 <img src="{{ asset('storage/' . $recipe->image) }}" alt="Current image">
 <div>
 <strong>Current photo</strong>
 <p>Upload a new image below to replace it.</p>
 </div>
 </div>
 @endif
 <div class="field">
 <label class="field-label" for="image">{{ $recipe->image ? 'Replace Image' : 'Upload Image' }}</label>
 <input type="file" id="image" name="image" accept="image/jpg,image/jpeg,image/png,image/webp"
 class="{{ $errors->has('image') ? 'is-error' : '' }}">
 <div class="field-hint">JPG, PNG or WebP — max 2 MB.</div>
 @error('image') <div class="field-error">{{ $message }}</div> @enderror
 </div>
 </div>

 {{-- Publish toggle --}}
 <div class="publish-row">
 <div class="toggle-wrap">
 <input type="checkbox" class="toggle-input" id="is_published" name="is_published"
 value="1" {{ old('is_published', $recipe->is_published) ? 'checked' : '' }}>
 <label class="toggle-track" for="is_published"></label>
 </div>
 <label class="publish-label" for="is_published">
 <strong>Publish this recipe</strong> — visible to everyone
 </label>
 </div>
 </div>

 {{-- ── ACTION BAR ── --}}
 <div class="action-bar">
 <div class="action-bar-left">
 <button type="submit" class="btn btn-primary"> Save Changes</button>
 <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-ghost">Cancel</a>
 </div>
 </div>

 </form>

 {{-- ️ DELETE form OUTSIDE the main form — nested forms are invalid HTML --}}
 <form method="POST" action="{{ route('recipes.destroy', $recipe) }}"
 style="display:flex;justify-content:flex-end;margin-top:.75rem"
 onsubmit="return confirm('Delete \'{{ addslashes($recipe->title) }}\'? This cannot be undone.')">
 @csrf
 @method('DELETE')
 <button type="submit" class="btn btn-ghost"
 style="color:var(--danger);border-color:var(--danger)">
 Delete Recipe
 </button>
 </form>
</div>

<footer>
 <p>© {{ date('Y') }} <a href="{{ route('home') }}">Saveur</a> — made with ️ for home cooks everywhere.</p>
</footer>

</body>
</html>

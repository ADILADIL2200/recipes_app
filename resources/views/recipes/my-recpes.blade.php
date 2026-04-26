<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Recipes — Saveur</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #f9f6f1;
            --surface:   #ffffff;
            --ink:       #18140e;
            --ink-2:     #5a4e3c;
            --ink-3:     #9a8e7e;
            --accent:    #b84a1c;
            --accent-lt: #f5ede7;
            --gold:      #c8972a;
            --sage:      #3d5c36;
            --sage-lt:   #eaf2e8;
            --danger:    #c0392b;
            --danger-lt: #fdf0ef;
            --border:    #e8e0d4;
            --r-sm:      8px;
            --r-md:      14px;
            --r-lg:      22px;
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
            background: var(--sage);
            color: #fff;
            text-align: center;
            padding: .6rem 1rem;
            font-size: .85rem;
            letter-spacing: .02em;
        }
        .flash-error { background: var(--danger); }

        /* ── NAV ── */
        nav {
            position: sticky; top: 0; z-index: 200;
            background: rgba(249,246,241,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2.5rem;
            height: 68px;
        }
        .nav-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.9rem; font-weight: 600;
            color: var(--accent); text-decoration: none;
        }
        .nav-links { display: flex; align-items: center; gap: 1.8rem; }
        .nav-links a {
            text-decoration: none; color: var(--ink-2);
            font-size: .9rem; font-weight: 500;
            transition: color .2s;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--accent); }
        .btn {
            display: inline-flex; align-items: center; gap: .4rem;
            text-decoration: none; padding: .5rem 1.25rem;
            border-radius: 999px; font-family: 'Outfit', sans-serif;
            font-size: .85rem; font-weight: 500;
            cursor: pointer; border: 1.5px solid transparent;
            transition: all .18s; white-space: nowrap;
        }
        .btn-primary   { background: var(--accent); color: #fff; border-color: var(--accent); }
        .btn-primary:hover { background: #9e3a12; border-color: #9e3a12; }
        .btn-outline   { background: transparent; color: var(--accent); border-color: var(--accent); }
        .btn-outline:hover { background: var(--accent); color: #fff; }
        .btn-ghost     { background: var(--surface); color: var(--ink-2); border-color: var(--border); }
        .btn-ghost:hover { border-color: var(--ink-3); color: var(--ink); }
        .btn-danger    { background: transparent; color: var(--danger); border-color: var(--danger); font-size: .78rem; padding: .35rem .9rem; }
        .btn-danger:hover { background: var(--danger); color: #fff; }
        .btn-sm        { font-size: .78rem; padding: .35rem .9rem; }

        /* ── PAGE HEADER ── */
        .page-header {
            max-width: 1180px;
            margin: 0 auto;
            padding: 3.5rem 2.5rem 0;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .page-header-left .eyebrow {
            display: inline-flex; align-items: center; gap: .45rem;
            background: var(--accent-lt); color: var(--accent);
            font-size: .72rem; font-weight: 600;
            letter-spacing: .08em; text-transform: uppercase;
            padding: .3rem .8rem; border-radius: 999px;
            margin-bottom: 1rem;
        }
        .page-header-left .eyebrow::before {
            content: '';
            width: 5px; height: 5px;
            background: var(--accent); border-radius: 50%;
        }
        .page-header h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 600; line-height: 1.1;
            color: var(--ink);
        }
        .page-header h1 span { color: var(--accent); font-style: italic; }
        .page-header p {
            color: var(--ink-3); font-size: .9rem;
            margin-top: .5rem; font-weight: 300;
        }

        /* ── STATS BAR ── */
        .stats-bar {
            max-width: 1180px;
            margin: 2rem auto 0;
            padding: 0 2.5rem;
            display: flex;
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            overflow: hidden;
        }
        .stat-cell {
            flex: 1;
            background: var(--surface);
            padding: 1.1rem 1.4rem;
            display: flex; align-items: center; gap: .9rem;
        }
        .stat-cell-icon {
            width: 38px; height: 38px;
            border-radius: var(--r-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; flex-shrink: 0;
        }
        .stat-cell-icon.orange { background: var(--accent-lt); }
        .stat-cell-icon.green  { background: var(--sage-lt); }
        .stat-cell-icon.gold   { background: #fef6e4; }
        .stat-cell .num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem; font-weight: 600;
            color: var(--ink); line-height: 1;
        }
        .stat-cell .lbl {
            font-size: .7rem; font-weight: 500;
            text-transform: uppercase; letter-spacing: .06em;
            color: var(--ink-3); margin-top: .2rem;
        }

        /* ── FILTER BAR ── */
        .filter-bar {
            max-width: 1180px;
            margin: 2rem auto 0;
            padding: 0 2.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .filter-tabs {
            display: flex;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .25rem;
            gap: .2rem;
        }
        .filter-tab {
            padding: .4rem 1rem;
            border-radius: 999px;
            font-size: .82rem;
            font-weight: 500;
            color: var(--ink-3);
            text-decoration: none;
            transition: all .18s;
            border: none; background: none; cursor: pointer;
        }
        .filter-tab.active, .filter-tab:hover {
            background: var(--accent);
            color: #fff;
        }
        .filter-bar-right { margin-left: auto; }

        /* ── RECIPE GRID ── */
        .content-wrap {
            max-width: 1180px;
            margin: 2rem auto 0;
            padding: 0 2.5rem 4rem;
        }
        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 1.4rem;
        }

        /* ── RECIPE CARD ── */
        .recipe-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            overflow: hidden;
            display: flex; flex-direction: column;
            transition: transform .2s, box-shadow .2s;
        }
        .recipe-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0,0,0,.07);
        }
        .card-img-wrap {
            aspect-ratio: 16/10;
            background: linear-gradient(135deg, #ecdec8, #d9c0a0);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem; overflow: hidden; position: relative;
        }
        .card-img-wrap img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform .3s;
        }
        .recipe-card:hover .card-img-wrap img { transform: scale(1.04); }

        .card-badges {
            position: absolute; top: .65rem; left: .65rem;
            display: flex; gap: .4rem; flex-wrap: wrap;
        }
        .badge {
            font-size: .65rem; font-weight: 600;
            letter-spacing: .05em; text-transform: uppercase;
            padding: .22rem .65rem; border-radius: 999px;
        }
        .badge-cat   { background: var(--accent); color: #fff; }
        .badge-pub   { background: var(--sage);   color: #fff; }
        .badge-draft { background: rgba(0,0,0,.55); color: rgba(255,255,255,.85); }

        .card-body {
            padding: 1rem 1.15rem;
            flex: 1; display: flex; flex-direction: column;
        }
        .card-body h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem; font-weight: 600;
            line-height: 1.3; color: var(--ink);
            margin-bottom: .4rem;
            text-decoration: none;
        }
        .card-body h3 a { text-decoration: none; color: inherit; }
        .card-body h3 a:hover { color: var(--accent); }

        .card-desc {
            font-size: .82rem; color: var(--ink-3);
            line-height: 1.55; font-weight: 300;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: .75rem;
        }

        .card-meta {
            display: flex; gap: .8rem;
            font-size: .75rem; color: var(--ink-3);
            padding-top: .75rem;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }
        .card-meta span { display: flex; align-items: center; gap: .25rem; }
        .stars { color: var(--gold); }

        .card-tags {
            display: flex; flex-wrap: wrap; gap: .35rem;
            margin-bottom: .75rem;
        }
        .tag-chip {
            font-size: .68rem; font-weight: 500;
            color: var(--ink-3);
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .18rem .6rem;
        }

        /* ── CARD ACTIONS ── */
        .card-actions {
            display: flex; gap: .5rem;
            padding: .85rem 1.15rem;
            border-top: 1px solid var(--border);
            background: rgba(249,246,241,.6);
        }
        .card-actions .btn-sm { flex: 1; justify-content: center; text-align: center; }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            border: 2px dashed var(--border);
            border-radius: var(--r-lg);
        }
        .empty-icon {
            font-size: 3.5rem;
            margin-bottom: 1.2rem;
            opacity: .4;
        }
        .empty-state h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem; font-weight: 600;
            color: var(--ink); margin-bottom: .5rem;
        }
        .empty-state p {
            color: var(--ink-3); font-size: .9rem;
            font-weight: 300; margin-bottom: 1.8rem;
        }

        /* ── PAGINATION ── */
        .pagination-wrap {
            margin-top: 2.5rem;
            display: flex; justify-content: center;
        }
        .pagination-wrap nav { display: flex; align-items: center; gap: .4rem; }
        .pagination-wrap .page-link {
            display: inline-flex; align-items: center; justify-content: center;
            width: 38px; height: 38px;
            border-radius: var(--r-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--ink-2); font-size: .85rem;
            text-decoration: none; transition: all .18s;
        }
        .pagination-wrap .page-link:hover { border-color: var(--accent); color: var(--accent); }
        .pagination-wrap .page-link.active { background: var(--accent); border-color: var(--accent); color: #fff; }
        .pagination-wrap .page-link.disabled { opacity: .35; pointer-events: none; }

        /* ── RESPONSIVE ── */
        @media (max-width: 800px) {
            nav { padding: 0 1.25rem; }
            .page-header { padding: 2rem 1.25rem 0; flex-direction: column; align-items: flex-start; }
            .stats-bar { margin: 1.5rem 1.25rem 0; padding: 0; flex-wrap: wrap; }
            .stat-cell { min-width: 140px; }
            .filter-bar { padding: 0 1.25rem; }
            .content-wrap { padding: 0 1.25rem 3rem; }
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
        <a href="{{ route('recipes.my') }}" class="active">My Recipes</a>
        <a href="{{ route('recipes.create') }}" class="btn btn-primary">+ New Recipe</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn btn-ghost">Log out</button>
        </form>
    </div>
</nav>

{{-- ── PAGE HEADER ── --}}
<div class="page-header">
    <div class="page-header-left">
        <div class="eyebrow">My kitchen</div>
        <h1>Your <span>recipes</span></h1>
        <p>Everything you've created, all in one place.</p>
    </div>
    <a href="{{ route('recipes.create') }}" class="btn btn-primary">+ New Recipe</a>
</div>

{{-- ── STATS BAR ── --}}
<div style="max-width:1180px;margin:2rem auto 0;padding:0 2.5rem">
    <div class="stats-bar" style="margin:0;padding:0">
        <div class="stat-cell">
            <div class="stat-cell-icon orange">📄</div>
            <div>
                <div class="num">{{ $recipes->total() }}</div>
                <div class="lbl">Total recipes</div>
            </div>
        </div>
        <div class="stat-cell">
            <div class="stat-cell-icon green">✅</div>
            <div>
                <div class="num">{{ $recipes->getCollection()->where('is_published', true)->count() }}</div>
                <div class="lbl">Published</div>
            </div>
        </div>
        <div class="stat-cell">
            <div class="stat-cell-icon gold">✏️</div>
            <div>
                <div class="num">{{ $recipes->getCollection()->where('is_published', false)->count() }}</div>
                <div class="lbl">Drafts</div>
            </div>
        </div>
    </div>
</div>

{{-- ── FILTER BAR ── --}}
<div class="filter-bar">
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterCards('all')">All</button>
        <button class="filter-tab" onclick="filterCards('published')">Published</button>
        <button class="filter-tab" onclick="filterCards('draft')">Drafts</button>
    </div>
    <div class="filter-bar-right">
        <a href="{{ route('recipes.create') }}" class="btn btn-outline btn-sm">+ New Recipe</a>
    </div>
</div>

{{-- ── RECIPE GRID ── --}}
<div class="content-wrap">
    @if($recipes->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🍳</div>
            <h2>No recipes yet</h2>
            <p>You haven't created any recipes. Share your first dish with the world!</p>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary">Create your first recipe</a>
        </div>
    @else
        <div class="recipe-grid" id="recipeGrid">
            @foreach($recipes as $recipe)
            <div class="recipe-card" data-status="{{ $recipe->is_published ? 'published' : 'draft' }}">

                {{-- Image --}}
                <div class="card-img-wrap">
                    @if($recipe->image)
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" />
                    @else
                        🍽️
                    @endif
                    <div class="card-badges">
                        @if($recipe->category)
                            <span class="badge badge-cat">{{ $recipe->category->name }}</span>
                        @endif
                        @if($recipe->is_published)
                            <span class="badge badge-pub">Published</span>
                        @else
                            <span class="badge badge-draft">Draft</span>
                        @endif
                    </div>
                </div>

                {{-- Body --}}
                <div class="card-body">
                    <h3><a href="{{ route('recipes.show', $recipe) }}">{{ $recipe->title }}</a></h3>

                    @if($recipe->description)
                        <p class="card-desc">{{ $recipe->description }}</p>
                    @endif

                    @if($recipe->tags->isNotEmpty())
                        <div class="card-tags">
                            @foreach($recipe->tags->take(3) as $tag)
                                <span class="tag-chip">#{{ $tag->name }}</span>
                            @endforeach
                            @if($recipe->tags->count() > 3)
                                <span class="tag-chip">+{{ $recipe->tags->count() - 3 }}</span>
                            @endif
                        </div>
                    @endif

                    <div class="card-meta">
                        @if($recipe->cook_time)
                            <span>⏱ {{ $recipe->cook_time }} min</span>
                        @endif
                        @if($recipe->prep_time)
                            <span>🔪 {{ $recipe->prep_time }} min prep</span>
                        @endif
                        @if($recipe->servings)
                            <span>🍽 {{ $recipe->servings }} servings</span>
                        @endif
                        <span>{{ $recipe->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="card-actions">
                    <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-ghost btn-sm">View</a>
                    <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('recipes.destroy', $recipe) }}"
                          onsubmit="return confirm('Delete \'{{ addslashes($recipe->title) }}\'? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
            @endforeach
        </div>

        {{-- ── PAGINATION ── --}}
        @if($recipes->hasPages())
        <div class="pagination-wrap">
            {{ $recipes->links() }}
        </div>
        @endif
    @endif
</div>

<script>
function filterCards(status) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    event.target.classList.add('active');

    document.querySelectorAll('.recipe-card').forEach(card => {
        if (status === 'all' || card.dataset.status === status) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

</body>
</html>

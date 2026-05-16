<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Rating;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class RecipeController extends Controller
{
    // ── Home / Index ──────────────────────────────────
    public function index(Request $request)
    {
        $stats = [
            'total_recipes'    => Recipe::where('is_published', true)->count(),
            'total_users'      => User::count(),
            'total_ratings'    => Rating::count(),
            'total_categories' => Category::count(),
            'total_tags'       => Tag::count(),
            'pending_recipes'  => Recipe::where('is_published', false)->count(),
        ];

        $categories = Category::withCount('recipes')
            ->orderByDesc('recipes_count')
            ->limit(10)
            ->get();

        $tags = Tag::withCount('recipes')
            ->having('recipes_count', '>', 0)
            ->orderByDesc('recipes_count')
            ->limit(20)
            ->get();

        $popularRecipes = Recipe::with(['category', 'ratings'])
            ->where('is_published', true)
            ->withAvg('ratings', 'score')
            ->orderByDesc('ratings_avg_score')
            ->limit(8)
            ->get()
            ->each(fn($r) => $r->average_rating = $r->ratings_avg_score);

        $recentRecipes = Recipe::with(['category', 'ratings'])
            ->where('is_published', true)
            ->withAvg('ratings', 'score')
            ->latest()
            ->limit(8)
            ->get()
            ->each(fn($r) => $r->average_rating = $r->ratings_avg_score);

        $userStats   = [];
        $userFavoris = collect();   // ← même nom que dans home.blade.php

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role !== 'admin') {
                $userStats = [
                    'my_recipes_count'   => Recipe::where('user_id', $user->id)->count(),
                    'my_favorites_count' => Favorite::where('user_id', $user->id)->count(),
                ];
                $userFavoris = Favorite::with(['recipe.category'])
                    ->where('user_id', $user->id)
                    ->latest()
                    ->limit(8)
                    ->get()
                    ->pluck('recipe')
                    ->filter();
            }
        }

        return view('home', compact(
            'stats', 'categories', 'tags',
            'popularRecipes', 'recentRecipes',
            'userStats', 'userFavoris',   // ← nom corrigé
        ));
    }

    // ── Search / Browse ───────────────────────────────
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        $recipesQuery = Recipe::with(['category', 'ratings'])
            ->where('is_published', true);

        if ($query) {
            $recipesQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('ingredients', 'like', "%{$query}%");
            });
        }

        if ($request->filled('category_id')) {
            $recipesQuery->where('category_id', $request->category_id);
        }

        if ($request->filled('tag_id')) {
            $recipesQuery->whereHas('tags', fn($q) => $q->where('tags.id', $request->tag_id));
        }

        if ($request->filled('max_time')) {
            $recipesQuery->whereRaw('(IFNULL(prep_time,0) + IFNULL(cook_time,0)) <= ?', [$request->max_time]);
        }

        $recipesQuery->withAvg('ratings', 'score');

        if ($request->filled('min_rating')) {
            $recipesQuery->having('ratings_avg_score', '>=', $request->min_rating);
        }

        match ($request->input('sort', 'date')) {
            'rating'     => $recipesQuery->orderByDesc('ratings_avg_score'),
            'cook_time'  => $recipesQuery->orderBy('cook_time'),
            'popularity' => $recipesQuery->withCount('ratings')->orderByDesc('ratings_count'),
            default      => $recipesQuery->latest(),
        };

        $recipes    = $recipesQuery->paginate(12)->withQueryString();
        $categories = Category::withCount('recipes')->get();
        $tags       = Tag::withCount('recipes')->get();

        $recipes->getCollection()->each(fn($r) => $r->average_rating = $r->ratings_avg_score);

        return view('recipes.index', compact('recipes', 'categories', 'tags', 'query'));
    }


    // ── By Category ───────────────────────────────────
    public function byCategory(Category $category)
    {
        $recipes = Recipe::with(['category', 'ratings'])
            ->where('is_published', true)
            ->where('category_id', $category->id)
            ->withAvg('ratings', 'score')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $recipes->getCollection()->each(fn($r) => $r->average_rating = $r->ratings_avg_score);

        $categories = Category::withCount('recipes')->get();
        $tags       = Tag::withCount('recipes')->get();
        $query      = '';

        return view('recipes.index', compact('recipes', 'categories', 'tags', 'query', 'category'));
    }

    // ── By Tag ────────────────────────────────────────
    public function byTag(Tag $tag)
    {
        $recipes = $tag->recipes()
            ->with(['category', 'ratings'])
            ->where('is_published', true)
            ->withAvg('ratings', 'score')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $recipes->getCollection()->each(fn($r) => $r->average_rating = $r->ratings_avg_score);

        $categories = Category::withCount('recipes')->get();
        $tags       = Tag::withCount('recipes')->get();
        $query      = '';

        return view('recipes.index', compact('recipes', 'categories', 'tags', 'query', 'tag'));
    }

    // ── Favorites ─────────────────────────────────────
    public function favorites()
    {
        $favoriteRecipeIds = Favorite::where('user_id', Auth::id())->pluck('recipe_id');

        $recipes = Recipe::with(['category', 'tags'])
            ->whereIn('id', $favoriteRecipeIds)
            ->latest()
            ->paginate(12);

        $pageTitle = 'Mes favoris';
        return view('recipes.my-recpes', compact('recipes', 'pageTitle'));
    }

    // ── My Recipes ────────────────────────────────────
    public function myRecipes()
    {
        $recipes = Recipe::with(['category', 'tags'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        $pageTitle = 'Mes recettes';
        return view('recipes.my-recpes', compact('recipes', 'pageTitle'));
    }

    // ── Create ────────────────────────────────────────
    public function create()
    {
        // Vérifié par middleware 'auth' — pas besoin de Policy
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('recipes.create', compact('categories', 'tags'));
    }

    // ── Store ─────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'ingredients'  => 'required|string',
            'steps'        => 'required|string',
            'prep_time'    => 'nullable|integer|min:0',
            'cook_time'    => 'nullable|integer|min:0',
            'servings'     => 'nullable|integer|min:1',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_published' => 'nullable|boolean',
            'tags'         => 'nullable|array',
            'tags.*'       => 'exists:tags,id',
        ]);

        if ($request->has('draft')) {
            $validated['is_published'] = false;
        } else {
            $validated['is_published'] = $request->boolean('is_published');
        }

        $validated['slug'] = $baseSlug = Str::slug($validated['title']);
        $count = 1;
        while (Recipe::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $baseSlug . '-' . $count++;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        $validated['user_id'] = Auth::id();

        $recipe = Recipe::create($validated);
        $recipe->tags()->sync($request->input('tags', []));

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recette créée avec succès ! 🎉');
    }

    // ── Show ──────────────────────────────────────────
    public function show(Recipe $recipe)
    {
        if (!$recipe->is_published) {
            if (!Auth::check() || (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin')) {
                abort(403, 'Cette recette n\'est pas encore publiée.');
            }
        }

        $recipe->load(['user', 'category', 'tags', 'ratings']);

        $userRating  = null;
        $isFavorited = false;

        if (Auth::check()) {
            $userRating  = $recipe->ratings->firstWhere('user_id', Auth::id());
            $isFavorited = Favorite::where('user_id', Auth::id())
                ->where('recipe_id', $recipe->id)
                ->exists();
        }

        return view('recipes.show', compact('recipe', 'userRating', 'isFavorited'));
    }

    // ── Edit ──────────────────────────────────────────
    public function edit(Recipe $recipe)
    {
        // Vérification manuelle — supprime authorize() qui n'existe pas dans Laravel 11
        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette recette.');
        }

        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('recipes.edit', compact('recipe', 'categories', 'tags'));
    }

    // ── Update ────────────────────────────────────────
    public function update(Request $request, Recipe $recipe)
    {
        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette recette.');
        }

        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'ingredients'  => 'required|string',
            'steps'        => 'required|string',
            'prep_time'    => 'nullable|integer|min:0',
            'cook_time'    => 'nullable|integer|min:0',
            'servings'     => 'nullable|integer|min:1',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_published' => 'nullable|boolean',
            'tags'         => 'nullable|array',
            'tags.*'       => 'exists:tags,id',
        ]);

        if ($recipe->title !== $validated['title']) {
            $validated['slug'] = $baseSlug = Str::slug($validated['title']);
            $count = 1;
            while (Recipe::where('slug', $validated['slug'])->where('id', '!=', $recipe->id)->exists()) {
                $validated['slug'] = $baseSlug . '-' . $count++;
            }
        }

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $recipe->update($validated);
        $recipe->tags()->sync($request->input('tags', []));

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recette mise à jour avec succès.');
    }

    // ── Destroy ───────────────────────────────────────
    public function destroy(Recipe $recipe)
    {
        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette recette.');
        }

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->tags()->detach();
        $recipe->ratings()->delete();
        Favorite::where('recipe_id', $recipe->id)->delete();
        $recipe->delete();

        return redirect()->route('recipes.my')
            ->with('success', 'Recette supprimée avec succès.');
    }

    // ── Rate ──────────────────────────────────────────
    public function rate(Request $request, Recipe $recipe)
    {
        $request->validate(['score' => 'required|integer|min:1|max:5']);

        if (Auth::id() === $recipe->user_id) {
            return back()->with('error', 'Vous ne pouvez pas noter votre propre recette.');
        }

        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'recipe_id' => $recipe->id],
            ['score'   => $request->score]
        );

        return back()->with('success', 'Note enregistrée ! ⭐');
    }

    // ── Toggle Favorite ───────────────────────────────
    public function toggleFavorite(Recipe $recipe)
    {
        $existing = Favorite::where('user_id', Auth::id())
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Retiré des favoris.';
        } else {
            Favorite::create([
                'user_id'   => Auth::id(),
                'recipe_id' => $recipe->id,
            ]);
            $message = 'Ajouté aux favoris ! ❤️';
        }

        return back()->with('success', $message);
    }
    public function store_recipe(Request $request)
{
    $request->validate([
        'recipe_id' => 'required|exists:recipes,id',
    ]);

    Favorite::firstOrCreate([
        'user_id'   => auth()->id(),
        'recipe_id' => $request->recipe_id,
    ]);

    return back()->with('success', 'Recipe added to favorites');
}






}

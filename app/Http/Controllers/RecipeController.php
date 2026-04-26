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

class RecipeController extends Controller
{
    // ──────────────────────────────────────────────────────────
    // HOME / INDEX
    // ──────────────────────────────────────────────────────────

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
            ->each(fn ($r) => $r->average_rating = $r->ratings_avg_score);

        $recentRecipes = Recipe::with(['category', 'ratings'])
            ->where('is_published', true)
            ->withAvg('ratings', 'score')
            ->latest()
            ->limit(8)
            ->get()
            ->each(fn ($r) => $r->average_rating = $r->ratings_avg_score);

        $userStats     = [];
        $userFavorites = collect();

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                $userStats = [
                    'my_recipes_count'   => Recipe::where('user_id', $user->id)->count(),
                    'my_favorites_count' => Favorite::where('user_id', $user->id)->count(),
                ];

                $userFavorites = Favorite::with(['recipe.category'])
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
            'userStats', 'userFavorites',
        ));
    }

    // ──────────────────────────────────────────────────────────
    // SEARCH  (Personne B — nouvelle méthode)
    // ──────────────────────────────────────────────────────────

    /**
     * Search & filter published recipes.
     *
     * Query params :
     *   q           — full-text (title, description, ingredients)
     *   category_id — filter by category
     *   tag_id      — filter by tag
     *   max_time    — max prep_time + cook_time (minutes)
     *   min_rating  — minimum average score (1-5)
     *   sort        — date | rating | popularity | cook_time
     */
    public function search(Request $request)
    {
        $query = Recipe::with(['category', 'tags', 'ratings'])
            ->where('is_published', true)
            ->withAvg('ratings', 'score')
            ->withCount('favorites');

        // Full-text search
        if ($search = $request->input('q')) {
            $like = '%' . $search . '%';
            $query->where(function ($q) use ($like) {
                $q->where('title',        'LIKE', $like)
                  ->orWhere('description', 'LIKE', $like)
                  ->orWhere('ingredients', 'LIKE', $like);
            });
        }

        // Filter : category
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // Filter : tag
        if ($tagId = $request->input('tag_id')) {
            $query->whereHas('tags', fn ($q) => $q->where('tags.id', $tagId));
        }

        // Filter : max total time
        if ($maxTime = $request->input('max_time')) {
            $query->whereRaw(
                'COALESCE(prep_time, 0) + COALESCE(cook_time, 0) <= ?',
                [$maxTime]
            );
        }

        // Filter : minimum rating (requires HAVING because withAvg uses SELECT aggregate)
        if ($minRating = $request->input('min_rating')) {
            $query->having('ratings_avg_score', '>=', $minRating);
        }

        // Sort
        switch ($request->input('sort', 'date')) {
            case 'rating':
                $query->orderByDesc('ratings_avg_score');
                break;
            case 'popularity':
                $query->orderByDesc('favorites_count');
                break;
            case 'cook_time':
                $query->orderBy('cook_time');
                break;
            default:
                $query->latest();
        }

        $recipes = $query->paginate(12)->withQueryString();

        $recipes->each(fn ($r) => $r->average_rating = $r->ratings_avg_score);

        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();

        return view('recipes.search', compact('recipes', 'categories', 'tags'));
    }

    // ──────────────────────────────────────────────────────────
    // BY CATEGORY / BY TAG
    // ──────────────────────────────────────────────────────────

    public function byCategory(Category $category)
    {
        $recipes = Recipe::with(['category', 'tags', 'ratings'])
            ->where('is_published', true)
            ->where('category_id', $category->id)
            ->withAvg('ratings', 'score')
            ->latest()
            ->paginate(12);

        $recipes->each(fn ($r) => $r->average_rating = $r->ratings_avg_score);

        return view('recipes.by-category', compact('recipes', 'category'));
    }

    public function byTag(Tag $tag)
    {
        $recipes = Recipe::with(['category', 'tags', 'ratings'])
            ->where('is_published', true)
            ->whereHas('tags', fn ($q) => $q->where('tags.id', $tag->id))
            ->withAvg('ratings', 'score')
            ->latest()
            ->paginate(12);

        $recipes->each(fn ($r) => $r->average_rating = $r->ratings_avg_score);

        return view('recipes.by-tag', compact('recipes', 'tag'));
    }

    // ──────────────────────────────────────────────────────────
    // FAVORITES
    // ──────────────────────────────────────────────────────────

    public function favorites()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $favorites = Favorite::with(['recipe.category', 'recipe.tags', 'recipe.ratings'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        $favorites->each(function ($fav) {
            if ($fav->recipe) {
                $fav->recipe->average_rating = $fav->recipe->ratings->avg('score');
            }
        });

        return view('recipes.favorites', compact('favorites'));
    }

    // ──────────────────────────────────────────────────────────
    // MY RECIPES
    // ──────────────────────────────────────────────────────────

    public function myRecipes()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $recipes = Recipe::with(['category', 'tags'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('recipes.my-recpes', compact('recipes'));
    }

    // ──────────────────────────────────────────────────────────
    // CREATE / STORE
    // ──────────────────────────────────────────────────────────

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $categories = Category::all();
        $tags       = Tag::all();

        return view('recipes.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
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
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_published' => 'boolean',
            'tags'         => 'nullable|array',
            'tags.*'       => 'exists:tags,id',
        ]);

        // Unique slug
        $validated['slug'] = Str::slug($validated['title']);
        $baseSlug = $validated['slug'];
        $count = 1;
        while (Recipe::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $baseSlug . '-' . $count++;
        }

        // Image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        $validated['user_id']      = Auth::id();
        $validated['is_published'] = $request->boolean('is_published');

        $recipe = Recipe::create($validated);

        if ($request->has('tags')) {
            $recipe->tags()->sync($request->tags);
        }

        // ✅ FIXED: was redirect()->route('login', $recipe)
        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recipe created successfully.');
    }

    // ──────────────────────────────────────────────────────────
    // SHOW
    // ──────────────────────────────────────────────────────────

    public function show(Recipe $recipe)
    {
        if (!$recipe->is_published && Auth::id() !== $recipe->user_id) {
            abort(403, 'This recipe is not published.');
        }

        $recipe->load(['user', 'category', 'tags']);

        return view('recipes.show', compact('recipe'));
    }

    // ──────────────────────────────────────────────────────────
    // EDIT / UPDATE
    // ──────────────────────────────────────────────────────────

    public function edit(Recipe $recipe)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'You do not have permission to edit this recipe.');
        }

        $categories = Category::all();
        $tags       = Tag::all();

        return view('recipes.edit', compact('recipe', 'categories', 'tags'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'You do not have permission to update this recipe.');
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
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_published' => 'boolean',
            'tags'         => 'nullable|array',
            'tags.*'       => 'exists:tags,id',
        ]);

        // Regenerate slug only if title changed
        if ($recipe->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
            $baseSlug = $validated['slug'];
            $count = 1;
            while (Recipe::where('slug', $validated['slug'])->where('id', '!=', $recipe->id)->exists()) {
                $validated['slug'] = $baseSlug . '-' . $count++;
            }
        }

        // Image upload
        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $recipe->update($validated);

        $recipe->tags()->sync($request->tags ?? []);

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recipe updated successfully.');
    }

    // ──────────────────────────────────────────────────────────
    // DESTROY
    // ──────────────────────────────────────────────────────────

    public function destroy(Recipe $recipe)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'You do not have permission to delete this recipe.');
        }

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->tags()->detach();
        $recipe->delete();

        return redirect()->route('recipes.index')
            ->with('success', 'Recipe deleted successfully.');
    }
}

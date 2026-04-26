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
    /**
     * Display a listing of published recipes.
     */
  

    /**
     * Show the form for creating a new recipe.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
 
        $categories = Category::all();
        $tags = Tag::all();

        return view('recipes.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created recipe.
     */
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

        // Generate unique slug
        $validated['slug'] = Str::slug($validated['title']);
        $baseSlug = $validated['slug'];
        $count = 1;
        while (Recipe::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $baseSlug . '-' . $count++;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        $validated['user_id']      = Auth::id();
        $validated['is_published'] = $request->boolean('is_published');

        $recipe = Recipe::create($validated);

        // Sync tags
        if ($request->has('tags')) {
            $recipe->tags()->sync($request->tags);
        }

        return redirect()->route('login', $recipe)
            ->with('success', 'Recipe created successfully.');
    }

    /**
     * Display the specified recipe.
     */
    public function show(Recipe $recipe)
    {
        // Block unpublished recipes from guests or non-owners
        if (!$recipe->is_published && Auth::id() !== $recipe->user_id) {
            abort(403, 'This recipe is not published.');
        }

        $recipe->load(['user', 'category', 'tags']);

        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified recipe.
     */
    public function edit(Recipe $recipe)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Only owner or admin can edit
        if (Auth::id() !== $recipe->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'You do not have permission to edit this recipe.');
        }

        $categories = Category::all();
        $tags       = Tag::all();

        return view('recipes.edit', compact('recipe', 'categories', 'tags'));
    }

    /**
     * Update the specified recipe.
     */
    public function update(Request $request, Recipe $recipe)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Only owner or admin can update
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

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $recipe->update($validated);

        // Sync tags
        $recipe->tags()->sync($request->tags ?? []);

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recipe updated successfully.');
    }

    /**
     * Remove the specified recipe.
     */
    public function destroy(Recipe $recipe)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Only owner or admin can delete
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

    /**
     * List recipes belonging to the authenticated user.
     */
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



   public function index(Request $request)
    {
        // ── Global stats (used by guest hero & admin strip) ──────────
        $stats = [
            'total_recipes'     => Recipe::where('is_published', true)->count(),
            'total_users'       => User::count(),
            'total_ratings'     => Rating::count(),
            'total_categories'  => Category::count(),
            'total_tags'        => Tag::count(),
            'pending_recipes'   => Recipe::where('is_published', false)->count(),
        ];

        // ── Categories for chips navigation ──────────────────────────
        $categories = Category::withCount('recipes')
            ->orderByDesc('recipes_count')
            ->limit(10)
            ->get();

        // ── Tags for tag cloud ────────────────────────────────────────
        $tags = Tag::withCount('recipes')
            ->having('recipes_count', '>', 0)
            ->orderByDesc('recipes_count')
            ->limit(20)
            ->get();

        // ── Popular recipes (top rated, published) ────────────────────
        $popularRecipes = Recipe::with(['category', 'ratings'])
            ->where('is_published', true)
            ->withAvg('ratings', 'score')          // ratings_avg_score
            ->orderByDesc('ratings_avg_score')
            ->limit(8)
            ->get()
            ->each(fn ($r) => $r->average_rating = $r->ratings_avg_score);

        // ── Recent recipes (published) ────────────────────────────────
        $recentRecipes = Recipe::with(['category', 'ratings'])
            ->where('is_published', true)
            ->withAvg('ratings', 'score')
            ->latest()
            ->limit(8)
            ->get()
            ->each(fn ($r) => $r->average_rating = $r->ratings_avg_score);

        // ── Per-user data (only when logged in) ───────────────────────
        $userStats     = [];
        $userFavorites = collect();

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                // Standard user: personal stats & favorites preview
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
                    ->filter(); // remove nulls in case recipe was deleted
            }
        }

        return view('home', compact(
            'stats',
            'categories',
            'tags',
            'popularRecipes',
            'recentRecipes',
            'userStats',
            'userFavorites',
        ));
    }
}









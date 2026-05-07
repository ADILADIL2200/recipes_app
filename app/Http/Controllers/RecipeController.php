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
    public function create()
    {
        $this->authorize('create', Recipe::class);

        $categories = Category::all();
        $tags       = Tag::all();

        return view('recipes.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Recipe::class);

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

        $validated['slug'] = Str::slug($validated['title']);
        $baseSlug = $validated['slug'];
        $count = 1;
        while (Recipe::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $baseSlug . '-' . $count++;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        $validated['user_id']      = Auth::id();
        $validated['is_published'] = $request->boolean('is_published');

        $recipe = Recipe::create($validated);

        if ($request->has('tags')) {
            $recipe->tags()->sync($request->tags);
        }

        return redirect()->route('recipes.show', $recipe)  // ← corrigé (était route('login'))
            ->with('success', 'Recette créée avec succès.');
    }

    public function show(Recipe $recipe)
    {
        if (!$recipe->is_published && Auth::id() !== $recipe->user_id) {
            abort(403, 'Cette recette n\'est pas publiée.');
        }

        $recipe->load(['user', 'category', 'tags']);

        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $categories = Category::all();
        $tags       = Tag::all();

        return view('recipes.edit', compact('recipe', 'categories', 'tags'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);

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

        if ($recipe->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
            $baseSlug = $validated['slug'];
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
        $recipe->tags()->sync($request->tags ?? []);

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recette mise à jour avec succès.');
    }

    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->tags()->detach();
        $recipe->delete();

        return redirect()->route('recipes.index')
            ->with('success', 'Recette supprimée avec succès.');
    }

    public function myRecipes()
    {
        $recipes = Recipe::with(['category', 'tags'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('recipes.my-recpes', compact('recipes'));
    }

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
}
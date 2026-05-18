<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private function ensureAdmin(): void
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs.');
        }
    }

    // ── Dashboard ─────────────────────────────────────
    public function dashboard()
    {
        $this->ensureAdmin();

        $stats = [
            'total_users'       => User::count(),
            'total_recipes'     => Recipe::count(),
            'total_categories'  => Category::count(),
            'total_tags'        => Tag::count(),
            'pending_recipes'   => Recipe::where('is_published', false)->count(),
            'published_recipes' => Recipe::where('is_published', true)->count(),
        ];

        $recentUsers   = User::latest()->limit(5)->get();
        $recentRecipes = Recipe::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentRecipes'));
    }

    // ── Users ─────────────────────────────────────────
    public function users()
    {
        $this->ensureAdmin();

        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function toggleUser(User $user)
    {
        $this->ensureAdmin();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $user->update([
            'role' => $user->role === 'admin' ? 'user' : 'admin',
        ]);

        return back()->with('success', 'Rôle mis à jour.');
    }

    public function destroyUser(User $user)
    {
        $this->ensureAdmin();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas vous supprimer.');
        }

        foreach ($user->recipes as $recipe) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $recipe->tags()->detach();
            $recipe->ratings()->delete();
            Favorite::where('recipe_id', $recipe->id)->delete();
            $recipe->delete();
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    // ── Recipes (admin) ───────────────────────────────
    public function recipes()
    {
        $this->ensureAdmin();

        $recipes = Recipe::with(['user', 'category'])
            ->latest()
            ->paginate(20);

        return view('admin.recipes.index', compact('recipes'));
    }

    public function toggleRecipe(Recipe $recipe)
    {
        $this->ensureAdmin();

        $recipe->update(['is_published' => !$recipe->is_published]);
        $status = $recipe->is_published ? 'publiée' : 'dépubliée';
        return back()->with('success', "Recette {$status}.");
    }

    public function destroyRecipe(Recipe $recipe)
    {
        $this->ensureAdmin();

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->tags()->detach();
        $recipe->ratings()->delete();
        Favorite::where('recipe_id', $recipe->id)->delete();
        $recipe->delete();

        return back()->with('success', 'Recette supprimée.');
    }

    // ── Categories ────────────────────────────────────
    public function categories()
    {
        $this->ensureAdmin();

        $categories = Category::withCount('recipes')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'icon'        => 'nullable|string|max:10',
        ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => \Str::slug($request->name),
            'description' => $request->description,
            'icon'        => $request->icon,
        ]);

        return back()->with('success', 'Catégorie créée.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $this->ensureAdmin();

        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon'        => 'nullable|string|max:10',
        ]);

        $category->update([
            'name'        => $request->name,
            'slug'        => \Str::slug($request->name),
            'description' => $request->description,
            'icon'        => $request->icon,
        ]);

        return back()->with('success', 'Catégorie mise à jour.');
    }

    public function destroyCategory(Category $category)
    {
        $this->ensureAdmin();

        $category->recipes()->update(['category_id' => null]);
        $category->delete();
        return back()->with('success', 'Catégorie supprimée.');
    }

    // ── Tags ──────────────────────────────────────────
    public function tags()
    {
        $this->ensureAdmin();

        $tags = Tag::withCount('recipes')->latest()->paginate(15);
        return view('admin.tags.index', compact('tags'));
    }

    public function storeTag(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        Tag::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
        ]);

        return back()->with('success', 'Tag créé.');
    }

    public function updateTag(Request $request, Tag $tag)
    {
        $this->ensureAdmin();

        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
        ]);

        return back()->with('success', 'Tag mis à jour.');
    }

    public function destroyTag(Tag $tag)
    {
        $this->ensureAdmin();

        $tag->recipes()->detach();
        $tag->delete();
        return back()->with('success', 'Tag supprimé.');
    }
}
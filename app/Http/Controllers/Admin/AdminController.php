<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Recipe;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ── Dashboard ─────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_users'    => User::count(),
            'total_recipes'  => Recipe::count(),
            'total_categories' => Category::count(),
            'total_tags'     => Tag::count(),
            'pending_recipes' => Recipe::where('is_published', false)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // ── Users ─────────────────────────────────────────
    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function toggleUser(User $user)
    {
        // Empêcher de se désactiver soi-même
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas vous désactiver.');
        }

        $user->update([
            'role' => $user->role === 'admin' ? 'user' : 'admin'
        ]);

        return back()->with('success', 'Rôle mis à jour.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas vous supprimer.');
        }

        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    // ── Categories ────────────────────────────────────
    public function categories()
    {
        $categories = Category::withCount('recipes')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
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
        $category->delete();
        return back()->with('success', 'Catégorie supprimée.');
    }

    // ── Tags ──────────────────────────────────────────
    public function tags()
    {
        $tags = Tag::withCount('recipes')->latest()->paginate(15);
        return view('admin.tags.index', compact('tags'));
    }

    public function storeTag(Request $request)
    {
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
        $tag->delete();
        return back()->with('success', 'Tag supprimé.');
    }
}
<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Api\ChatbotController;
use Illuminate\Support\Facades\Route;

// ====================== AUTH (guests only) ======================
Route::middleware('guest')->group(function () {
    Route::get('/login',  [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/signup',  [UserController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [UserController::class, 'signup']);

    Route::get('/forgot-password',        [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password',       [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password',        [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

// ====================== HOME ======================
Route::get('/', [RecipeController::class, 'index'])->name('home');

// ── RECIPE BROWSING (public) ───────────────────────────────────
Route::get('/recipes',                       [RecipeController::class, 'search'])     ->name('recipes.index');
Route::get('/recipes/search',                [RecipeController::class, 'search'])     ->name('recipes.search');
Route::get('/categories/{category}/recipes', [RecipeController::class, 'byCategory'])->name('recipes.by-category');
Route::get('/tags/{tag}/recipes',            [RecipeController::class, 'byTag'])      ->name('recipes.by-tag');

// ── RECIPE CRUD (auth required) ──────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get ('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes',        [RecipeController::class, 'store']) ->name('recipes.store');

    Route::get('/my-recipes',   [RecipeController::class, 'myRecipes'])->name('recipes.my');
    Route::get('/my-favorites', [RecipeController::class, 'favorites'])->name('recipes.favorites');

    Route::get   ('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])   ->name('recipes.edit');
    Route::put   ('/recipes/{recipe}',      [RecipeController::class, 'update']) ->name('recipes.update');
    Route::delete('/recipes/{recipe}',      [RecipeController::class, 'destroy'])->name('recipes.destroy');

    Route::post('/recipes/{recipe}/rate',     [RecipeController::class, 'rate'])          ->name('recipes.rate');
    Route::post('/recipes/{recipe}/favorite', [RecipeController::class, 'toggleFavorite'])->name('recipes.favorite');

    // Profil
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/favorites', [RecipeController::class, 'store_recipe'])->name('favorites');

    // ── Chatbot IA ─────────────────────────────────────────────
    // NE PAS utiliser le préfixe /api/ — sinon Laravel route via le kernel API
    // et le middleware CSRF est exclu → erreur 419
    Route::post('/chatbot/recipe', [ChatbotController::class, 'recipe'])->name('chatbot.recipe');
});

// Show public
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

// ====================== ADMIN ======================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::get   ('/users',               [AdminController::class, 'users'])      ->name('users');
    Route::patch ('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
    Route::delete('/users/{user}',        [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Categories
    Route::get   ('/categories',            [AdminController::class, 'categories'])     ->name('categories');
    Route::post  ('/categories',            [AdminController::class, 'storeCategory'])  ->name('categories.store');
    Route::put   ('/categories/{category}', [AdminController::class, 'updateCategory']) ->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Tags
    Route::get   ('/tags',        [AdminController::class, 'tags'])      ->name('tags');
    Route::post  ('/tags',        [AdminController::class, 'storeTag'])  ->name('tags.store');
    Route::put   ('/tags/{tag}',  [AdminController::class, 'updateTag']) ->name('tags.update');
    Route::delete('/tags/{tag}',  [AdminController::class, 'destroyTag'])->name('tags.destroy');

    // Recipes admin
    Route::patch ('/recipes/{recipe}/toggle', [AdminController::class, 'toggleRecipe'])  ->name('recipes.toggle');
    Route::delete('/recipes/{recipe}',        [AdminController::class, 'destroyRecipe']) ->name('recipes.destroy');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Admin\AdminController ;

/*
|--------------------------------------------------------------------------
| Web Routes — Recipe App
|--------------------------------------------------------------------------
*/

// ── HOME ──────────────────────────────────────────────────────────────────

Route::get('/', [RecipeController::class, 'index'])->name('home');

// ── RECIPE BROWSING (public) ───────────────────────────────────────────────

Route::get('/recipes',                       [RecipeController::class, 'index'])      ->name('recipes.index');
Route::get('/recipes/search',                [RecipeController::class, 'search'])     ->name('recipes.search');
Route::get('/recipes/{recipe}',              [RecipeController::class, 'show'])       ->name('recipes.show');
Route::get('/categories/{category}/recipes', [RecipeController::class, 'byCategory'])->name('recipes.by-category');
Route::get('/tags/{tag}/recipes',            [RecipeController::class, 'byTag'])      ->name('recipes.by-tag');

// ── RECIPE CRUD (auth required) ───────────────────────────────────────────

Route::middleware('auth')->group(function () {
    Route::get   ('/recipes/create',        [RecipeController::class, 'create']) ->name('recipes.create');
    Route::post  ('/recipes',               [RecipeController::class, 'store'])  ->name('recipes.store');
    Route::get   ('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])   ->name('recipes.edit');
    Route::put   ('/recipes/{recipe}',      [RecipeController::class, 'update']) ->name('recipes.update');
    Route::delete('/recipes/{recipe}',      [RecipeController::class, 'destroy'])->name('recipes.destroy');
});

// ── USER AREA (auth required) ─────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    Route::get('/my-recipes',   [RecipeController::class, 'myRecipes'])->name('recipes.my');
    Route::get('/my-favorites', [RecipeController::class, 'favorites'])->name('recipes.favorites');
});

// ── AUTH (visiteurs seulement) ────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get ('/signup', [UserController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [UserController::class, 'signup']);

    Route::get ('/login',  [UserController::class, 'showLogin'])->name('login');
    Route::post('/login',  [UserController::class, 'login']);

    Route::get ('/forgot-password',       [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password',       [ForgotPasswordController::class, 'sendResetLink']) ->name('password.email');
    Route::get ('/reset-password/{token}',[ForgotPasswordController::class, 'showResetForm']) ->name('password.reset');
    Route::post('/reset-password',        [ForgotPasswordController::class, 'resetPassword']) ->name('password.update');
});

Route::post('/logout', [UserController::class, 'logout'])
     ->name('logout')
     ->middleware('auth');

// ── PROFIL (auth required) ────────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// ── ADMIN AREA ────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::get   ('/users',              [AdminController::class, 'users'])      ->name('users');
    Route::patch ('/users/{user}/toggle',[AdminController::class, 'toggleUser']) ->name('users.toggle');
    Route::delete('/users/{user}',       [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Categories
    Route::get   ('/categories',                [AdminController::class, 'categories'])     ->name('categories');
    Route::post  ('/categories',                [AdminController::class, 'storeCategory'])  ->name('categories.store');
    Route::put   ('/categories/{category}',     [AdminController::class, 'updateCategory']) ->name('categories.update');
    Route::delete('/categories/{category}',     [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // Tags
    Route::get   ('/tags',          [AdminController::class, 'tags'])       ->name('tags');
    Route::post  ('/tags',          [AdminController::class, 'storeTag'])   ->name('tags.store');
    Route::put   ('/tags/{tag}',    [AdminController::class, 'updateTag'])  ->name('tags.update');
    Route::delete('/tags/{tag}',    [AdminController::class, 'destroyTag']) ->name('tags.destroy');
});
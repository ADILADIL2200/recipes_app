<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes — Recipe App
| No resource() used; every route is declared explicitly.
|--------------------------------------------------------------------------
*/

// ── HOME ──────────────────────────────────────────────────────────────────

Route::get('/', [RecipeController::class, 'index'])->name('home');

// ── RECIPE BROWSING (public) ───────────────────────────────────────────────

Route::get('/recipes',                       [RecipeController::class, 'index'])      ->name('recipes.index');
Route::get('/recipes/search',                [RecipeController::class, 'search'])     ->name('recipes.search');
Route::get('/recipes/create',                [RecipeController::class, 'create'])     ->name('recipes.create'); // ✅ before {recipe}
Route::get('/recipes/{recipe}',              [RecipeController::class, 'show'])       ->name('recipes.show');
Route::get('/recipes/{recipe}/edit',         [RecipeController::class, 'edit'])       ->name('recipes.edit');
Route::get('/categories/{category}/recipes', [RecipeController::class, 'byCategory'])->name('recipes.by-category');
Route::get('/tags/{tag}/recipes',            [RecipeController::class, 'byTag'])      ->name('recipes.by-tag');

// ── RECIPE CRUD (auth required — handled inside controller) ───────────────

Route::post  ('/recipes',          [RecipeController::class, 'store'])  ->name('recipes.store');
Route::put   ('/recipes/{recipe}', [RecipeController::class, 'update']) ->name('recipes.update');
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

// ── USER AREA ─────────────────────────────────────────────────────────────

Route::get('/my-recipes',   [RecipeController::class, 'myRecipes'])->name('recipes.my');
Route::get('/my-favorites', [RecipeController::class, 'favorites'])->name('recipes.favorites');

// ── AUTH ──────────────────────────────────────────────────────────────────

Route::get ('/signup', [UserController::class, 'showSignup'])->name('signup');
Route::post('/signup', [UserController::class, 'signup']);

Route::get ('/login',  [UserController::class, 'showLogin'])->name('login');
Route::post('/login',  [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// ── ADMIN AREA ────────────────────────────────────────────────────────────
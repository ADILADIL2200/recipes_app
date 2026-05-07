<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    // Admin peut tout faire
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null; // continue vers les autres méthodes
    }

    // Voir une recette publiée
    public function view(?User $user, Recipe $recipe): bool
    {
        if ($recipe->is_published) {
            return true;
        }
        // Brouillon → seulement le propriétaire
        return $user?->id === $recipe->user_id;
    }

    // Créer une recette
    public function create(User $user): bool
    {
        return true; // tout utilisateur connecté peut créer
    }

    // Modifier une recette
    public function update(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }

    // Supprimer une recette
    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
           Schema::create('ratings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
        $table->tinyInteger('score'); // 1 to 5
        $table->text('comment')->nullable();
        $table->unique(['user_id', 'recipe_id']); // one rating per user per recipe
        $table->timestamps();
    });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};

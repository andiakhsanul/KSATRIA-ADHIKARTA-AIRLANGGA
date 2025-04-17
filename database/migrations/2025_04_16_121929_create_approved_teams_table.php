<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('approved_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tim_id')->constrained('tim')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->unique(['tim_id', 'reviewer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_tim');
    }
};

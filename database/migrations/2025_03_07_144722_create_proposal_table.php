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
        Schema::create('proposal', function (Blueprint $table) {
            $table->id();
            $table->string('judul_proposal');
            $table->text('abstract');
            $table->foreignId(column: 'tim_id')->constrained('tim')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('file_path');
            $table->foreignId( 'pkm_id')->constrained('jenis_pkm')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal');
    }
};

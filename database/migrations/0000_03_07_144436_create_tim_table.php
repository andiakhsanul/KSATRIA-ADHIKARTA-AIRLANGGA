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
        Schema::create('tim', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ketua_id')->nullable();
            $table->string('nama_tim')->unique()->collation('utf8mb4_bin');
            $table->text('proposal_path')->nullable();
            $table->foreignId( 'pkm_id')->constrained('jenis_pkm')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tim');
    }
};

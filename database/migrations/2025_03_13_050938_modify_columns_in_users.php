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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_lengkap', 500)->change();
            $table->string('nim', 500)->nullable()->change();
            $table->string('nip', 500)->unique()->nullable()->change();
            $table->string('email', 500)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_lengkap', 255)->change();
            $table->string('nim', 255)->nullable()->change();
            $table->string('nip', 255)->unique()->nullable()->change();
            $table->string('email', 255)->nullable()->change();
        });
    }
};

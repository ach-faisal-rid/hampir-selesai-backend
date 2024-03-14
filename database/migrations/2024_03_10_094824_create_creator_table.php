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
        Schema::create('creator', function (Blueprint $table) {
            $table->id();

            $table->integer('users_id'); // relasi ke users table
            $table->integer('category_id'); // relasi ke category table
            $table->integer('platform_id'); // relasi ke platform table

            $table->text('biography')->nullable();
            $table->text('portofolio')->nullable();
            $table->string('experience')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator');
    }
};

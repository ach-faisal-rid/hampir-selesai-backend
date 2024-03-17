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
        Schema::create('content', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id'); // relasi ke category table
            $table->integer('platform_id'); // relasi ke platform table
            $table->integer('freelancer_id'); // relasi ke creator table

            $table->longText('cover_image');
            $table->text('video_link')->nullable();

            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('price')->nullable();
            $table->longText('note')->nullable();
            $table->string('tag');

            $table->integer('delivery_time')->nullable();
            $table->integer('revision_limit')->nullable();

            $table->boolean('status');
            $table->integer('is_approved')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content');
    }
};

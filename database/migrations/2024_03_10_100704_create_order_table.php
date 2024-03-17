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
        Schema::create('order', function (Blueprint $table) {
            $table->id();

            $table->integer('content_id'); // relasi ke content table
            $table->integer('freelancer_id'); // relasi ke creator table
            $table->integer('buyer_id'); // relasi ke buyers table
            $table->integer('order_status_id'); // relasi ke order status table

            $table->longText('file')->nullable();
            $table->longText('note')->nullable();
            $table->date('expired')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};

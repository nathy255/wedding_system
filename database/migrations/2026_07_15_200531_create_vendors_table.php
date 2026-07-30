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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // e.g., Venue, Catering, Photography
            $table->string('location')->nullable();
            $table->decimal('starting_price', 10, 2)->nullable();
            $table->decimal('rating', 3, 2)->default(0.00); // e.g. 4.95
            $table->integer('review_count')->default(0);
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};

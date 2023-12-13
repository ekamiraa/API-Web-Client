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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->float('rating')->nullable();
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('movie_id')->nullable(false);
            $table->unsignedBigInteger('reviewer_id')->nullable(false);
            $table->timestamps();

            //Menginisialisasi ForeignKey
            $table->foreign('movie_id')->on('movies')->references('id');
            $table->foreign('reviewer_id')->on('reviewers')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

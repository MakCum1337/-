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
        Schema::create('physical_books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('author');
            $table->unsignedBigInteger('genre_id');
            $table->integer('count');
            $table->decimal('price', 10, 2);
            $table->decimal('price_for_rent', 10, 2);
            $table->timestamps();

            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
        });

        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_books');
    }
};

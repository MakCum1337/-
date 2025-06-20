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
        Schema::create('deliverers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sername');
            $table->string('email');
            $table->boolean('availability_car')->default(false);
            $table->string('number_car')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliverers');
    }
};

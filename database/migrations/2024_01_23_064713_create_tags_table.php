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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyText('description')->nullable();
            $table->unsignedBigInteger('thumbnail')->nullable();
            $table->foreign('thumbnail')->references('id')->on('media')->restrictOnDelete();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('media')->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};

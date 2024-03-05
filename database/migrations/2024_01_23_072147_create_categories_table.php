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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyText('description')->nullable();
            $table->string("thumbnail")->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('categorables', function (Blueprint $table){
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->morphs('categorable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->unsignedBigInteger('thumbnail')->nullable();
            $table->foreign('thumbnail')->references('id')->on('media')->restrictOnDelete();
            $table->string('type')->default('default');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->smallInteger('read_time')->default(0);
            $table->smallInteger('like_count')->default(0);
            $table->boolean('show_in_home')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

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
            $table->string('name', 512);
            $table->string('slug', 512)->nullable()->unique();
            $table->text('image')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('status', 120)->default('draft');
            $table->string('icon', 255)->nullable();
            $table->tinyInteger('order')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('status', 120)->default('draft');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 512);
            $table->string('slug', 512)->nullable()->unique();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('status', 120)->default('draft');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->string('author_name', 512)->nullable();
            $table->tinyInteger('is_featured')->unsigned()->default(0);
            $table->tinyInteger('is_trending_onc_update')->unsigned()->default(0);
            $table->string('type', 120)->default('blog');
            $table->string('image', 1024)->nullable();
            $table->string('dr_name', 512)->nullable();
            $table->string('dr_image', 1024)->nullable();
            $table->string('apple_link', 1024)->nullable();
            $table->string('spotify_link', 1024)->nullable();
            $table->string('yt_link', 1024)->nullable();
            $table->json('key_points')->nullable();
            $table->timestamps();
        });

        Schema::create('post_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
        });
        Schema::create('post_keywords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
        });

        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('posts_translations');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('categories_translations');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('tags_translations');
    }
};

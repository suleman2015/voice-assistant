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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('profession', 150);
            $table->string('specialty', 150);
            $table->date('case_date')->nullable();
            $table->text('description');
            $table->boolean('terms_agreed')->default(false);
            $table->string('status', 50)->default('pending');
            $table->timestamps();
        });

        Schema::create('case_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('cases')->onDelete('cascade');
            $table->string('file_path');
            $table->string('image_type', 150)->nullable();
            $table->date('date_taken')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_images');
        Schema::dropIfExists('cases');
    }
};

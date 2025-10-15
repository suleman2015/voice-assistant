<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('url_redirects', function (Blueprint $table) {
            $table->id();
            $table->text('original_url')->unique();
            $table->text('target_url');
            $table->unsignedBigInteger('visits')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverses the creation of the url_redirector table
     */
    public function down(): void
    {
        Schema::dropIfExists('url_redirects');
    }
};

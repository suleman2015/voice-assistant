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
        Schema::create('recaptcha_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(false);
            $table->string('site_key')->nullable();
            $table->string('secret_key')->nullable();
            $table->timestamps();
        });

        Schema::create('recaptcha_forms', function (Blueprint $table) {
            $table->id();
            $table->string('form_name');
            $table->boolean('enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recaptcha_settings');
        Schema::dropIfExists('recaptcha_forms');
    }
};

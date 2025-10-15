<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
            $table->integer('order')->default(0);

            // presentation
            $table->string('title');
            $table->string('icon_class')->nullable();   // e.g., 'fa-solid fa-blog'
            $table->string('css_class')->nullable();    // e.g., 'btn btn-joinus rounded-pill'

            // behavior
            $table->enum('type', ['custom','page','category','post','route'])->default('custom');
            $table->string('url')->nullable();          // used for custom
            $table->string('reference_type')->nullable(); // optional: 'Modules\Blog\Entities\Category' etc.
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('route_name')->nullable();   // used for 'route' type
            $table->json('route_params')->nullable();   // e.g., {"slug":"my-page"}

            // i18n (optional, keep single menu per site if not needed)
            $table->string('locale',5)->nullable();     // 'en', 'ar', 'es'…

            $table->boolean('is_new_tab')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('menu_items');
    }
};

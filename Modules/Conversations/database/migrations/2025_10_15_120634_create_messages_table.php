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
        Schema::create('messages', function (Blueprint $t) {
            $t->id();

            $t->foreignId('conversation_id')->constrained()->cascadeOnDelete();

            // null user_id => assistant/system message
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $t->enum('role', ['system', 'user', 'assistant']);

            // final text content; (for streaming you can store partials in content_delta during generation)
            $t->longText('content')->nullable();
            $t->longText('content_delta')->nullable();

            // voice paths
            $t->string('input_audio_path')->nullable();     // user's normalized wav (16k mono)
            $t->string('audio_path')->nullable();           // assistant TTS wav path

            $t->string('lang', 8)->nullable();              // 'en', 'ur', etc.
            $t->json('timings')->nullable();                // {"stt_ms":..,"llm_ms":..,"tts_ms":..,"total_ms":..}

            $t->enum('status', ['queued', 'streaming', 'done', 'error'])->default('queued');
            $t->text('error_message')->nullable();

            $t->timestampsTz();

            $t->index(['conversation_id', 'created_at']);
            $t->index(['user_id', 'created_at']);
            // If on MySQL 8+, you can add fulltext for faster search:
            // $t->fullText(['content']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};

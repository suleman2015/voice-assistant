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
        Schema::create('voice_notes', function (Blueprint $t) {
            $t->id();

            $t->foreignId('user_id')->constrained()->cascadeOnDelete();

            // raw & processed audio
            $t->string('original_path');                    // uploaded file (webm/m4a/etc.)
            $t->string('normalized_path')->nullable();      // wav 16k mono after ffmpeg

            // STT output
            $t->longText('transcript')->nullable();
            $t->string('stt_language', 8)->nullable();      // 'en', 'ur'
            $t->float('stt_confidence')->nullable();        // optional metric if exposed
            $t->unsignedInteger('duration_ms')->nullable();

            $t->enum('status', ['uploaded', 'normalized', 'transcribed', 'attached', 'error'])
                ->default('uploaded');
            $t->text('error_message')->nullable();

            $t->timestampsTz();

            $t->index(['user_id', 'created_at']);
            // MySQL optional:
            // $t->fullText(['transcript']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voice_notes');
    }
};

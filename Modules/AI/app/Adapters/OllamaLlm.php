<?php

namespace Modules\AI\App\Adapters;

use Illuminate\Support\Facades\Http;
use Modules\AI\App\Contracts\LlmService;

class OllamaLlm implements LlmService
{
    public function complete(string $prompt, string $model = 'phi3:mini'): string
    {
        $url = rtrim(env('OLLAMA_URL', 'http://localhost:11434'), '/') . '/api/generate';
        $res = Http::post($url, ['model' => $model, 'prompt' => $prompt, 'stream' => false])->json();
        return trim($res['response'] ?? '');
    }
}

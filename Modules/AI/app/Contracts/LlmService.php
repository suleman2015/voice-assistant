<?php

namespace Modules\AI\App\Contracts;

interface LlmService
{
    public function complete(string $prompt, string $model = 'phi3:mini'): string;
}

<?php

namespace Modules\SEO\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SeoMeta extends Component
{
    public array $seo;
    public array $folders;
    public array $files;
    public string $currentFolder;

    public function __construct($seo = [], array $folders = [], array $files = [], string $currentFolder = '')
    {
        if (is_string($seo)) {
            $seo = json_decode($seo, true);
        }

        $this->seo = is_array($seo) ? $seo : [];
        $this->folders = $folders;
        $this->files = $files;
        $this->currentFolder = $currentFolder;
    }

    public function render(): View|string
    {
        return view('seo::components.seo-meta');
    }
}

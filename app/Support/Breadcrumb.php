<?php

namespace App\Support;

class Breadcrumb
{
    protected array $items = [];

    // Add a breadcrumb item (label, url, active flag)
    public function add(string $label, string $url = '', bool $active = false): self
    {
        $this->items[] = [
            'label' => $label,
            'url' => $url,
            'active' => $active,
        ];
        return $this;
    }

    // Get all items
    public function get(): array
    {
        return $this->items;
    }

    // Reset the breadcrumbs
    public function reset(): self
    {
        $this->items = [];
        return $this;
    }

    // Render the breadcrumb HTML (customize as needed)
    public function render(): string
    {
        if (empty($this->items)) {
            return '';
        }

        $html = '<ol class="breadcrumb m-0">';
        foreach ($this->items as $item) {
            if ($item['active']) {
                $html .= '<li class="breadcrumb-item active" aria-current="page">' . e($item['label']) . '</li>';
            } else {
                $html .= '<li class="breadcrumb-item"><a href="' . e($item['url']) . '">' . e($item['label']) . '</a></li>';
            }
        }
        $html .= '</ol>';

        return $html;
    }
}

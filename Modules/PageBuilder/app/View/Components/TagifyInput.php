<?php

namespace Modules\PageBuilder\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class TagifyInput extends Component
{
    public string $name;
    public ?string $value;
    public ?string $label;
    public string $id;
    public string $class;
    public string $wrapperClass;

    public function __construct(
        string $name,
        string $label = null,
        string $id = null,
        string $value = null,
        string $class = 'form-control tags-evs',
        string $wrapperClass = 'col-md-6 mb-3'
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->label = $label ?? ucfirst(str_replace('_', ' ', $name));
        $this->id = $id ?? $name;
        $this->class = $class;
        $this->wrapperClass = $wrapperClass;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('pagebuilder::components.tagify-input');
    }
}

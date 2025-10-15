<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;

class TypeSelect extends Component
{
    public $label;
    public $name;
    public $selected;

    public function __construct($label = 'Type', $name = 'type', $selected = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->selected = $selected;
    }

    public function render(): View|string
    {
        return view('blog::components.forms.fields.type-select');
    }
}

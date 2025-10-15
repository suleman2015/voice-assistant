<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;

class TextField extends Component
{
    public $label;
    public $name;
    public $value;
    public $placeholder;

    public function __construct($label = 'Text Field', $name = 'textfield', $value = null, $placeholder = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    public function render(): View|string
    {
        return view('blog::components.forms.fields.text-field');
    }
}

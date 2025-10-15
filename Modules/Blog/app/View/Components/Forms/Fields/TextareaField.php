<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;

class TextareaField extends Component
{
    public $label;
    public $name;
    public $value;
    public $placeholder;
    public $maxlength;
    public $required;

    public function __construct(
        $label = 'Content',
        $name = 'content',
        $value = null,
        $placeholder = '',
        $maxlength = 1000,
        $required = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->maxlength = $maxlength;
        $this->required = $required;
    }


    public function render()
    {
        return view('blog::components.forms.fields.textarea-field');
    }
}

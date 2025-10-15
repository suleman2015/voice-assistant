<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;

class EditorField extends Component
{
    public $label;
    public $name;
    public $value;
    public $placeholder;
    public $required;

    public function __construct(
        $label = 'Content',
        $name = 'content',
        $value = null,
        $placeholder = '',
        $required = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
    }


    public function render()
    {
        return view('blog::components.forms.fields.editor-field');
    }
}

<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;

class SwitchField extends Component
{
    public $label;
    public $name;
    public $value;
    public $checked;
    public $help;
    public $disabled;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $label,
        $name,
        $value = 1,
        $checked = false,
        $help = null,
        $disabled = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->checked = $checked;
        $this->help = $help;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('blog::components.forms.fields.switch-field');
    }
}

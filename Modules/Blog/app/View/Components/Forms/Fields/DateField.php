<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class DateField extends Component
{
    public $label;
    public $name;
    public $value;
    public $required;
    public $disablePast;
    public $min;
    public $max;
    public $disabled;
    public $readonly;
    public $help;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $label,
        $name,
        $value = null,
        $required = false,
        $disablePast = false,
        $min = null,
        $max = null,
        $disabled = false,
        $readonly = false,
        $help = null
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->disablePast = $disablePast;
        $this->min = $min;
        $this->max = $max;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
        $this->help = $help;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('blog::components.forms.fields.date-field');
    }
}

<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;

class MultiCheckboxFilter extends Component
{
    public $label;
    public $name;
    public $options;
    public $selected;

    public function __construct($label, $name, $options = [], $selected = [])
    {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
    }

    public function render(): View|string
    {
        return view('blog::components.forms.fields.multicheckboxfilter');
    }
}

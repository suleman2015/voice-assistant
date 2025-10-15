<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;

class MultiSelect extends Component
{
    public $label;
    public $name;
    public $options;
    public $selected;

    public function __construct($label = 'Select', $name = 'tags', $options = [], $selected = [])
    {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->selected = is_array($selected) ? $selected : [];
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('blog::components.forms.fields.multi-select');
    }
}

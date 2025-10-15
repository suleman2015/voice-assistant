<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;

class StatusSelect extends Component
{
    public $label;
    public $name;
    public $selected;

    public function __construct($label = 'Status', $name = 'status', $selected = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->selected = $selected;
    }

    public function render(): View|string
    {
        return view('blog::components.forms.fields.status-select');
    }
}

<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;

class Repeater extends Component
{
    public string $name;
    public string $label;
    public array $values;

    public function __construct(string $name, string $label = '', array $values = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->values = $values;
    }

    public function render()
    {
        return view('blog::components.forms.fields.repeater');
    }
}

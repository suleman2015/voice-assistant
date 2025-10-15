<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;

class EventRepeater extends Component
{
    public string $name;
    public string $label;
    public array $values;

    public function __construct(string $name = 'event_dates', string $label = 'Event Dates', array $values = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->values = $values;
    }

    public function render()
    {
        return view('blog::components.forms.fields.event-repeater');
    }
}

<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;

class NameField extends Component
{
    public $label;
    public $name;
    public $placeholder;
    public $value;
    public $required;

    /**
     * Constructor to initialize component properties.
     *
     * @param string $label
     * @param string $name
     * @param string $placeholder
     * @param mixed $value Explicit value passed (optional)
     * @param bool $required
     */
    public function __construct(
        $label = 'Name',
        $name = 'name',
        $placeholder = '',
        $value = null,
        $required = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;
    }

    /**
     * This method resolves the final value of the field:
     * - If explicit $value is passed, use it.
     * - Else try to get old() input (from validation errors).
     * - Else try to get value from shared 'formModel' using the field name.
     *
     * This enables automatic model binding by sharing 'formModel' in controller.
     *
     * @return mixed
     */
    public function resolvedValue()
    {
        // If an explicit value is passed, use it directly
        if ($this->value !== null) {
            return old($this->name, $this->value);
        }

        // Get the shared model passed from controller or globally
        $model = view()->shared('formModel');

        // Use old input if exists, otherwise get from model property if model exists
        return old($this->name, $model ? data_get($model, $this->name) : null);
    }

    public function render()
    {
        return view('blog::components.forms.fields.name-field');
    }
}

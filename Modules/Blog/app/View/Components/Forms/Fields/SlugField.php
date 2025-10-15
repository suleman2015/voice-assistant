<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;

class SlugField extends Component
{
    public string $label;
    public string $name;
    public string $placeholder;
    public ?string $value;
    public bool $required;
    public string $modelClass;
    public $id;

    public function __construct(
        string $label = 'Slug',
        string $name = 'slug',
        string $placeholder = '',
        ?string $value = null,
        bool $required = false,
        $model = null,
        $id = null
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;
        $this->modelClass = $model ? get_class($model) : '';
        $this->id = $id ?? ($model?->id ?? '');
    }

    public function render()
    {
        return view('blog::components.forms.fields.slug-field');
    }
}

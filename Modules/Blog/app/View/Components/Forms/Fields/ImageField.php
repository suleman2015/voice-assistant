<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;

class ImageField extends Component
{
    /**
     * Create a new component instance.
     */
    public $label;
    public $name;
    public $value;
    public $path;

    public function __construct($label = 'Image', $name = 'image', $value = null, $path = 'blogs/posts/images/')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->path = $path;
    }


    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('blog::components.forms.fields.image-field');
    }
}

<?php

namespace Modules\PageBuilder\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ImgUp extends Component
{
    /**
     * Create a new component instance.
     */
    public $name;

    public $old;

    public $ref;

    public function __construct($name = null, $old = null, $ref = '')
    {
        $this->name = $name;
        $this->old = $old;
        $this->ref = $ref;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('pagebuilder::components.img-up');
    }
}

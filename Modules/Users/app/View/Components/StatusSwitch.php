<?php

namespace Modules\Users\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class StatusSwitch extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct() {}

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('users::components.status-switch');
    }
}

<?php

namespace Modules\Users\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Actions extends Component
{
    public function __construct() {}

    public function render(): View|string
    {
        return view('users::components.actions');
    }
}

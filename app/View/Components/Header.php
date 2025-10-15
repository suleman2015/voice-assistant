<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Menu\Models\Entities\Menu;

class Header extends Component
{
    public $menu;

    public function __construct()
    {
        // Fetch menu with items and children
        $this->menu = Menu::where('name', 'Main menu')
            ->where('is_active', true)
            ->with(['items.children.children','items.reference']) // Eager load children recursively
            ->first();
    }

    public function render()
    {
        return view('frontend.components._header');
    }
}

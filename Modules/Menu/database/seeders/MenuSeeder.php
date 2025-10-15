<?php
namespace Modules\Menu\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Entities\MenuItem;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menu = Menu::firstOrCreate(['location' => 'main'], ['name' => 'Main menu']);

        MenuItem::firstOrCreate([
            'menu_id' => $menu->id,
            'title'   => 'Home',
            'type'    => 'route',
            'route_name' => 'home',
            'order'   => 0,
            'icon_class' => 'fa-solid fa-house'
        ]);

        // Add more defaults if you want…
    }
}

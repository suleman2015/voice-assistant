<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Recaptcha\Database\Seeders\PaymentModuleSeeder;
use Modules\Recaptcha\Database\Seeders\RecaptchaSeeder;
use Modules\Setting\Database\Seeders\SettingsTableSeeder;
use Modules\UserRoles\Database\Seeders\UserRolesDatabaseSeeder;
use Modules\Users\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserRolesDatabaseSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(RecaptchaSeeder::class);
    }
}

<?php

namespace Modules\Recaptcha\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RecaptchaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert data into recaptcha_settings table
        DB::table('recaptcha_settings')->insert([
            [
                'enabled' => 0,
                'site_key' => '6Le-pHIrAAAAABLkgdKkQYYaP-msHOQ0ZKBeU1UB',
                'secret_key' => '6Le-pHIrAAAAAFQKp-3HIwLtbdXpv7OWVgA_GnT3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Insert data into recaptcha_forms table
        DB::table('recaptcha_forms')->insert([
            [
                'form_name' => 'login_form',
                'enabled' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'form_name' => 'register_form',
                'enabled' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

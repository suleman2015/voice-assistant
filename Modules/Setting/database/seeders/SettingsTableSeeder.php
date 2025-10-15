<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'Masarat', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'site_description', 'value' => 'I make my chances', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'email', 'value' => 'info@releasemesyria.org', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'phone', 'value' => '00905349329231', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'address', 'value' => '2464 Royal Ln. Mesa,New Jersey 45463', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'default_language', 'value' => 'ar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'timezone', 'value' => 'UTC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'copyright_text', 'value' => 'Releaseme, All rights reserved © 2025.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'maintenance_mode', 'value' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'favicon', 'value' => 'favicon.png', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'header_logo', 'value' => 'header_logo.png', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'footer_logo', 'value' => 'footer_logo.png', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'dark_logo', 'value' => 'dark_logo.png', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'light_logo', 'value' => 'light_logo.png', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'mail_mailer', 'value' => 'smtp', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'mail_host', 'value' => 'smtp.gmail.com', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'mail_port', 'value' => '465', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'mail_encryption', 'value' => 'ssl', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'mail_username', 'value' => 'dar7suleman@gmail.com', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'mail_password', 'value' => 'bbsyjapnilpihleg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'mail_from_address', 'value' => 'info@releasemesyria.org', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'mail_from_name', 'value' => 'Masarat', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'primary_color', 'value' => '#4e73df', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'secondary_color', 'value' => '#1ecc8c', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'accent_color', 'value' => '#f6c23e', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'background_color', 'value' => '#ffffff', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'text_color', 'value' => '#212529', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'button_style', 'value' => 'rounded', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'border_radius', 'value' => '8px', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'theme_mode', 'value' => 'auto', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'custom_css', 'value' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'google_fonts_api_key', 'value' => 'AIzaSyCFaWkjFkB4WnAhNmauI6IIJCQFdcgfmlM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'heading_font', 'value' => 'Poppins', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'body_font', 'value' => 'Poppins', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'heading_font_rtl', 'value' => 'Tajawal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'body_font_rtl', 'value' => 'Tajawal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'Users', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'UserRoles', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'Media', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'Language', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'Blog', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'Setting', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'Contact', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'PageBuilder', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'Recaptcha', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'SEO', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'Donation', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'Payment', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'Testimonial', 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}

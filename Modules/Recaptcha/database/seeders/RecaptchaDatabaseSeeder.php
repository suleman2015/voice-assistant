<?php

namespace Modules\Recaptcha\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Recaptcha\Models\RecaptchaForm;

class RecaptchaDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $forms = ['contact_form', 'login_form', 'register_form', 'newsletter_form'];

        foreach ($forms as $form) {
            RecaptchaForm::firstOrCreate(['form_name' => $form]);
        }
    }
}

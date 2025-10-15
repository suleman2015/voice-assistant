<?php

return [
    'name' => 'Recaptcha',
    'enabled' => true,
    'site_key' => env('NOCAPTCHA_SITEKEY'),
    'secret_key' => env('NOCAPTCHA_SECRET'),
];

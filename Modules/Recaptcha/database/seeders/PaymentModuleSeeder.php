<?php

namespace Modules\Recaptcha\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentModuleSeeder extends Seeder
{
    public function run(): void
    {
        // Insert data into payment_gateways table
        DB::table('payment_gateways')->insert([
            [
                'name' => 'stripe',
                'label' => 'Stripe',
                'icon' => 'fa-brands fa-stripe',
                'enabled' => 0,
                'mode' => 'sandbox',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'paypal',
                'label' => 'paypal',
                'icon' => 'fa-brands fa-paypal',
                'enabled' => 0,
                'mode' => 'sandbox',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Insert data into payment_gateway_credentials table
        DB::table('payment_gateway_credentials')->insert([
            [
                'payment_gateway_id' => 2, // For PayPal
                'mode' => 'sandbox',
                'key' => 'PAYPAL_CLIENT_ID',
                'value' => 'AUc_BL5eVCmbDUcBlVCjCWil8XKVaHaVli2vRenxSgm0QSkyI1YZDBFCJWFBXb_C2C7H04CDuUpUjBN8',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'payment_gateway_id' => 2, // For PayPal
                'mode' => 'sandbox',
                'key' => 'PAYPAL_CLIENT_SECRET',
                'value' => 'EM9LYbXEOnyoyZ1J7SuLi7vC-bbHjWVhFhAJWbZBBhC8Seu21A9cZlsHSxk3ekCUPf5gkpyqhpgiRT6M',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'payment_gateway_id' => 1, // For Stripe
                'mode' => 'sandbox',
                'key' => 'STRIPE_KEY',
                'value' => 'pk_test_51PyYjkDpoXnXuIQ8DAZZ7WFJb10fP33E5lpQuehU3VeWSuJLBwl2udcz8zVLiiMhwhSeN32BmHrWn2imeFj5e1mS00qlLHDag3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'payment_gateway_id' => 1, // For Stripe
                'mode' => 'sandbox',
                'key' => 'STRIPE_SECRET',
                'value' => 'sk_test_51PyYjkDpoXnXuIQ8fgtlA26eW29YFXwrtG8cpzulvuPAwOm3tzIne68QML22U9DuacErbvw5J7t4YawCJwLnEHP200AZqQG9aF',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

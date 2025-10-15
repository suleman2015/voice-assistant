<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Support\Breadcrumb;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Language\App\Models\Language;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton('breadcrumb', function () {
            return new Breadcrumb();
        });
 
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
               /** 
         * Dynamically apply SMTP config from settings (your admin form).
         * This honors the values you save via the SMTP Settings form.
         */
        config([
            'mail.default'                     => setting('mail_mailer', 'smtp'),
            'mail.mailers.smtp.transport'      => setting('mail_mailer', 'smtp'),
            'mail.mailers.smtp.host'           => setting('mail_host'),
            'mail.mailers.smtp.port'           => (int) (setting('mail_port') ?: 587),
            'mail.mailers.smtp.encryption'     => setting('mail_encryption') ?: null, // 'tls' | 'ssl' | null
            'mail.mailers.smtp.username'       => setting('mail_username'),
            'mail.mailers.smtp.password'       => setting('mail_password'),
            'mail.from.address'                => setting('mail_from_address') ?: config('mail.from.address'),
            'mail.from.name'                   => setting('mail_from_name') ?: config('mail.from.name'),
        ]);
    }
}

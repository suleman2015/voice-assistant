<?php

namespace Modules\Recaptcha\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Modules\Recaptcha\Models\RecaptchaForm;
use Modules\Recaptcha\Models\RecaptchaSetting;

class VerifyRecaptcha
{
    public function handle($request, Closure $next, $formName)
    {
        $setting = RecaptchaSetting::first();
        if (!$setting || !$setting->enabled) return $next($request);
        if (!RecaptchaForm::isEnabled($formName)) return $next($request);

        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $verify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $setting->secret_key,
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!($verify->json()['success'] ?? false)) {
            return back()->withErrors(['recaptcha' => 'Captcha verification failed'])->withInput();
        }

        return $next($request);
    }
}

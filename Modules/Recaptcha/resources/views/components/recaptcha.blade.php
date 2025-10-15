@if (config('recaptcha.enabled') && \Modules\Recaptcha\Models\RecaptchaForm::isEnabled('contact_form'))
    {!! NoCaptcha::display() !!}
    @push('scripts')
        {!! NoCaptcha::renderJs() !!}
    @endpush
@endif

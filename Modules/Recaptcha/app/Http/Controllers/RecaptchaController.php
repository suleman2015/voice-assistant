<?php

namespace Modules\Recaptcha\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Recaptcha\Models\RecaptchaForm;
use Modules\Recaptcha\Models\RecaptchaSetting;

class RecaptchaController extends Controller
{
    public function index()
    {
        $setting = RecaptchaSetting::first();
        $forms = RecaptchaForm::all();
        return view('recaptcha::recaptcha.index', compact('setting', 'forms'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'enabled' => 'required|boolean', // now always present due to hidden input
            'site_key' => 'nullable|string',
            'secret_key' => 'nullable|string',
        ]);

        RecaptchaSetting::updateOrCreate([], [
            'enabled' => (bool) $request->input('enabled'), // cast to boolean explicitly
            'site_key' => $request->site_key,
            'secret_key' => $request->secret_key,
        ]);

        return back()->with('success', 'Settings updated!');
    }


    public function toggleForm($formId)
    {
        $form = RecaptchaForm::findOrFail($formId);
        $form->enabled = !$form->enabled;
        $form->save();
        return response()->json(['status' => 'ok', 'enabled' => $form->enabled]);
    }
}

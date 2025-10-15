<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Modules\Setting\Models\Setting;


class SettingController extends Controller
{
    public function index()
    {
        $formView = 'setting::components.forms.general_settings';
        $settings = Setting::all();

        return view('setting::index', compact('formView', 'settings'));
    }

    public function smtp()
    {
        $formView = 'setting::components.forms.smtp_settings';
        $settings = Setting::all();
        return view('setting::index', compact('formView', 'settings'));
    }
    public function moduleSettings()
    {
        $formView = 'setting::components.forms.modules_setting';
        $settings = Setting::all();
        return view('setting::index', compact('formView', 'settings'));
    }
    public function websiteTracking()
    {
        $formView = 'setting::components.forms.website_tracking';
        $settings = Setting::all();
        return view('setting::index', compact('formView', 'settings'));
    }

    public function siteAppearence()
    {
        $formView = 'setting::components.forms.site_appearance';
        $settings = Setting::all();

        $apiKey = Setting::where('key', 'google_fonts_api_key')->value('value');
        $googleFonts = [];

        if ($apiKey) {
            $googleFonts = Cache::remember('google_fonts_list', now()->addDays(1), function () use ($apiKey) {
                $response = Http::get("https://www.googleapis.com/webfonts/v1/webfonts?key={$apiKey}&sort=alpha");
                return $response->successful()
                    ? collect($response->json('items'))->pluck('family')->sort()->values()->all()
                    : [];
            });
        }

        return view('setting::index', compact('formView', 'settings', 'googleFonts'));
    }

    public function updateSettings(Request $request)
    {
        // include new image keys for SEO/OG
        $imageKeys = ['favicon', 'header_logo', 'footer_logo', 'dark_logo', 'light_logo', 'og_image'];
        $uploadDir = public_path('settings/images');

        if (! is_dir($uploadDir)) {
            @mkdir($uploadDir, 0775, true);
        }

        foreach ($request->except('_token') as $key => $value) {
            if ($key === 'modules') {
                $submitted = $value;
                $allModules = json_decode(file_get_contents(base_path('modules_statuses.json')), true);
                $cleaned = [];

                foreach ($allModules as $mod => $status) {
                    $isEnabled = $mod === 'Setting' ? 1 : (isset($submitted[$mod]) ? 1 : 0);
                    Setting::updateOrCreate(['key' => $mod], ['value' => $isEnabled]);
                    $cleaned[$mod] = $isEnabled ? true : false;
                }

                file_put_contents(base_path('modules_statuses.json'), json_encode($cleaned, JSON_PRETTY_PRINT));
                continue;
            }

            // Handle removable images (favicon_remove, og_image_remove, etc.)
            if (in_array($key, $imageKeys, true)) {
                if ($request->boolean($key . '_remove')) {
                    $old = setting($key);
                    if ($old && is_file($uploadDir . DIRECTORY_SEPARATOR . $old)) {
                        @unlink($uploadDir . DIRECTORY_SEPARATOR . $old);
                    }
                    Setting::updateOrCreate(['key' => $key], ['value' => null]);
                    continue;
                }
            }

            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $fileName = "{$key}." . $file->getClientOriginalExtension();

                $old = setting($key);
                if ($old && is_file($uploadDir . DIRECTORY_SEPARATOR . $old)) {
                    @unlink($uploadDir . DIRECTORY_SEPARATOR . $old);
                }

                $file->move($uploadDir, $fileName);
                Setting::updateOrCreate(['key' => $key], ['value' => $fileName]);
            } elseif (is_array($value)) {
                $value = implode(',', array_filter($value));
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            } else {
                if ($value === "0" || $value === "1") {
                    $value = (int) $value;
                } else {
                    $value = is_string($value) ? trim($value, '"') : $value;
                }
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}

<?php

use App\Repositories\Contracts\SettingRepositoryInterface;

if (! function_exists('setting')) {
    /**
     * Get a site setting value by key.
     *
     * Usage:
     *   setting('general_site_name')
     *   setting('contact_email_primary', 'fallback@example.com')
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SettingRepositoryInterface::class)->get($key, $default);
    }
}

if (! function_exists('localized')) {
    function localized(mixed $model, string $field, mixed $default = null): mixed
    {
        if (! $model) {
            return $default;
        }

        $locale = app()->getLocale();
        $localizedField = $field.'_'.$locale;
        $localizedValue = data_get($model, $localizedField);

        if ($locale !== 'en' && filled($localizedValue)) {
            if (is_string($localizedValue) && str_starts_with(trim($localizedValue), '[')) {
                return json_decode($localizedValue, true) ?: $localizedValue;
            }

            return $localizedValue;
        }

        return data_get($model, $field, $default);
    }
}

if (! function_exists('language_url')) {
    function language_url(string $locale): string
    {
        return route('language.switch', [
            'locale' => $locale,
            'redirect' => request()->fullUrl(),
        ]);
    }
}

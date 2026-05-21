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
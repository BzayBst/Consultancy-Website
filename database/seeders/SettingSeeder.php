<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [

            // ── General ─────────────────────────────────────────────────
            ['group' => 'general', 'key' => 'general_site_name',    'value' => 'HASU Educational Consultancy', 'type' => 'text'],
            ['group' => 'general', 'key' => 'general_tagline',      'value' => 'Your Trusted Partner in Global Education', 'type' => 'text'],
            ['group' => 'general', 'key' => 'general_logo',         'value' => null,  'type' => 'image'],
            ['group' => 'general', 'key' => 'general_favicon',      'value' => null,  'type' => 'image'],
            ['group' => 'general', 'key' => 'general_established',  'value' => '2013', 'type' => 'text'],
            ['group' => 'general', 'key' => 'general_copyright',    'value' => 'HASU Educational Consultancy. All Rights Reserved.', 'type' => 'text'],

            // ── Contact ─────────────────────────────────────────────────
            ['group' => 'contact', 'key' => 'contact_phone_primary',   'value' => '+977-9800000001', 'type' => 'tel'],
            ['group' => 'contact', 'key' => 'contact_phone_secondary', 'value' => '+977-9800000002', 'type' => 'tel'],
            ['group' => 'contact', 'key' => 'contact_phone_landline',  'value' => '056-789523',      'type' => 'tel'],
            ['group' => 'contact', 'key' => 'contact_email_primary',   'value' => 'info@hasuedu.com', 'type' => 'email'],
            ['group' => 'contact', 'key' => 'contact_email_secondary', 'value' => null,               'type' => 'email'],
            ['group' => 'contact', 'key' => 'contact_address',         'value' => 'Chitwan', 'type' => 'textarea'],
            ['group' => 'contact', 'key' => 'contact_map_embed',       'value' => null, 'type' => 'textarea'],

            // ── Social Media ─────────────────────────────────────────────
            ['group' => 'social', 'key' => 'social_facebook',   'value' => null, 'type' => 'url'],
            ['group' => 'social', 'key' => 'social_instagram',  'value' => null, 'type' => 'url'],
            ['group' => 'social', 'key' => 'social_youtube',    'value' => null, 'type' => 'url'],
            ['group' => 'social', 'key' => 'social_tiktok',     'value' => null, 'type' => 'url'],
            ['group' => 'social', 'key' => 'social_linkedin',   'value' => null, 'type' => 'url'],
            ['group' => 'social', 'key' => 'social_twitter',    'value' => null, 'type' => 'url'],
            ['group' => 'social', 'key' => 'social_whatsapp',   'value' => null, 'type' => 'tel'],

            // ── SEO ─────────────────────────────────────────────────────
            ['group' => 'seo', 'key' => 'seo_meta_title',       'value' => 'HASU Educational Consultancy – Study Abroad from Nepal', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'seo_meta_description', 'value' => 'HASU is Nepal\'s trusted educational consultancy for studying in Japan, Australia, Canada, UK, USA and more.', 'type' => 'textarea'],
            ['group' => 'seo', 'key' => 'seo_meta_keywords',    'value' => 'study abroad Nepal, educational consultancy Bhairahawa, Japan study visa Nepal, IELTS coaching Nepal', 'type' => 'textarea'],
            ['group' => 'seo', 'key' => 'seo_og_image',         'value' => null, 'type' => 'image'],
            ['group' => 'seo', 'key' => 'seo_google_analytics', 'value' => null, 'type' => 'text'],
            ['group' => 'seo', 'key' => 'seo_google_tag',       'value' => null, 'type' => 'text'],

        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Settings seeded: ' . count($settings) . ' keys across 4 groups.');
    }
}
<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Global values the layout reads on every request. Defaults come from the
 * template so a fresh install looks exactly like the static export.
 */
class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $logo = fn (string $file) => Media::where('filename', $file)->value('id');

        $groups = [
            'general' => [
                ['site_name', 'ERA Infotech Ltd.', 'text', 'Site name'],
                ['tagline', 'Marketing Design Agency since 1988', 'text', 'Tagline'],
                ['logo_light_id', $logo('664c33abd0e16d4b14b10a0c_Logo.png'), 'media', 'Logo (light background)'],
                ['logo_dark_id', $logo('668c2e6e687f356e879426a1_Logo-black.svg'), 'media', 'Logo (dark background)'],
                ['favicon_id', $logo('664c37188f9dc64ed32c70a1_favicon.svg'), 'media', 'Favicon'],
                ['webclip_id', $logo('66af85a288a99d56b5f70720_webclip-icon.png'), 'media', 'Apple touch icon'],
            ],
            'seo' => [
                ['meta_title', 'ERA Infotech Ltd.', 'text', 'Default meta title'],
                ['meta_description', '', 'textarea', 'Default meta description'],
                ['og_image_id', $logo('66a9cbc3e1c4cea814648e5b_open-graph-image.webp'), 'media', 'Default share image'],
            ],
            'contact' => [
                ['email', 'hello@edoly.com', 'text', 'Primary email'],
                ['sales_email', 'sales@edoly.com', 'text', 'Sales email'],
                ['office_address', '714 Example location', 'text', 'Office address'],
                ['sales_address', '715 Example location', 'text', 'Sales address'],
                ['phone', '', 'text', 'Phone'],
            ],
            'social' => [
                ['facebook', 'https://www.facebook.com/', 'url', 'Facebook'],
                ['twitter', 'https://twitter.com/', 'url', 'Twitter / X'],
                ['instagram', 'https://www.instagram.com/', 'url', 'Instagram'],
                ['dribbble', 'https://dribbble.com/', 'url', 'Dribbble'],
                ['behance', 'https://www.behance.net/', 'url', 'Behance'],
            ],
            'footer' => [
                ['headline', 'Ready to elevate your brand with Fables?', 'text', 'Footer headline'],
                ['cta_label', 'BUY TEMPLATE', 'text', 'Footer button label'],
                ['cta_url', '/contact', 'url', 'Footer button link'],
                ['big_text', 'edoly', 'text', 'Large footer wordmark'],
                ['copyright', '© All rights reserved. Era Infotech Ltd. Powered by Webflow.', 'text', 'Copyright line'],
                ['newsletter_success', 'Thank you! Your submission has been received!', 'text', 'Newsletter success message'],
                ['newsletter_error', 'Oops! Something went wrong while submitting the form.', 'text', 'Newsletter error message'],
            ],
        ];

        foreach ($groups as $group => $items) {
            foreach ($items as $order => [$key, $value, $type, $label]) {
                Setting::updateOrCreate(
                    ['group' => $group, 'key' => $key],
                    ['value' => $value, 'type' => $type, 'label' => $label, 'sort_order' => $order],
                );
            }
        }
    }
}

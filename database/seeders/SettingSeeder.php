<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Laravel Admin Platform',
                'type' => 'text',
                'group' => 'general',
                'display_name' => 'Site Name',
                'description' => 'The name of your website',
                'is_public' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'A powerful Laravel admin platform with user management and content management',
                'type' => 'textarea',
                'group' => 'general',
                'display_name' => 'Site Description',
                'description' => 'Brief description of your website',
                'is_public' => true,
            ],
            [
                'key' => 'site_keywords',
                'value' => 'laravel, admin, platform, cms',
                'type' => 'text',
                'group' => 'general',
                'display_name' => 'Site Keywords',
                'description' => 'SEO keywords for your website',
                'is_public' => true,
            ],

            // Layout Settings
            [
                'key' => 'header_logo',
                'value' => '',
                'type' => 'image',
                'group' => 'layout',
                'display_name' => 'Header Logo',
                'description' => 'Logo displayed in the header',
                'is_public' => true,
            ],
            [
                'key' => 'footer_logo',
                'value' => '',
                'type' => 'image',
                'group' => 'layout',
                'display_name' => 'Footer Logo',
                'description' => 'Logo displayed in the footer',
                'is_public' => true,
            ],
            [
                'key' => 'header_text',
                'value' => 'Welcome to our platform',
                'type' => 'text',
                'group' => 'layout',
                'display_name' => 'Header Text',
                'description' => 'Text displayed in the header',
                'is_public' => true,
            ],
            [
                'key' => 'footer_text',
                'value' => '© 2024 Laravel Admin Platform. All rights reserved.',
                'type' => 'textarea',
                'group' => 'layout',
                'display_name' => 'Footer Text',
                'description' => 'Text displayed in the footer',
                'is_public' => true,
            ],

            // Contact Settings
            [
                'key' => 'contact_email',
                'value' => 'admin@example.com',
                'type' => 'email',
                'group' => 'contact',
                'display_name' => 'Contact Email',
                'description' => 'Email address for contact form submissions',
                'is_public' => false,
            ],
            [
                'key' => 'contact_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'text',
                'group' => 'contact',
                'display_name' => 'Contact Phone',
                'description' => 'Phone number for contact information',
                'is_public' => true,
            ],
            [
                'key' => 'contact_address',
                'value' => '123 Main Street, City, State 12345',
                'type' => 'textarea',
                'group' => 'contact',
                'display_name' => 'Contact Address',
                'description' => 'Physical address for contact information',
                'is_public' => true,
            ],

            // Social Media Settings
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/yourpage',
                'type' => 'text',
                'group' => 'social',
                'display_name' => 'Facebook URL',
                'description' => 'Facebook page URL',
                'is_public' => true,
            ],
            [
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/yourhandle',
                'type' => 'text',
                'group' => 'social',
                'display_name' => 'Twitter URL',
                'description' => 'Twitter profile URL',
                'is_public' => true,
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/yourhandle',
                'type' => 'text',
                'group' => 'social',
                'display_name' => 'Instagram URL',
                'description' => 'Instagram profile URL',
                'is_public' => true,
            ],
            [
                'key' => 'social_linkedin',
                'value' => 'https://linkedin.com/company/yourcompany',
                'type' => 'text',
                'group' => 'social',
                'display_name' => 'LinkedIn URL',
                'description' => 'LinkedIn company page URL',
                'is_public' => true,
            ],

            // Email Settings
            [
                'key' => 'email_from_name',
                'value' => 'Laravel Admin Platform',
                'type' => 'text',
                'group' => 'email',
                'display_name' => 'Email From Name',
                'description' => 'Name used in outgoing emails',
                'is_public' => false,
            ],
            [
                'key' => 'email_from_address',
                'value' => 'noreply@example.com',
                'type' => 'email',
                'group' => 'email',
                'display_name' => 'Email From Address',
                'description' => 'Email address used for outgoing emails',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}

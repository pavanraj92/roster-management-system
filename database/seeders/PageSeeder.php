<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [

            [
                'title' => 'About Us',
                'subtitle' => 'Know more about our company',
                'slug' => 'about-us',
                'short_description' => 'Learn more about who we are and what we do.',
                'description' => '<p>This is the About Us page content. You can update it from admin panel.</p>',
                'meta_title' => 'About Us',
                'meta_keyword' => 'about us, company info',
                'meta_description' => 'Learn more about our company and services.',
                'status' => 1,
            ],

            [
                'title' => 'Privacy Policy',
                'subtitle' => 'Your data protection matters',
                'slug' => 'privacy-policy',
                'short_description' => 'Our privacy practices and policies.',
                'description' => '<p>This page explains how we collect and use your data.</p>',
                'meta_title' => 'Privacy Policy',
                'meta_keyword' => 'privacy, policy, data protection',
                'meta_description' => 'Read our privacy policy and data protection terms.',
                'status' => 1,
            ],

            [
                'title' => 'Terms & Conditions',
                'subtitle' => 'Rules & Regulations',
                'slug' => 'terms-conditions',
                'short_description' => 'Terms and conditions of using our website.',
                'description' => '<p>This page outlines the terms and conditions.</p>',
                'meta_title' => 'Terms & Conditions',
                'meta_keyword' => 'terms, conditions, agreement',
                'meta_description' => 'Read the terms and conditions of our website.',
                'status' => 1,
            ],

            [
                'title' => 'Contact Us',
                'subtitle' => 'Get in touch with us',
                'slug' => 'contact-us',
                'short_description' => 'Contact information and support details.',
                'description' => '<p>You can contact us using the details provided on this page.</p>',
                'meta_title' => 'Contact Us',
                'meta_keyword' => 'contact, support, help',
                'meta_description' => 'Get in touch with our support team.',
                'status' => 1,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['title' => $page['title']], // condition
                $page
            );
        }
    }
}

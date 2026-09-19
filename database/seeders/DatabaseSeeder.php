<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ──────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'      => 'مدير النظام',
                'password'  => Hash::make('12345678'),
                'role'      => 'admin',
                'is_active' => true,
                'phone'     => '01234567890',
            ]
        );

        // ── Categories ──────────────────────────────────────────────
        // $categories = [
        //     ['slug' => 'printers',   'name_ar' => 'طابعات', 'name_en' => 'Printers', 'icon' => 'print'],
        //     ['slug' => 'mice',       'name_ar' => 'ماوسات', 'name_en' => 'Mice',     'icon' => 'mouse'],
        //     ['slug' => 'headphones', 'name_ar' => 'سماعات', 'name_en' => 'Headphones', 'icon' => 'headphones'],
        //     ['slug' => 'flash',      'name_ar' => 'فلاشات', 'name_en' => 'Flash Drives', 'icon' => 'usb'],
        // ];

        // foreach ($categories as $cat) {
        //     \App\Models\Category::firstOrCreate(
        //         ['slug' => $cat['slug']],
        //         [
        //             'name_ar'   => $cat['name_ar'],
        //             'name_en'   => $cat['name_en'],
        //             'icon'      => $cat['icon'],
        //             'is_active' => true,
        //         ]
        //     );
        // }

        // ── Auto Sync Products from External API ─────────────────────
        $apiUrl = \App\Models\Setting::get('products_api_url', env('PRODUCTS_API_URL'));
        if (!empty($apiUrl)) {
            $apiToken = \App\Models\Setting::get('products_api_token', env('PRODUCTS_API_TOKEN'));
            $syncService = app(\App\Services\ExternalProductSyncService::class);
            $syncService->sync($apiUrl, $apiToken);
        }
    }
}

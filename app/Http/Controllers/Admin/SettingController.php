<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $products = \App\Models\Product::active()->get();
        return view('admin.settings.index', compact('settings', 'products'));
    }

    public function update(Request $request)
    {
        $keys = [
            'home_show_deal',
            'home_deal_product_id',
            'home_deal_end_time',
            'home_show_brands',
            'home_show_recommended',
            'home_show_newsletter',
            'home_show_faq',
            'home_show_track_order',
            'products_api_url',
            'products_api_token',
        ];

        foreach ($keys as $key) {
            $value = $request->has($key) ? $request->input($key) : ($request->has('submitted') ? '0' : null);
            if ($value !== null) {
                Setting::set($key, $value);
            }
        }

        \App\Services\CacheService::clearSettingsCaches();
        \Illuminate\Support\Facades\Cache::flush(); // Flush all public caches safely on settings update

        // Automatically sync products if API URL is configured
        $syncMessage = '';
        $apiUrl = trim(Setting::get('products_api_url', ''));
        if (!empty($apiUrl)) {
            try {
                $syncService = app(\App\Services\ExternalProductSyncService::class);
                $syncResult = $syncService->sync($apiUrl, Setting::get('products_api_token'));
                if ($syncResult['success']) {
                    $syncMessage = ' تم تحديث ومزامنة منتجات الـ API بنجاح (' . $syncResult['count'] . ' منتج).';
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Setting update auto-sync failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'تم حفظ الإعدادات بنجاح.' . ($syncMessage ? ' ' . $syncMessage : ''));
    }

    public function syncApi(Request $request, \App\Services\ExternalProductSyncService $syncService)
    {
        // Save current API URL & token if provided in request
        if ($request->filled('products_api_url')) {
            Setting::set('products_api_url', $request->input('products_api_url'));
        }
        if ($request->has('products_api_token')) {
            Setting::set('products_api_token', $request->input('products_api_token'));
        }

        $result = $syncService->sync(
            $request->input('products_api_url'),
            $request->input('products_api_token')
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($result, $result['success'] ? 200 : 422);
        }

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }
}


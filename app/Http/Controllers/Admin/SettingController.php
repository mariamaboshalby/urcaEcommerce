<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $products = \App\Models\Product::active()->get();

        // Slider slides come solely from admin-configured settings.
        // If nothing has been added, the list stays empty (front-end hides the slider).
        $sliderSlides = json_decode($settings['slider_images'] ?? '[]', true) ?: [];

        return view('admin.settings.index', compact('settings', 'products', 'sliderSlides'));
    }

    public function update(Request $request)
    {
        // Validate any uploaded slider images
        Validator::make($request->all(), [
            'slider_image'   => 'nullable|array',
            'slider_image.*' => 'nullable|image|mimes:jpeg,png,webp|max:4096',
            'slider_link'    => 'nullable|array',
            'slider_link.*'  => 'nullable|string|max:500',
        ])->validate();

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

        $this->handleSliderImages($request);

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

    /**
     * Persist the (dynamic) ordered list of hero slides. Each slide may carry a custom
     * uploaded image, an optional default image reference, and an optional click-through link.
     * Slides removed in the UI are simply absent from the submitted rows and get dropped here.
     */
    private function handleSliderImages(Request $request): void
    {
        $count = (int) $request->input('slider_count', 0);
        $slides = [];

        for ($i = 0; $i < $count; $i++) {
            $image = $request->input("slider_current.$i") ?: null; // existing custom upload (if any)
            $src = $request->input("slider_src.$i") ?: null;       // default asset reference (if any)
            $link = trim((string) $request->input("slider_link.$i", ''));

            // Replace image if a new one is uploaded (keep $src as a revert-to-default fallback)
            if ($request->hasFile("slider_image.$i")) {
                if ($image) {
                    Storage::disk('public')->delete($image);
                }
                $image = $request->file("slider_image.$i")->store('slider', 'public');
            }

            // Remove custom image (revert to default if one is referenced)
            if ($request->boolean("remove_image.$i") && $image) {
                Storage::disk('public')->delete($image);
                $image = null;
            }

            // A slide is kept only if it resolves to an image (custom or default)
            if ($image || $src) {
                $slides[] = [
                    'image' => $image,
                    'src' => $src,
                    'link' => $link !== '' ? $link : null,
                ];
            }
        }

        Setting::set('slider_images', json_encode($slides));
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


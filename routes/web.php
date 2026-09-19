<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\DownloadController as AdminDownloadController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\OrderController;


use App\Http\Controllers\WishlistController;

// ── Auth ──────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Checkout (auth required) ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/checkout',                          [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout',                         [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{orderNumber}',    [CheckoutController::class, 'success'])->name('checkout.success');
});

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Language Switch
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{category}', [ProductController::class, 'category'])->name('products.category');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// News
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about.index');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/items', [CartController::class, 'items'])->name('cart.items');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Testimonials
Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

// Newsletter
Route::post('/newsletter/subscribe', [SubscriberController::class, 'store'])->name('newsletter.subscribe');

// ── Wishlist ──────────────────────────────────────────────────────────────
// Sync: works for guests too (after login, JS calls this)
Route::post('/wishlist/sync', [WishlistController::class, 'sync'])->name('wishlist.sync')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/wishlist',                    [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}',  [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{product}',       [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

// Track Order
Route::get('/track-order', [OrderController::class, 'track'])->name('track-order');
Route::post('/track-order', [OrderController::class, 'trackStatus'])->name('track-order.status');
Route::get('/orders/{order}/detail', [OrderController::class, 'detail'])->name('orders.detail')->middleware('auth');
Route::post('/orders/quick', [OrderController::class, 'quickOrder'])->name('orders.quick');

// ============================================================
// Admin Dashboard (URL prefix: /urcaAdm)
// ============================================================
Route::prefix('urcaAdm')->name('admin.')->middleware('admin')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);

    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::patch('orders/{order}/payment', [AdminOrderController::class, 'updatePayment'])->name('orders.payment');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Users
    Route::resource('users', AdminUserController::class);
    Route::patch('users/{user}/toggle', [AdminUserController::class, 'toggleStatus'])->name('users.toggle');

    // Blog
    Route::resource('blog', AdminBlogController::class);

    // Downloads
    Route::resource('downloads', AdminDownloadController::class);

    // About
    Route::get('about', [AdminAboutController::class, 'index'])->name('about.index');
    Route::post('about/stats',              [AdminAboutController::class, 'storeStat'])->name('about.stats.store');
    Route::put('about/stats/{stat}',        [AdminAboutController::class, 'updateStat'])->name('about.stats.update');
    Route::delete('about/stats/{stat}',     [AdminAboutController::class, 'destroyStat'])->name('about.stats.destroy');
    Route::post('about/team',               [AdminAboutController::class, 'storeTeam'])->name('about.team.store');
    Route::put('about/team/{team}',         [AdminAboutController::class, 'updateTeam'])->name('about.team.update');
    Route::delete('about/team/{team}',      [AdminAboutController::class, 'destroyTeam'])->name('about.team.destroy');
    Route::post('about/values',             [AdminAboutController::class, 'storeValue'])->name('about.values.store');
    Route::put('about/values/{value}',      [AdminAboutController::class, 'updateValue'])->name('about.values.update');
    Route::delete('about/values/{value}',   [AdminAboutController::class, 'destroyValue'])->name('about.values.destroy');

    // Testimonials
    Route::get('testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('testimonials/{id}/approve', [AdminTestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::post('testimonials/{id}/reject', [AdminTestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::delete('testimonials/{id}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Settings & Home Sections
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::post('settings/sync-api', [AdminSettingController::class, 'syncApi'])->name('settings.sync_api');
    Route::resource('brands', AdminBrandController::class);
    Route::resource('faqs', AdminFaqController::class);
});

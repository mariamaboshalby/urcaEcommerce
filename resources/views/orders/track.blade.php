@extends('layouts.app')
@section('title', (app()->getLocale() === 'ar' ? 'تتبع الطلب' : 'Track Order') . ' - urca')

@section('content')

    {{-- Hero --}}
    <div style="background:linear-gradient(135deg,#0f172a 0%,#030f1f 100%);padding:3rem 0;">
        <div class="container text-center">
            <div class="track-icon-hero mx-auto mb-3">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <h1 class="text-white fw-bold mb-2">
                {{ app()->getLocale() === 'ar' ? 'تتبع طلبك' : 'Track Your Order' }}
            </h1>
            <p class="text-white-50 mb-0">
                {{ app()->getLocale() === 'ar' ? 'أدخل رقم طلبك لمعرفة حالته الحالية' : 'Enter your order number to check its current status' }}
            </p>
        </div>
    </div>

    {{-- Breadcrumb --}}
    <div class="bg-white border-bottom py-2">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size:.875rem;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-primary text-decoration-none">{{ __('app.nav_home') }}</a>
                    </li>
                    <li class="breadcrumb-item active text-muted">
                        {{ app()->getLocale() === 'ar' ? 'تتبع الطلب' : 'Track Order' }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5" style="background:#f8fafc;">
        <div class="container">

            @auth
                {{-- ===== LOGGED-IN: My Orders List ===== --}}
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fas fa-box-open text-primary me-2"></i>
                                {{ app()->getLocale() === 'ar' ? 'طلباتي' : 'My Orders' }}
                            </h5>
                            <span class="text-muted small">
                                {{ app()->getLocale() === 'ar' ? 'إجمالي الطلبات:' : 'Total orders:' }}
                                <strong>{{ $orders->count() }}</strong>
                            </span>
                        </div>
                    </div>

                    @if ($orders->isEmpty())
                        <div class="col-12">
                            <div class="track-card text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">
                                    {{ app()->getLocale() === 'ar' ? 'لا توجد طلبات حتى الآن.' : 'No orders yet.' }}
                                </h6>
                                <a href="{{ route('home') }}" class="btn btn-primary btn-sm mt-2 rounded-pill px-4">
                                    {{ app()->getLocale() === 'ar' ? 'تسوق الآن' : 'Shop Now' }}
                                </a>
                            </div>
                        </div>
                    @else
                        @foreach ($orders as $order)
                            <div class="col-12 mb-3">
                                <div class="order-row-card" onclick="openOrderModal({{ $order->id }})" role="button"
                                    tabindex="0" onkeydown="if(event.key==='Enter')openOrderModal({{ $order->id }})">
                                    <div class="order-row-body">
                                        <div class="order-row-icon flex-shrink-0">
                                            @if ($order->status === 'delivered')
                                                <i class="fas fa-check-circle text-success"></i>
                                            @elseif($order->status === 'shipped')
                                                <i class="fas fa-shipping-fast text-purple"></i>
                                            @elseif($order->status === 'processing')
                                                <i class="fas fa-cog text-primary"></i>
                                            @elseif($order->status === 'cancelled')
                                                <i class="fas fa-times-circle text-danger"></i>
                                            @else
                                                <i class="fas fa-clock text-warning"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                                <span class="fw-bold text-dark order-num">#{{ $order->order_number }}</span>
                                                <span
                                                    class="order-status-badge badge-{{ $order->status }}">{{ $order->status_label }}</span>
                                            </div>
                                            <div class="text-muted small d-flex flex-wrap gap-3">
                                                <span><i
                                                        class="fas fa-calendar-alt me-1"></i>{{ $order->created_at->format('d M Y') }}</span>
                                                <span><i class="fas fa-boxes me-1"></i>{{ $order->items->sum('quantity') }}
                                                    {{ app()->getLocale() === 'ar' ? 'قطعة' : 'item(s)' }}</span>
                                                <span><i
                                                        class="fas fa-credit-card me-1"></i>{{ $order->payment_status_label }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                            <span class="fw-bold text-primary fs-6">{{ number_format($order->total, 2) }}
                                                <small class="text-muted fw-normal">EGP</small></span>
                                            <i class="fas fa-chevron-left text-muted order-arrow"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- Search by number --}}
                    <div class="col-12 mt-3">
                        <div class="track-card">
                            <div class="track-card-header">
                                <i class="fas fa-search text-primary me-2"></i>
                                {{ app()->getLocale() === 'ar' ? 'ابحث بالرقم' : 'Search by Number' }}
                            </div>
                            <div class="p-4">
                                <div class="track-input-group">
                                    <i class="fas fa-hashtag track-input-icon"></i>
                                    <input type="text" id="orderInput" class="track-input"
                                        placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: urca-ABC123' : 'e.g. urca-ABC123' }}"
                                        value="{{ request('order') }}" autocomplete="off">
                                    <button id="trackBtn" class="track-submit-btn" onclick="trackOrder()">
                                        <span class="btn-text"><i
                                                class="fas fa-search me-1"></i>{{ app()->getLocale() === 'ar' ? 'تتبع' : 'Track' }}</span>
                                        <span class="btn-loading d-none"><i class="fas fa-spinner fa-spin me-1"></i></span>
                                    </button>
                                </div>
                                <div id="trackResult" class="mt-3 d-none">
                                    <div id="trackError" class="d-none">
                                        <div class="alert-card alert-danger-custom">
                                            <i class="fas fa-times-circle alert-icon"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1">
                                                    {{ app()->getLocale() === 'ar' ? 'طلب غير موجود' : 'Order Not Found' }}
                                                </h6>
                                                <p class="mb-0 small" id="errorMsg"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END @auth --}}
            @endauth

            @guest
                {{-- ===== GUEST: Guest orders from cookie + Search form ===== --}}
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-xl-6">

                        {{-- Guest orders list (from cookie) --}}
                        @if (!empty($guestOrders) && $guestOrders->isNotEmpty())
                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fw-bold text-dark mb-0">
                                        <i class="fas fa-history text-primary me-2"></i>
                                        {{ app()->getLocale() === 'ar' ? 'طلباتك الأخيرة' : 'Your Recent Orders' }}
                                    </h6>
                                    <span class="text-muted small">{{ $guestOrders->count() }}
                                        {{ app()->getLocale() === 'ar' ? 'طلب' : 'order(s)' }}</span>
                                </div>
                                @foreach ($guestOrders as $gOrder)
                                    <div class="order-row-card mb-3" onclick="guestTrackOrder('{{ $gOrder->order_number }}')"
                                        role="button" tabindex="0"
                                        onkeydown="if(event.key==='Enter')guestTrackOrder('{{ $gOrder->order_number }}')">
                                        <div class="order-row-body">
                                            <div class="order-row-icon flex-shrink-0">
                                                @if ($gOrder->status === 'delivered')
                                                    <i class="fas fa-check-circle text-success"></i>
                                                @elseif($gOrder->status === 'shipped')
                                                    <i class="fas fa-shipping-fast text-purple"></i>
                                                @elseif($gOrder->status === 'processing')
                                                    <i class="fas fa-cog text-primary"></i>
                                                @elseif($gOrder->status === 'cancelled')
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                @else
                                                    <i class="fas fa-clock text-warning"></i>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                                    <span
                                                        class="fw-bold text-dark order-num">#{{ $gOrder->order_number }}</span>
                                                    <span
                                                        class="order-status-badge badge-{{ $gOrder->status }}">{{ $gOrder->status_label }}</span>
                                                </div>
                                                <div class="text-muted small d-flex flex-wrap gap-3">
                                                    <span><i
                                                            class="fas fa-calendar-alt me-1"></i>{{ $gOrder->created_at->format('d M Y') }}</span>
                                                    <span><i
                                                            class="fas fa-boxes me-1"></i>{{ $gOrder->items->sum('quantity') }}
                                                        {{ app()->getLocale() === 'ar' ? 'قطعة' : 'item(s)' }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                                <span class="fw-bold text-primary fs-6">{{ number_format($gOrder->total, 2) }}
                                                    <small class="text-muted fw-normal">EGP</small></span>
                                                <i class="fas fa-chevron-left text-muted order-arrow"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Search form --}}
                        <div class="track-card mb-4">
                            <div class="track-card-header">
                                <i class="fas fa-search-location me-2 text-primary"></i>
                                {{ app()->getLocale() === 'ar' ? 'ابحث عن طلبك' : 'Find Your Order' }}
                            </div>
                            <div class="p-4">
                                <div class="track-input-group">
                                    <i class="fas fa-hashtag track-input-icon"></i>
                                    <input type="text" id="orderInput" class="track-input"
                                        placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: urca-ABC123' : 'e.g. urca-ABC123' }}"
                                        value="{{ request('order') }}" autocomplete="off" spellcheck="false">
                                    <button id="trackBtn" class="track-submit-btn" onclick="trackOrder()">
                                        <span class="btn-text"><i
                                                class="fas fa-search me-1"></i>{{ app()->getLocale() === 'ar' ? 'تتبع' : 'Track' }}</span>
                                        <span class="btn-loading d-none"><i class="fas fa-spinner fa-spin me-1"></i></span>
                                    </button>
                                </div>
                                <p class="text-muted small mt-2 mb-0">
                                    <i class="fas fa-info-circle text-primary me-1"></i>
                                    {{ app()->getLocale() === 'ar' ? 'رقم الطلب موجود في رسالة التأكيد المرسلة إليك.' : 'Your order number can be found in your confirmation message.' }}
                                </p>
                            </div>
                        </div>

                        {{-- Search result (guest inline) --}}
                        <div id="trackResult" class="d-none">
                            <div id="trackError" class="d-none">
                                <div class="alert-card alert-danger-custom mb-3">
                                    <i class="fas fa-times-circle alert-icon"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            {{ app()->getLocale() === 'ar' ? 'طلب غير موجود' : 'Order Not Found' }}</h6>
                                        <p class="mb-0 small" id="errorMsg"></p>
                                    </div>
                                </div>
                            </div>
                            <div id="trackSuccess" class="d-none">
                                <div class="track-card mb-4">
                                    <div class="track-card-header d-flex align-items-center justify-content-between">
                                        <span><i
                                                class="fas fa-receipt me-2 text-primary"></i>{{ app()->getLocale() === 'ar' ? 'تفاصيل الطلب' : 'Order Details' }}</span>
                                        <span id="statusBadge" class="order-status-badge"></span>
                                    </div>
                                    <div class="p-4">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="order-detail-item">
                                                    <span
                                                        class="detail-label">{{ app()->getLocale() === 'ar' ? 'رقم الطلب' : 'Order #' }}</span>
                                                    <span class="detail-val fw-bold text-primary"
                                                        id="displayOrderNum">—</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="order-detail-item">
                                                    <span
                                                        class="detail-label">{{ app()->getLocale() === 'ar' ? 'اسم العميل' : 'Customer' }}</span>
                                                    <span class="detail-val" id="displayCustomer">—</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="order-detail-item">
                                                    <span
                                                        class="detail-label">{{ app()->getLocale() === 'ar' ? 'تاريخ الطلب' : 'Date' }}</span>
                                                    <span class="detail-val" id="displayDate">—</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="order-detail-item">
                                                    <span
                                                        class="detail-label">{{ app()->getLocale() === 'ar' ? 'إجمالي الطلب' : 'Total' }}</span>
                                                    <span class="detail-val fw-bold" id="displayTotal">—</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="order-detail-item">
                                                    <span
                                                        class="detail-label">{{ app()->getLocale() === 'ar' ? 'عدد القطع' : 'Items' }}</span>
                                                    <span class="detail-val" id="displayItems">—</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="order-detail-item">
                                                    <span
                                                        class="detail-label">{{ app()->getLocale() === 'ar' ? 'حالة الدفع' : 'Payment' }}</span>
                                                    <span class="detail-val" id="displayPayment">—</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="track-card">
                                    <div class="track-card-header">
                                        <i class="fas fa-route me-2 text-primary"></i>
                                        {{ app()->getLocale() === 'ar' ? 'مسار الطلب' : 'Order Progress' }}
                                    </div>
                                    <div class="p-4">
                                        <div class="order-steps" id="orderSteps"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Help box --}}
                        <div class="track-card mt-4">
                            <div class="p-4 d-flex gap-4 align-items-center flex-wrap">
                                <div class="help-icon flex-shrink-0"><i class="fas fa-headset"></i></div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1">
                                        {{ app()->getLocale() === 'ar' ? 'محتاج مساعدة؟' : 'Need Help?' }}</h6>
                                    <p class="text-secondary small mb-0">
                                        {{ app()->getLocale() === 'ar' ? 'فريقنا متاح طوال الأسبوع للرد على استفساراتك.' : 'Our team is available all week to answer your questions.' }}
                                    </p>
                                </div>
                                <div class="d-flex gap-2 flex-shrink-0">
                                    <a href="tel:+201093803270" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-phone me-1"></i>{{ app()->getLocale() === 'ar' ? 'اتصل' : 'Call' }}
                                    </a>
                                    <a href="https://wa.me/201093803270" target="_blank"
                                        class="btn btn-sm btn-success rounded-pill px-3">
                                        <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- END @guest --}}
            @endguest

        </div>
    </section>

    {{-- ===== Order Detail Modal (auth only) ===== --}}
    @auth
        <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 rounded-4 overflow-hidden">

                    <div class="modal-header border-0 px-4 pt-4 pb-3" style="background:#f8fafc;">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <div class="modal-order-icon"><i class="fas fa-receipt"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" id="modal-order-number">—</h6>
                                <div id="modal-status-badge" class="mt-1"></div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body px-4 py-3">
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3">
                                <div class="order-detail-item">
                                    <span
                                        class="detail-label">{{ app()->getLocale() === 'ar' ? 'تاريخ الطلب' : 'Date' }}</span>
                                    <span class="detail-val" id="modal-date">—</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="order-detail-item">
                                    <span class="detail-label">{{ app()->getLocale() === 'ar' ? 'الإجمالي' : 'Total' }}</span>
                                    <span class="detail-val fw-bold text-primary" id="modal-total">—</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="order-detail-item">
                                    <span
                                        class="detail-label">{{ app()->getLocale() === 'ar' ? 'طريقة الدفع' : 'Payment' }}</span>
                                    <span class="detail-val" id="modal-payment">—</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="order-detail-item">
                                    <span
                                        class="detail-label">{{ app()->getLocale() === 'ar' ? 'حالة الدفع' : 'Pay Status' }}</span>
                                    <span class="detail-val" id="modal-payment-status">—</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="order-detail-item">
                                    <span
                                        class="detail-label">{{ app()->getLocale() === 'ar' ? 'عنوان التوصيل' : 'Address' }}</span>
                                    <span class="detail-val" id="modal-address">—</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="order-detail-item">
                                    <span class="detail-label">{{ app()->getLocale() === 'ar' ? 'المدينة' : 'City' }}</span>
                                    <span class="detail-val" id="modal-city">—</span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="order-detail-item">
                                    <span class="detail-label">{{ app()->getLocale() === 'ar' ? 'الهاتف' : 'Phone' }}</span>
                                    <span class="detail-val" id="modal-phone">—</span>
                                </div>
                            </div>
                        </div>

                        <div class="track-card mb-4">
                            <div class="track-card-header">
                                <i class="fas fa-route me-2 text-primary"></i>
                                {{ app()->getLocale() === 'ar' ? 'مسار الطلب' : 'Order Progress' }}
                            </div>
                            <div class="p-4">
                                <div class="order-steps" id="modal-steps"></div>
                            </div>
                        </div>

                        <div class="track-card">
                            <div class="track-card-header">
                                <i class="fas fa-list me-2 text-primary"></i>
                                {{ app()->getLocale() === 'ar' ? 'المنتجات' : 'Items' }}
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead style="background:#f8fafc;font-size:.8rem;color:#64748b;">
                                        <tr>
                                            <th class="ps-4">{{ app()->getLocale() === 'ar' ? 'المنتج' : 'Product' }}</th>
                                            <th class="text-center">{{ app()->getLocale() === 'ar' ? 'الكمية' : 'Qty' }}</th>
                                            <th class="text-center">{{ app()->getLocale() === 'ar' ? 'السعر' : 'Price' }}</th>
                                            <th class="text-center pe-4">
                                                {{ app()->getLocale() === 'ar' ? 'الإجمالي' : 'Total' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modal-items-body"></tbody>
                                    <tfoot id="modal-items-foot" style="background:#f8fafc;"></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 py-3" style="background:#f8fafc;">
                        <a href="https://wa.me/201093803270" target="_blank" class="btn btn-success rounded-pill px-4">
                            <i class="fab fa-whatsapp me-1"></i>
                            {{ app()->getLocale() === 'ar' ? 'تواصل معنا' : 'Contact Us' }}
                        </a>
                        <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            {{ app()->getLocale() === 'ar' ? 'إغلاق' : 'Close' }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endauth

@endsection

@push('styles')
    <style>
        .track-icon-hero {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, .15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, .3);
        }

        .track-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .track-card-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.25rem;
            font-weight: 700;
            font-size: .9375rem;
            color: #0f172a;
            display: flex;
            align-items: center;
        }

        .order-row-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
            transition: all .25s ease;
            cursor: pointer;
        }

        .order-row-card:hover {
            border-color: #051836;
            box-shadow: 0 6px 24px rgba(5, 24, 54, .12);
            transform: translateY(-2px);
        }

        .order-row-body {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.1rem 1.25rem;
        }

        .order-row-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .order-num {
            font-size: .9375rem;
        }

        .order-arrow {
            transition: transform .2s;
        }

        .order-row-card:hover .order-arrow {
            transform: translateX(-4px);
        }

        [dir="rtl"] .order-row-card:hover .order-arrow {
            transform: translateX(4px);
        }

        .text-purple {
            color: #7c3aed;
        }

        .track-input-group {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: .375rem .375rem .375rem 1rem;
            transition: all .3s ease;
        }

        .track-input-group:focus-within {
            border-color: #051836;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .1);
            background: #fff;
        }

        .track-input-icon {
            color: #94a3b8;
            margin-right: .5rem;
            flex-shrink: 0;
        }

        .track-input {
            flex: 1;
            border: none;
            background: none;
            outline: none;
            font-size: 1rem;
            color: #0f172a;
            font-weight: 500;
        }

        .track-submit-btn {
            background: linear-gradient(135deg, #051836, #0a2e5c);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .65rem 1.5rem;
            font-size: .9375rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s ease;
            flex-shrink: 0;
        }

        .track-submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, .35);
        }

        .alert-card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            border-radius: 14px;
        }

        .alert-danger-custom {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
            margin-top: .1rem;
            color: #ef4444;
        }

        .order-status-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .3rem .85rem;
            border-radius: 50px;
            font-size: .78rem;
            font-weight: 700;
        }

        .badge-pending {
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }

        .badge-processing {
            background: #e8edf5;
            color: #030f1f;
            border: 1px solid #c3d0e3;
        }

        .badge-shipped {
            background: #f5f3ff;
            color: #7c3aed;
            border: 1px solid #ddd6fe;
        }

        .badge-delivered {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .badge-cancelled {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .order-detail-item {
            display: flex;
            flex-direction: column;
            gap: .2rem;
        }

        .detail-label {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #94a3b8;
            font-weight: 600;
        }

        .detail-val {
            font-size: .9375rem;
            color: #0f172a;
        }

        .order-steps {
            position: relative;
            padding: .5rem 0;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            position: relative;
            padding-bottom: 2rem;
        }

        .step-item:last-child {
            padding-bottom: 0;
        }

        .step-item::before {
            content: '';
            position: absolute;
            left: 19px;
            top: 40px;
            bottom: 0;
            width: 2px;
            background: #e2e8f0;
        }

        [dir="rtl"] .step-item::before {
            left: auto;
            right: 19px;
        }

        .step-item.done::before {
            background: #10b981;
        }

        .step-item:last-child::before {
            display: none;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
            transition: all .3s ease;
        }

        .step-circle.done {
            background: #10b981;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, .15);
        }

        .step-circle.current {
            background: #051836;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .2);
            animation: pulse-step 2s infinite;
        }

        .step-circle.pending {
            background: #f1f5f9;
            color: #94a3b8;
            border: 2px solid #e2e8f0;
        }

        @keyframes pulse-step {

            0%,
            100% {
                box-shadow: 0 0 0 4px rgba(37, 99, 235, .2);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(37, 99, 235, .1);
            }
        }

        .step-body {
            flex: 1;
            padding-top: .5rem;
        }

        .step-title {
            font-weight: 700;
            font-size: .9375rem;
            color: #0f172a;
            margin-bottom: .1rem;
        }

        .step-title.pending {
            color: #94a3b8;
        }

        .step-desc {
            font-size: .8125rem;
            color: #94a3b8;
        }

        .help-icon {
            width: 56px;
            height: 56px;
            background: #e8edf5;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #051836;
        }

        .modal-order-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #e8edf5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #051836;
        }

        #orderDetailModal .modal-content {
            box-shadow: 0 25px 60px rgba(0, 0, 0, .15);
        }
    </style>
@endpush

@push('scripts')
    <script>
        const isAr = document.documentElement.lang === 'ar';

        const stepConfig = [{
                key: 'pending',
                icon: 'fa-clock',
                label: isAr ? 'تم استلام الطلب' : 'Order Received',
                desc: isAr ? 'تم استلام طلبك وسيتم مراجعته قريباً.' : 'Your order has been received.'
            },
            {
                key: 'processing',
                icon: 'fa-box',
                label: isAr ? 'قيد التجهيز' : 'Processing',
                desc: isAr ? 'يتم تجهيز طلبك وتحضير القطع.' : 'Your order is being prepared.'
            },
            {
                key: 'shipped',
                icon: 'fa-shipping-fast',
                label: isAr ? 'تم الشحن' : 'Shipped',
                desc: isAr ? 'طلبك في الطريق إليك!' : 'Your order is on its way!'
            },
            {
                key: 'delivered',
                icon: 'fa-check-circle',
                label: isAr ? 'تم التسليم' : 'Delivered',
                desc: isAr ? 'تم تسليم طلبك بنجاح.' : 'Your order has been delivered.'
            },
        ];

        const statusColors = {
            pending: 'badge-pending',
            processing: 'badge-processing',
            shipped: 'badge-shipped',
            delivered: 'badge-delivered',
            cancelled: 'badge-cancelled'
        };

        const paymentLabels = {
            unpaid: isAr ? '⚠ غير مدفوع' : '⚠ Unpaid',
            paid: isAr ? '✓ مدفوع' : '✓ Paid',
            refunded: isAr ? '↩ مسترد' : '↩ Refunded',
        };

        function buildSteps(containerEl, status) {
            const steps = ['pending', 'processing', 'shipped', 'delivered'];
            const currentStep = steps.indexOf(status);
            containerEl.innerHTML = '';
            stepConfig.forEach((step, i) => {
                let state = 'pending';
                if (i < currentStep) state = 'done';
                else if (i === currentStep) state = 'current';
                if (status === 'cancelled') state = (i === 0) ? 'done' : 'pending';
                containerEl.innerHTML += `
            <div class="step-item ${state === 'done' ? 'done' : ''}">
                <div class="step-circle ${state}"><i class="fas ${state === 'done' ? 'fa-check' : step.icon}"></i></div>
                <div class="step-body">
                    <div class="step-title ${state === 'pending' ? 'pending' : ''}">${step.label}</div>
                    <div class="step-desc">${state !== 'pending' ? step.desc : (isAr ? 'في انتظار الخطوات السابقة' : 'Waiting for previous steps')}</div>
                </div>
            </div>`;
            });
            if (status === 'cancelled') {
                containerEl.innerHTML += `
            <div class="step-item">
                <div class="step-circle" style="background:#fef2f2;border:2px solid #fecaca;color:#ef4444;"><i class="fas fa-times"></i></div>
                <div class="step-body">
                    <div class="step-title" style="color:#ef4444;">${isAr ? 'تم إلغاء الطلب' : 'Order Cancelled'}</div>
                    <div class="step-desc">${isAr ? 'تم إلغاء هذا الطلب.' : 'This order has been cancelled.'}</div>
                </div>
            </div>`;
            }
        }

        @auth
        /* ── Open order detail modal (logged-in) ── */
        function openOrderModal(orderId) {
            fetch(`/orders/${orderId}/detail`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) return;
                    const o = data.order;

                    document.getElementById('modal-order-number').textContent = '#' + o.order_number;
                    const badge = document.getElementById('modal-status-badge');
                    badge.innerHTML =
                        `<span class="order-status-badge ${statusColors[o.status] || 'badge-pending'}">${o.status_label}</span>`;

                    document.getElementById('modal-date').textContent = o.created_at;
                    document.getElementById('modal-total').textContent = o.total + ' EGP';
                    document.getElementById('modal-payment').textContent = o.payment_method_label;
                    document.getElementById('modal-payment-status').textContent = paymentLabels[o.payment_status] || o
                        .payment_status;
                    document.getElementById('modal-address').textContent = o.customer_address || '—';
                    document.getElementById('modal-city').textContent = o.city || '—';
                    document.getElementById('modal-phone').textContent = o.customer_phone || '—';

                    buildSteps(document.getElementById('modal-steps'), o.status);

                    const tbody = document.getElementById('modal-items-body');
                    tbody.innerHTML = '';
                    (o.items || []).forEach(item => {
                        tbody.innerHTML += `
                <tr>
                    <td class="ps-4">${item.product_name}</td>
                    <td class="text-center">${item.quantity}</td>
                    <td class="text-center">${parseFloat(item.price).toFixed(2)} EGP</td>
                    <td class="text-center pe-4">${parseFloat(item.total).toFixed(2)} EGP</td>
                </tr>`;
                    });

                    document.getElementById('modal-items-foot').innerHTML = `
            <tr>
                <td colspan="3" class="ps-4 text-muted small">${isAr ? 'الشحن' : 'Shipping'}</td>
                <td class="text-center pe-4 text-muted small">${parseFloat(o.shipping).toFixed(2)} EGP</td>
            </tr>
            <tr>
                <td colspan="3" class="ps-4 fw-bold">${isAr ? 'الإجمالي' : 'Total'}</td>
                <td class="text-center pe-4 fw-bold text-primary">${parseFloat(o.total).toFixed(2)} EGP</td>
            </tr>`;

                    new bootstrap.Modal(document.getElementById('orderDetailModal')).show();
                })
                .catch(() => alert(isAr ? 'حدث خطأ. حاول مرة أخرى.' : 'An error occurred.'));
        }
        @endauth

        @guest
        /* ── Guest: click on cookie order row ── */
        function guestTrackOrder(orderNumber) {
            document.getElementById('orderInput').value = orderNumber;
            trackOrder();
            setTimeout(() => {
                const res = document.getElementById('trackResult');
                if (res) res.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 800);
        }
        @endguest

        /* ── Search by order number ── */
        function trackOrder() {
            const input = document.getElementById('orderInput');
            const orderNum = input.value.trim();
            if (!orderNum) {
                input.focus();
                return;
            }

            const btn = document.getElementById('trackBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.btn-loading').classList.remove('d-none');
            btn.disabled = true;

            fetch('{{ route('track-order.status') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        order_number: orderNum
                    }),
                })
                .then(r => r.json())
                .then(data => {
                        const resultEl = document.getElementById('trackResult');
                        const errorEl = document.getElementById('trackError');
                        resultEl.classList.remove('d-none');
                        errorEl.classList.add('d-none');

                        @auth
                        const successEl = null;
                    @endauth
                    @guest
                    const successEl = document.getElementById('trackSuccess');
                    if (successEl) successEl.classList.add('d-none');
                @endguest

            if (!data.success) {
                errorEl.classList.remove('d-none');
                document.getElementById('errorMsg').textContent = data.message;
                return;
            }

            @auth
            if (data.order_id) {
                openOrderModal(data.order_id);
            }
        @endauth

        @guest
        document.getElementById('displayOrderNum').textContent = data.order_number;
        document.getElementById('displayCustomer').textContent = data.customer_name;
        document.getElementById('displayDate').textContent = data.created_at;
        document.getElementById('displayTotal').textContent = data.total + ' EGP';
        document.getElementById('displayItems').textContent = data.items_count + (isAr ? ' قطعة' : ' item(s)');
        document.getElementById('displayPayment').textContent = paymentLabels[data.payment_status] || data.payment_label;

        const badge = document.getElementById('statusBadge');
        badge.textContent = data.status_label;
        badge.className = 'order-status-badge ' + (statusColors[data.status] || 'badge-pending');

        buildSteps(document.getElementById('orderSteps'), data.status);
        if (successEl) successEl.classList.remove('d-none');
        @endguest
        })
        .catch(() => {
                document.getElementById('trackResult').classList.remove('d-none');
                document.getElementById('trackError').classList.remove('d-none');
                document.getElementById('errorMsg').textContent = isAr ? 'حدث خطأ في الاتصال.' : 'Connection error.';
            })
            .finally(() => {
                btn.querySelector('.btn-text').classList.remove('d-none');
                btn.querySelector('.btn-loading').classList.add('d-none');
                btn.disabled = false;
            });
        }

        document.getElementById('orderInput')?.addEventListener('keydown', e => {
            if (e.key === 'Enter') trackOrder();
        });

        @if (request('order'))
            window.addEventListener('DOMContentLoaded', () => trackOrder());
        @endif
    </script>
@endpush

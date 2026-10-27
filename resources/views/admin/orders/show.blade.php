@extends('admin.layouts.app')

@section('title', __('app.orders') . ': ' . $order->order_number)
@section('page-title', __('app.order_details'))
@section('breadcrumb')
    <i class="fas fa-chevron-left"></i>
    <a href="{{ route('admin.orders.index') }}">{{ __('app.orders') }}</a>
    <i class="fas fa-chevron-left"></i>
    <span>{{ $order->order_number }}</span>
@endsection

@section('content')
<div class="order-layout">

    <!-- Left: Details -->
    <div class="order-main">

        <!-- Items -->
        <div class="card" style="margin-bottom:1.5rem">
            <div class="card-header">
                <h2><i class="fas fa-box" style="color:var(--primary);margin-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}:.5rem"></i> {{ __('app.ordered_products') }}</h2>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>{{ __('app.product_col') }}</th><th>{{ __('app.unit_price') }}</th><th>{{ __('app.quantity') }}</th><th>{{ __('app.total') }}</th><th>{{ __('app.stock') }}</th></tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        @php
                            $fullImg = '';
                            if ($item->product) {
                                $main = $item->product->getMainImageUrl('card');
                                $fullImg = $main ? asset(ltrim($main, '/')) : $item->product->thumbnail_url;
                            }
                            $stockQty = $item->product ? (int) $item->product->stock : null;
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:.75rem">
                                    <div class="order-item-thumb {{ $fullImg ? 'order-thumb-zoom' : '' }}" data-full="{{ $fullImg }}" data-name="{{ $item->product_name }}">
                                        <i class="fas fa-box"></i>
                                        @if ($thumb = $item->product?->thumbnail_url)
                                            <img src="{{ $thumb }}" alt="{{ $item->product_name }}" loading="lazy" onerror="this.remove()">
                                        @endif
                                    </div>
                                    <strong>{{ $item->product_name }}</strong>
                                </div>
                            </td>
                            <td>{{ number_format($item->price) }} ج</td>
                            <td><span class="badge badge-blue">× {{ $item->quantity }}</span></td>
                            <td><strong style="color:var(--primary)">{{ number_format($item->total) }} ج</strong></td>
                            <td>
                                @if($stockQty === null)
                                    <span class="badge badge-orange">—</span>
                                @elseif($stockQty > 0)
                                    <span class="badge badge-green">{{ number_format($stockQty) }}</span>
                                @else
                                    <span class="badge badge-red">0</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:1.5rem;border-top:1px solid var(--ink-100)">
                <div class="order-totals">
                    <div class="total-row"><span>{{ __('app.subtotal') }}</span><span>{{ number_format($order->subtotal) }} ج</span></div>
                    <div class="total-row"><span>{{ __('app.shipping') }}</span><span>{{ $order->shipping > 0 ? number_format($order->shipping) . ' ج' : $order->shipping_label }}</span></div>
                    <div class="total-row total-final"><span>{{ __('app.total') }}</span><span>{{ number_format($order->total) }} ج</span></div>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="card">
            <div class="card-header"><h2><i class="fas fa-user" style="color:var(--primary);margin-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}:.5rem"></i> {{ __('app.customer_info') }}</h2></div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item"><span class="info-label">{{ __('app.name') }}</span><span class="info-value">{{ $order->customer_name }}</span></div>
                    <div class="info-item"><span class="info-label">{{ __('app.email') }}</span><span class="info-value">{{ $order->customer_email }}</span></div>
                    <div class="info-item"><span class="info-label">{{ __('app.phone') }}</span><span class="info-value">{{ $order->customer_phone }}</span></div>
                    <div class="info-item"><span class="info-label">{{ __('app.city') }}</span><span class="info-value">{{ $order->city }}</span></div>
                    <div class="info-item" style="grid-column:1/-1"><span class="info-label">{{ __('app.address') }}</span><span class="info-value">{{ $order->customer_address }}</span></div>
                    @if($order->notes)
                    <div class="info-item" style="grid-column:1/-1"><span class="info-label">{{ __('app.notes') }}</span><span class="info-value">{{ $order->notes }}</span></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Status -->
    <div class="order-side">

        <!-- Order Status -->
        <div class="card" style="margin-bottom:1.5rem">
            <div class="card-header"><h2><i class="fas fa-truck" style="color:var(--primary);margin-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}:.5rem"></i> {{ __('app.order_status') }}</h2></div>
            <div class="card-body">
                <div style="margin-bottom:1rem">
                    <span class="badge badge-{{ $order->status_color }}" style="font-size:1rem;padding:.5rem 1.25rem">
                        {{ $order->status_label }}
                    </span>
                </div>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <label class="form-label">{{ __('app.change_status') }}</label>
                        <select name="status" class="form-control">
                            <option value="pending"    {{ $order->status=='pending'    ? 'selected':'' }}>{{ __('app.status_pending') }}</option>
                            <option value="processing" {{ $order->status=='processing' ? 'selected':'' }}>{{ __('app.status_processing') }}</option>
                            <option value="shipped"    {{ $order->status=='shipped'    ? 'selected':'' }}>{{ __('app.status_shipped') }}</option>
                            <option value="delivered"  {{ $order->status=='delivered'  ? 'selected':'' }}>{{ __('app.status_delivered') }}</option>
                            <option value="cancelled"  {{ $order->status=='cancelled'  ? 'selected':'' }}>{{ __('app.status_cancelled') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%">
                        <i class="fas fa-save"></i> {{ __('app.update_status') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Payment Status -->
        <div class="card" style="margin-bottom:1.5rem">
            <div class="card-header"><h2><i class="fas fa-credit-card" style="color:var(--primary);margin-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}:.5rem"></i> {{ __('app.payment_status') }}</h2></div>
            <div class="card-body">
                @php $pc = match($order->payment_status) { 'paid'=>'green','refunded'=>'orange', default=>'red' }; @endphp
                <div style="margin-bottom:1rem">
                    <span class="badge badge-{{ $pc }}" style="font-size:1rem;padding:.5rem 1.25rem">
                        {{ $order->payment_status_label }}
                    </span>
                </div>
                <div style="margin-bottom:1rem;color:var(--ink-600);font-size:.9375rem">
                    <i class="fas fa-money-bill-wave" style="color:var(--primary)"></i>
                    {{ __('app.payment_method') }}
                    <strong>{{ match($order->payment_method) { 'cash'=>__('app.pay_cash'),'card'=>__('app.pay_card'),'transfer'=>__('app.pay_transfer'), default=>$order->payment_method } }}</strong>
                </div>
                <form method="POST" action="{{ route('admin.orders.payment', $order) }}">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <label class="form-label">{{ __('app.change_payment') }}</label>
                        <select name="payment_status" class="form-control">
                            <option value="unpaid"   {{ $order->payment_status=='unpaid'   ? 'selected':'' }}>{{ __('app.payment_unpaid') }}</option>
                            <option value="paid"     {{ $order->payment_status=='paid'     ? 'selected':'' }}>{{ __('app.payment_paid') }}</option>
                            <option value="refunded" {{ $order->payment_status=='refunded' ? 'selected':'' }}>{{ __('app.payment_refunded') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success" style="width:100%">
                        <i class="fas fa-save"></i> {{ __('app.update_payment') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Shipping -->
        @php
            $shipMode = in_array($order->shipping_mode, [\App\Models\Order::SHIPPING_FREE, \App\Models\Order::SHIPPING_FIXED], true)
                ? $order->shipping_mode
                : \App\Models\Order::SHIPPING_DETERMINED;
            $shipBadge = $order->shipping > 0 ? 'blue' : ($shipMode === \App\Models\Order::SHIPPING_FREE ? 'green' : 'orange');
        @endphp
        <div class="card" style="margin-bottom:1.5rem">
            <div class="card-header"><h2><i class="fas fa-truck-fast" style="color:var(--primary);margin-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}:.5rem"></i> {{ __('app.shipping') }}</h2></div>
            <div class="card-body">
                <div style="margin-bottom:1rem">
                    <span class="badge badge-{{ $shipBadge }}" style="font-size:1rem;padding:.5rem 1.25rem">
                        {{ $order->shipping > 0 ? number_format($order->shipping) . ' ج' : $order->shipping_label }}
                    </span>
                </div>
                <form method="POST" action="{{ route('admin.orders.shipping', $order) }}">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <label class="form-label" for="shipping_mode">{{ __('app.change_shipping') }}</label>
                        <select name="shipping_mode" id="shipping_mode" class="form-control">
                            <option value="determined" {{ $shipMode === \App\Models\Order::SHIPPING_DETERMINED ? 'selected' : '' }}>{{ __('app.shipping_determined') }}</option>
                            <option value="free" {{ $shipMode === \App\Models\Order::SHIPPING_FREE ? 'selected' : '' }}>{{ __('app.shipping_mode_free') }}</option>
                            <option value="fixed" {{ $shipMode === \App\Models\Order::SHIPPING_FIXED ? 'selected' : '' }}>{{ __('app.shipping_mode_fixed') }}</option>
                        </select>
                    </div>
                    <div class="form-group" id="shipping_cost_group" style="{{ $shipMode === \App\Models\Order::SHIPPING_FIXED ? '' : 'display:none' }}">
                        <label class="form-label" for="shipping_cost">{{ __('app.shipping_cost') }}</label>
                        <input type="number" step="0.01" min="0" id="shipping_cost" name="shipping_cost" class="form-control"
                               value="{{ old('shipping_cost', $order->shipping > 0 ? $order->shipping + 0 : '') }}" placeholder="50">
                        @error('shipping_cost')
                            <small style="color:#dc2626;display:block;margin-top:.35rem">{{ $message }}</small>
                        @enderror
                    </div>
                    <small class="form-hint" style="display:block;color:var(--ink-500);margin-bottom:.75rem">{{ __('app.shipping_help') }}</small>
                    <button type="submit" class="btn btn-primary" style="width:100%">
                        <i class="fas fa-save"></i> {{ __('app.update_shipping') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Info -->
        <div class="card">
            <div class="card-header"><h2><i class="fas fa-info-circle" style="color:var(--primary);margin-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}:.5rem"></i> {{ __('app.order_info') }}</h2></div>
            <div class="card-body">
                <div class="info-item" style="margin-bottom:.75rem"><span class="info-label">{{ __('app.order_number') }}</span><span class="info-value" style="color:var(--primary);font-weight:700">{{ $order->order_number }}</span></div>
                <div class="info-item" style="margin-bottom:.75rem"><span class="info-label">{{ __('app.order_date') }}</span><span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                <div class="info-item"><span class="info-label">{{ __('app.last_updated') }}</span><span class="info-value">{{ $order->updated_at->format('d/m/Y H:i') }}</span></div>
            </div>
        </div>
    </div>
</div>

<!-- Image Lightbox -->
<div class="img-lightbox" id="imgLightbox" hidden>
    <div class="img-lightbox-backdrop"></div>
    <div class="img-lightbox-body">
        <button class="img-lightbox-close" type="button" aria-label="Close">&times;</button>
        <img src="" alt="">
        <p class="img-lightbox-cap"></p>
    </div>
</div>
@endsection

@push('styles')
<style>
.order-layout { display:grid; grid-template-columns:1fr 360px; gap:1.5rem; align-items:start; }
.order-item-thumb { position:relative; width:40px; height:40px; flex-shrink:0; background:var(--primary-pale); border-radius:var(--r); display:flex; align-items:center; justify-content:center; color:var(--primary); overflow:hidden; }
.order-item-thumb img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
.order-thumb-zoom { cursor:zoom-in; outline:2px solid transparent; transition:outline-color .2s ease, transform .2s ease; }
.order-thumb-zoom:hover { outline-color:var(--primary); transform:scale(1.06); }
.img-lightbox { position:fixed; inset:0; z-index:9999; display:flex; align-items:center; justify-content:center; }
.img-lightbox[hidden] { display:none; }
.img-lightbox-backdrop { position:absolute; inset:0; background:rgba(2,10,22,.78); backdrop-filter:blur(3px); }
.img-lightbox-body { position:relative; max-width:90vw; max-height:88vh; background:#fff; border-radius:16px; padding:1rem; box-shadow:0 24px 60px rgba(0,0,0,.45); display:flex; flex-direction:column; align-items:center; gap:.75rem; }
.img-lightbox-body img { max-width:82vw; max-height:70vh; object-fit:contain; border-radius:10px; }
.img-lightbox-cap { margin:0; color:var(--ink-700); font-weight:600; text-align:center; }
.img-lightbox-close { position:absolute; top:.5rem; inset-inline-end:.5rem; width:34px; height:34px; border:none; border-radius:50%; background:var(--ink-100); color:var(--ink-700); font-size:1.4rem; line-height:1; cursor:pointer; display:flex; align-items:center; justify-content:center; }
.img-lightbox-close:hover { background:var(--ink-200); }
.order-totals { max-width:300px; margin-inline-start:auto; }
.total-row { display:flex; justify-content:space-between; padding:.5rem 0; color:var(--ink-600); border-bottom:1px solid var(--ink-100); }
.total-row:last-child { border-bottom:none; }
.total-final { font-size:1.25rem; font-weight:700; color:var(--ink-900); padding-top:1rem; }
.total-final span:last-child { color:var(--primary); }
.info-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
.info-item { display:flex; flex-direction:column; gap:.25rem; }
.info-label { font-size:.8125rem; color:var(--ink-500); font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
.info-value { color:var(--ink-900); font-weight:500; }
@media (max-width:1024px) { .order-layout { grid-template-columns:1fr; } }
</style>
@endpush

@push('scripts')
<script>
    // Show the cost input only when a fixed shipping value is chosen
    const shipMode = document.getElementById('shipping_mode');
    const shipCostGroup = document.getElementById('shipping_cost_group');
    if (shipMode && shipCostGroup) {
        const toggleShipCost = () => {
            shipCostGroup.style.display = shipMode.value === 'fixed' ? '' : 'none';
            document.getElementById('shipping_cost').disabled = shipMode.value !== 'fixed';
        };
        shipMode.addEventListener('change', toggleShipCost);
        toggleShipCost();
    }

    // Product image lightbox (click thumbnail to enlarge)
    (function () {
        const lb = document.getElementById('imgLightbox');
        if (!lb) return;
        const lbImg = lb.querySelector('img');
        const lbCap = lb.querySelector('.img-lightbox-cap');
        const open = (src, name) => {
            lbImg.src = src;
            lbImg.alt = name || '';
            lbCap.textContent = name || '';
            lb.hidden = false;
            document.body.style.overflow = 'hidden';
        };
        const close = () => {
            lb.hidden = true;
            lbImg.src = '';
            document.body.style.overflow = '';
        };
        document.querySelectorAll('.order-thumb-zoom').forEach(function (el) {
            el.addEventListener('click', function () {
                const f = el.getAttribute('data-full');
                if (f) open(f, el.getAttribute('data-name'));
            });
        });
        lb.addEventListener('click', function (e) {
            if (e.target === lb || e.target.classList.contains('img-lightbox-backdrop') || e.target.classList.contains('img-lightbox-close')) close();
        });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
    })();
</script>
@endpush



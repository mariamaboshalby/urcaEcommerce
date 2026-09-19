@extends('layouts.app')

@section('title', 'سلة التسوق - urca')

@section('content')

    {{-- Page Header --}}
    <div style="background:linear-gradient(135deg,#0f172a 0%,#030f1f 100%);padding:2.5rem 0;">
        <div class="container">
            <h1 class="text-white fw-bold mb-1"><i class="fas fa-shopping-cart me-2"></i>{{ __('app.cart_title') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            class="text-white-50 text-decoration-none">{{ __('app.prod_breadcrumb_home') }}</a></li>
                    <li class="breadcrumb-item active text-white-50">{{ __('app.cart_title') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5 bg-light">
        <div class="container">

            @if (count($cart) === 0)
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div class="empty-icon mx-auto mb-4">
                        <i class="fas fa-cart-shopping"></i>
                    </div>
                    <h3 class="fw-bold mb-2" style="color:#0f172a;">{{ __('app.cart_empty_title') }}</h3>
                    <p class="text-secondary mb-4">{{ __('app.cart_empty_sub') }}</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-shopping-bag me-2"></i>{{ __('app.cart_browse') }}
                    </a>
                </div>
            @else
                {{-- Cart Layout --}}
                <div class="row g-4">

                    {{-- Cart Items --}}
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm" style="border-radius:16px;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold mb-0" style="color:#0f172a;">
                                        {{ __('app.cart_items') }} <span
                                            class="text-muted fw-normal">({{ array_sum(array_column($cart, 'qty')) }})</span>
                                    </h5>
                                    <button class="btn btn-sm btn-outline-danger" id="clearCartBtn">
                                        <i class="fas fa-trash me-1"></i>{{ __('app.cart_clear') }}
                                    </button>
                                </div>

                                @foreach ($cart as $item)
                                    <div class="cart-item d-flex align-items-center gap-3 py-3 border-bottom"
                                        data-id="{{ $item['id'] }}">
                                        {{-- Icon --}}
                                        <div class="cart-item-icon flex-shrink-0">
                                            <i class="fas {{ isset($item['icon']) ? $item['icon'] : 'fa-box' }}"></i>
                                        </div>

                                        {{-- Info --}}
                                        <div class="flex-grow-1 min-w-0">
                                            <h6 class="fw-bold mb-1 text-dark">{{ $item['name'] }}</h6>
                                            <span class="text-primary fw-semibold">{{ number_format($item['price']) }}
                                                EGP</span>
                                        </div>

                                        {{-- Qty Controls --}}
                                        <div class="qty-controls d-flex align-items-center gap-0 flex-shrink-0">
                                            <button class="btn btn-sm btn-light border cart-qty-minus"
                                                data-id="{{ $item['id'] }}"
                                                style="border-radius:8px 0 0 8px;width:34px;height:34px;">
                                                <i class="fas fa-minus" style="font-size:.7rem;"></i>
                                            </button>
                                            <span
                                                class="cart-qty-val border-top border-bottom d-flex align-items-center justify-content-center fw-bold"
                                                style="width:40px;height:34px;font-size:.9rem;">{{ $item['qty'] }}</span>
                                            <button class="btn btn-sm btn-light border cart-qty-plus"
                                                data-id="{{ $item['id'] }}"
                                                style="border-radius:0 8px 8px 0;width:34px;height:34px;">
                                                <i class="fas fa-plus" style="font-size:.7rem;"></i>
                                            </button>
                                        </div>

                                        {{-- Item Total --}}
                                        <div class="text-end flex-shrink-0" style="min-width:90px;">
                                            <span
                                                class="fw-bold text-dark">{{ number_format($item['price'] * $item['qty']) }}
                                                EGP</span>
                                        </div>

                                        {{-- Remove --}}
                                        <button class="btn btn-sm text-danger cart-item-remove flex-shrink-0"
                                            data-id="{{ $item['id'] }}" title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm sticky-top" style="border-radius:16px;top:90px;">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4" style="color:#0f172a;">{{ __('app.checkout_order_sum') }}</h5>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-secondary">{{ __('app.cart_subtotal') }}</span>
                                    <span class="fw-semibold" id="cartSubtotal">{{ number_format($total) }} EGP</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fw-bold fs-5">{{ __('app.total') }}</span>
                                    <span class="fw-bold fs-5 text-primary" id="cartTotal">{{ number_format($total) }}
                                        EGP</span>
                                </div>

                                @auth
                                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 btn-lg mb-2 fw-bold">
                                        <i class="fas fa-check-circle me-2"></i>{{ __('app.cart_proceed') }}
                                    </a>
                                @else
                                    <button id="checkoutBtn" class="btn btn-primary w-100 btn-lg mb-2 fw-bold">
                                        <i class="fas fa-check-circle me-2"></i>{{ __('app.cart_proceed') }}
                                    </button>
                                @endauth
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mb-4">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('app.cart_continue') }}
                                </a>

                                {{-- Trust Badges --}}
                                <div class="d-flex justify-content-around pt-3 border-top">
                                    <div class="text-center">
                                        <i class="fas fa-lock text-primary mb-1 d-block"></i>
                                        <small class="text-muted">{{ __('app.cart_secure') }}</small>
                                    </div>
                                    <div class="text-center">
                                        <i class="fas fa-shield-halved text-primary mb-1 d-block"></i>
                                        <small class="text-muted">{{ __('app.cart_guaranteed') }}</small>
                                    </div>
                                    <div class="text-center">
                                        <i class="fas fa-truck text-primary mb-1 d-block"></i>
                                        <small class="text-muted">{{ __('app.cart_free_delivery') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </section>

@endsection

@push('styles')
    <style>
        .empty-icon {
            width: 100px;
            height: 100px;
            background: #e8edf5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #051836;
        }

        .cart-item-icon {
            width: 52px;
            height: 52px;
            background: #e8edf5;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.375rem;
            color: #051836;
        }

        .cart-item:last-child {
            border-bottom: none !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var CSRF = '{{ csrf_token() }}';

        function postJson(url, data) {
            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });
        }

        // Remove item
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.cart-item-remove');
            if (!btn) return;
            var id = btn.dataset.id;
            postJson('{{ route('cart.remove') }}', {
                    product_id: id
                })
                .then(function() {
                    location.reload();
                });
        });

        // Update qty (+/-)
        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.cart-qty-plus, .cart-qty-minus');
            if (!btn) return;
            var id = btn.dataset.id;
            var row = btn.closest('.cart-item');
            var qtyEl = row.querySelector('.cart-qty-val');
            var qty = parseInt(qtyEl.textContent);

            if (btn.classList.contains('cart-qty-plus')) qty++;
            else qty--;
            if (qty < 1) qty = 1;

            postJson('{{ route('cart.update') }}', {
                    product_id: id,
                    quantity: qty
                })
                .then(function(r) {
                    return r.json();
                })
                .then(function(res) {
                    if (res.success) location.reload();
                });
        });

        // Clear cart
        var clearBtn = document.getElementById('clearCartBtn');
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                if (!confirm('{{ __('app.cart_clear_confirm') }}')) return;
                postJson('{{ route('cart.clear') }}', {})
                    .then(function() {
                        location.reload();
                    });
            });
        }

        // Checkout button (guest only) — save cart to cookie then redirect to login
        @guest
        var checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', function() {
                fetch('{{ route('cart.items') }}')
                    .then(function(r) {
                        return r.json();
                    })
                    .then(function(data) {
                        if (data.items && data.items.length > 0) {
                            var expires = new Date();
                            expires.setDate(expires.getDate() + 10);
                            document.cookie = 'urca_cart=' + encodeURIComponent(JSON.stringify(
                                data.items.reduce(function(acc, item) {
                                    acc[item.id] = {
                                        id: item.id,
                                        name: item.name,
                                        price: item.price,
                                        qty: item.quantity,
                                        quantity: item.quantity,
                                        icon: 'fa-box',
                                        image: item.image || ''
                                    };
                                    return acc;
                                }, {})
                            )) + '; expires=' + expires.toUTCString() + '; path=/; SameSite=Lax';
                        }
                        window.location.href = '{{ route('login') }}';
                    })
                    .catch(function() {
                        window.location.href = '{{ route('login') }}';
                    });
            });
        }
        @endguest
    </script>
@endpush

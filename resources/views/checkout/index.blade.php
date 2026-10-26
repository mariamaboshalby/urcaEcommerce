@extends('layouts.app')
@section('title', 'اشتر الآن— urca')

@section('content')

    <div style="background:linear-gradient(135deg,#0f172a 0%,#030f1f 100%);padding:2.5rem 0;">
        <div class="container">
            <h1 class="text-white fw-bold mb-1">{{ __('app.checkout_title') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            class="text-white-50 text-decoration-none">{{ __('app.prod_breadcrumb_home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cart.index') }}"
                            class="text-white-50 text-decoration-none">{{ __('app.your_cart') }}</a></li>
                    <li class="breadcrumb-item active text-white-50">{{ __('app.checkout_title') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5 bg-light">
        <div class="container">

            @if ($errors->any())
                <div class="alert alert-danger rounded-3 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf
                <div class="row g-4">

                    {{-- Left: Delivery Info --}}
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                            <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <i class="fas fa-map-marker-alt text-primary"></i> {{ __('app.checkout_delivery') }}
                            </h5>

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold small">{{ __('app.checkout_full_name') }}</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="form-control rounded-3" required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold small">{{ __('app.checkout_phone') }}</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="form-control rounded-3" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small">{{ __('app.checkout_email') }}</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="form-control rounded-3" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small">{{ __('app.checkout_address') }}</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                        class="form-control rounded-3" placeholder="{{ __('app.checkout_address_ph') }}"
                                        required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold small">{{ __('app.checkout_city') }}</label>
                                    <input type="text" name="city"
                                        value="{{ old('city', $user->city ?? 'Mansoura') }}" class="form-control rounded-3"
                                        required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold small">{{ __('app.checkout_payment') }}</label>
                                    <select name="payment_method" class="form-select rounded-3" required>
                                        <option value="cash"
                                            {{ old('payment_method') === 'cash' ? 'selected' : '' }}>
                                            {{ __('app.checkout_cash') }}</option>
                                        <option value="card"
                                            {{ old('payment_method') === 'card' ? 'selected' : '' }}>
                                            {{ __('app.checkout_card') }}</option>
                                        <option value="transfer"
                                            {{ old('payment_method') === 'transfer' ? 'selected' : '' }}>
                                            {{ __('app.checkout_transfer') }}</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small">{{ __('app.checkout_notes') }} <span
                                            class="text-muted">({{ __('app.checkout_notes_opt') }})</span></label>
                                    <textarea name="notes" class="form-control rounded-3" rows="3" placeholder="{{ __('app.checkout_notes_ph') }}">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Order Summary --}}
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top:90px;">
                            <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <i class="fas fa-receipt text-primary"></i> {{ __('app.checkout_order_sum') }}
                            </h5>

                            {{-- Items --}}
                            <div class="mb-3">
                                @foreach ($cart as $item)
                                    @php $qty = $item['qty'] ?? $item['quantity'] ?? 1; @endphp
                                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width:36px;height:36px;font-size:.9rem;color:#051836;">
                                                <i class="fas {{ isset($item['icon']) ? $item['icon'] : 'fa-box' }}"></i>
                                            </div>
                                            <div>
                                                <p class="fw-semibold mb-0 small">{{ $item['name'] }}</p>
                                                <small class="text-muted">{{ __('app.checkout_qty') }}:
                                                    {{ $qty }}</small>
                                            </div>
                                        </div>
                                        <span class="fw-bold small text-primary">{{ number_format($item['price'] * $qty) }}
                                            EGP</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-secondary">{{ __('app.cart_subtotal') }}</span>
                                <span class="fw-semibold">{{ number_format($total) }} EGP</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-secondary">{{ __('app.shipping') }}</span>
                                <span class="fw-semibold text-muted">{{ __('app.shipping_determined') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold fs-5">{{ __('app.total') }}</span>
                                <span class="fw-bold fs-5 text-primary">{{ number_format($total) }} EGP</span>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3 fw-bold">
                                <i class="fas fa-check-circle me-2"></i>{{ __('app.checkout_confirm') }}
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2 rounded-3">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('app.checkout_back_cart') }}
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>

@endsection

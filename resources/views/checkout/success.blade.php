@extends('layouts.app')
@section('title', __('app.order_confirmed_title').' — urca')

@section('content')

    <section class="py-5 bg-light min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">

                    {{-- Success icon --}}
                    <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle"
                        style="width:90px;height:90px;background:#d1fae5;">
                        <i class="fas fa-check-circle text-success" style="font-size:2.75rem;"></i>
                    </div>

                    <h2 class="fw-bold mb-2">{{ __('app.order_confirmed_title') }}</h2>
                    <p class="text-secondary mb-1">{{ __('app.order_confirmed_sub') }}</p>
                    <p class="fw-semibold text-primary mb-4">{{ __('app.order_number_label') }} #{{ $order->order_number }}</p>

                    {{-- Order details card --}}
                    <div class="card border-0 shadow-sm rounded-4 p-4 text-start mb-4">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">{{ __('app.order_details') }}</h6>

                        @foreach ($order->items as $item)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div>
                                    <p class="fw-semibold mb-0 small">{{ $item->product_name }}</p>
                                    <small class="text-muted">{{ __('app.checkout_qty') }}: {{ $item->quantity }}</small>
                                </div>
                                <span class="fw-bold small text-primary">{{ number_format($item->total) }} EGP</span>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-secondary small">{{ __('app.shipping') }}</span>
                            <span class="fw-semibold small {{ $order->shipping > 0 ? '' : 'text-muted' }}">
                                {{ $order->shipping > 0 ? number_format($order->shipping) . ' EGP' : $order->shipping_label }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mt-3 pt-2">
                            <span class="fw-bold">{{ __('app.total') }}</span>
                            <span class="fw-bold text-primary fs-5">{{ number_format($order->total) }} EGP</span>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="d-flex flex-column gap-2 mb-4">
                        <div class="d-flex align-items-center gap-2 text-secondary small">
                            <i class="fas fa-envelope text-primary"></i>
                            {{ __('app.order_confirm_email_note') }} <strong class="ms-1">{{ $order->customer_email }}</strong>
                        </div>
                        <div class="d-flex align-items-center gap-2 text-secondary small">
                            <i class="fas fa-phone-alt text-primary"></i>
                            {{ __('app.order_confirm_phone_note') }} <strong class="ms-1">{{ $order->customer_phone }}</strong>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('home') }}" class="btn btn-primary px-5 rounded-3 fw-bold">
                            <i class="fas fa-home me-2"></i>{{ __('app.back_to_home') }}
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary px-4 rounded-3">
                            {{ __('app.continue_shopping') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

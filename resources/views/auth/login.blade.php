@extends('layouts.app')
@section('title', 'تسجيل الدخول — urca')

@section('content')

    <div style="background:linear-gradient(135deg,#0f172a 0%,#030f1f 100%);padding:2.5rem 0;">
        <div class="container">
            <h1 class="text-white fw-bold mb-1">تسجيل الدخول</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            class="text-white-50 text-decoration-none">الرئيسية</a></li>
                    <li class="breadcrumb-item active text-white-50">تسجيل الدخول</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">

                    {{-- Cart notice --}}
                    @if (session()->has('cart') && count(session('cart')) > 0)
                        <div class="alert alert-info rounded-3 mb-4 d-flex align-items-center gap-2">
                            <i class="fas fa-shopping-bag text-primary"></i>
                            <span>سجّل دخولك لإتمام طلبك — سلتك محفوظة. 🛍️</span>
                        </div>
                    @endif

                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h4 class="fw-bold mb-1 text-center">أهلاً بعودتك</h4>
                        <p class="text-secondary text-center small mb-4">سجّل دخولك لحسابك في urca</p>

                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3 small">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">البريد الإلكتروني</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control rounded-3 @error('email') is-invalid @enderror"
                                    placeholder="you@example.com" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">كلمة المرور</label>
                                <input type="password" name="password"
                                    class="form-control rounded-3 @error('password') is-invalid @enderror"
                                    placeholder="••••••••" required>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label small" for="remember">تذكّرني</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3 fw-bold">
                                <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                            </button>
                        </form>

                        <hr class="my-4">
                        <p class="text-center small text-secondary mb-0">
                            ليس لديك حساب؟
                            <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">أنشئ
                                حساباً</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

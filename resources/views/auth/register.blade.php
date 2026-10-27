@extends('layouts.app')
@section('title', 'إنشاء حساب — urca')

@section('content')

    <div style="background:linear-gradient(135deg,#0f172a 0%,#030f1f 100%);padding:2.5rem 0;">
        <div class="container">
            <h1 class="text-white fw-bold mb-1">إنشاء حساب</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            class="text-white-50 text-decoration-none">الرئيسية</a></li>
                    <li class="breadcrumb-item active text-white-50">إنشاء حساب</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">

                    @if (session()->has('cart') && count(session('cart')) > 0)
                        <div class="alert alert-info rounded-3 mb-4 d-flex align-items-center gap-2">
                            <i class="fas fa-shopping-bag text-primary"></i>
                            <span>أنشئ حسابك لإتمام طلبك — سلتك محفوظة. 🛍️</span>
                        </div>
                    @endif

                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h4 class="fw-bold mb-1 text-center">انضم إلينا</h4>
                        <p class="text-secondary text-center small mb-4">أنشئ حسابك في urca</p>

                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3 small">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">الاسم الكامل</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control rounded-3 @error('name') is-invalid @enderror"
                                    placeholder="مثال: أحمد محمد" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">البريد الإلكتروني</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control rounded-3 @error('email') is-invalid @enderror"
                                    placeholder="you@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">الهاتف <span
                                        class="text-muted">(اختياري)</span></label>
                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                    class="form-control rounded-3" placeholder="+20 1XX XXX XXXX">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">عنوان الشارع <span
                                        class="text-muted">(اختياري)</span></label>
                                <input type="text" name="address" value="{{ old('address') }}"
                                    class="form-control rounded-3" placeholder="اسم الشارع، المبنى، الشقة...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">المدينة <span
                                        class="text-muted">(اختياري)</span></label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                    class="form-control rounded-3" placeholder="مثال: سمنود">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">كلمة المرور</label>
                                <input type="password" name="password"
                                    class="form-control rounded-3 @error('password') is-invalid @enderror"
                                    placeholder="4 أحرف على الأقل" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">تأكيد كلمة المرور</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-3"
                                    placeholder="أعد كتابة كلمة المرور" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3 fw-bold">
                                <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                            </button>
                        </form>

                        <hr class="my-4">
                        <p class="text-center small text-secondary mb-0">
                            لديك حساب بالفعل؟
                            <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">سجّل
                                دخولك</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

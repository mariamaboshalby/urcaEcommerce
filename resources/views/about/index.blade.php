@extends('layouts.app')
@section('title', __('app.nav_about') . ' - urca')

@section('content')

    <div style="background:linear-gradient(135deg,#0f172a 0%,#030f1f 100%);padding:2.5rem 0;">
        <div class="container">
            <h1 class="text-white fw-bold mb-1">{{ __('app.nav_about') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            class="text-white-50 text-decoration-none">{{ __('app.nav_home') }}</a></li>
                    <li class="breadcrumb-item active text-white-50">{{ __('app.nav_about') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Intro --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4" style="font-size:2rem;color:#0f172a;">{{ __('app.home_about_title') }}</h2>
                    <p class="text-secondary lh-lg mb-3" style="font-size:1.0625rem;">{!! __('app.home_about_p1') !!}</p>
                    <p class="text-secondary lh-lg mb-0" style="font-size:1.0625rem;">{{ __('app.home_about_p2') }}</p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/about.png') }}" alt="urca - أجهزة كمبيوتر وإلكترونيات وملحقات"
                        class="img-fluid rounded-4 shadow-lg w-100" style="object-fit:cover;max-height:400px;">
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    @if ($stats->count())
        <section class="py-5" style="background:linear-gradient(135deg,#030f1f 0%,#051836 100%);">
            <div class="container">
                <div class="row g-4">
                    @foreach ($stats as $stat)
                        <div class="col-sm-6 col-lg-3">
                            <div class="stat-card text-center p-4 rounded-4 h-100">
                                <div class="stat-icon mx-auto mb-3"><i class="fas {{ $stat->icon }}"></i></div>
                                <h3 class="text-white fw-bold mb-1" style="font-size:2.5rem;">{{ $stat->number }}</h3>
                                <p class="mb-0" style="color:rgba(255,255,255,.85);font-size:1.0625rem;">
                                    {{ $stat->getLocalLabel() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Values --}}
    @if ($values->count())
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold" style="color:#0f172a;">{{ __('app.home_values_title') }}</h2>
                    <p class="text-secondary">{{ __('app.home_values_sub') }}</p>
                </div>
                <div class="row g-4">
                    @foreach ($values as $value)
                        <div class="col-md-6">
                            <div class="value-card card border-0 shadow-sm h-100 p-4">
                                <div class="value-icon mb-3"><i class="fas {{ $value->icon }}"></i></div>
                                <h4 class="fw-bold mb-2" style="color:#0f172a;">{{ $value->getLocalTitle() }}</h4>
                                <p class="text-secondary mb-0 lh-lg">{{ $value->getLocalDescription() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Team --}}
    @if ($team->count())
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold" style="color:#0f172a;">{{ __('app.about_team_title') }}</h2>
                    <p class="text-secondary">{{ __('app.about_team_sub') }}</p>
                </div>
                <div class="row g-4">
                    @foreach ($team as $member)
                        <div class="col-sm-6 col-lg-3">
                            <div class="team-card card border-0 shadow-sm text-center p-4 h-100">
                                <div class="team-avatar mx-auto mb-3"><i class="fas fa-user"></i></div>
                                <h5 class="fw-bold mb-1" style="color:#0f172a;">{{ $member->name }}</h5>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 d-inline-block"
                                    style="border-radius:50px;">{{ $member->getLocalRole() }}</span>
                                <p class="text-secondary mb-0" style="font-size:.9375rem;line-height:1.7;">
                                    {{ $member->getLocalBio() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Location Map --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <h2 class="fw-bold mb-4" style="color:#0f172a;">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        {{ app()->getLocale() === 'ar' ? 'موقعنا' : 'Our Location' }}
                    </h2>
                    <div class="mb-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="flex-shrink-0">
                                <div class="location-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color:#0f172a;">{{ __('app.footer_address') }}</h5>

                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="flex-shrink-0">
                                <div class="location-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color:#0f172a;">
                                    {{ app()->getLocale() === 'ar' ? 'اتصل بنا' : 'Call Us' }}</h5>
                                <a href="tel:+201093803270" class="text-primary text-decoration-none fw-semibold">+20 10
                                    93803270</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <div class="flex-shrink-0">
                                <div class="location-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color:#0f172a;">
                                    {{ app()->getLocale() === 'ar' ? 'ساعات العمل' : 'Working Hours' }}</h5>
                                <p class="text-secondary mb-0">{{ __('app.footer_hours') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="https://www.google.com/maps/place/30%C2%B056'37.3%22N+31%C2%B017'22.0%22E/@30.9436857,31.2894227,21z"
                            target="_blank" class="btn btn-primary">
                            <i
                                class="fas fa-directions me-2"></i>{{ app()->getLocale() === 'ar' ? 'احصل على الاتجاهات' : 'Get Directions' }}
                        </a>
                        <a href="https://wa.me/201093803270" target="_blank" class="btn btn-outline-primary">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d714.1338338154081!2d31.28942265912146!3d30.94368566303161!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2s!5e0!3m2!1sar!2seg!4v1783340972314!5m2!1sar!2seg"
                            width="100%" height="450" style="border:0;border-radius:16px;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-5 text-center" style="background:linear-gradient(135deg,#030f1f 0%,#051836 100%);">
        <div class="container">
            <h2 class="text-white fw-bold mb-3" style="font-size:2.5rem;">{{ __('app.about_cta_title') }}</h2>
            <p class="mb-4" style="color:rgba(255,255,255,.9);font-size:1.25rem;">{{ __('app.about_cta_sub') }}</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="tel:+201093803270" class="btn btn-light btn-lg px-5 fw-bold">
                    <i class="fas fa-phone-alt me-2"></i>{{ __('app.about_cta_call') }}
                </a>
                <a href="https://wa.me/201093803270" class="btn btn-outline-light btn-lg px-5 fw-bold">
                    <i class="fab fa-whatsapp me-2"></i>WhatsApp
                </a>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .stat-card {
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(10px);
            transition: all .3s ease;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, .18);
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, .2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
        }

        .value-card {
            border-radius: 16px !important;
            transition: all .3s ease;
        }

        .value-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, .1) !important;
        }

        .value-icon {
            width: 64px;
            height: 64px;
            background: #e8edf5;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: #051836;
            transition: all .3s ease;
        }

        .value-card:hover .value-icon {
            background: #051836;
            color: #fff;
        }

        .team-card {
            border-radius: 16px !important;
            transition: all .3s ease;
        }

        .team-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, .1) !important;
        }

        .team-avatar {
            width: 90px;
            height: 90px;
            background: #e8edf5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #051836;
            transition: all .3s ease;
        }

        .team-card:hover .team-avatar {
            background: #051836;
            color: #fff;
        }

        /* Location Section */
        .map-container {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
            transition: all .3s ease;
        }

        .map-container:hover {
            box-shadow: 0 16px 48px rgba(0, 0, 0, .18);
            transform: translateY(-4px);
        }

        .map-container iframe {
            display: block;
            border-radius: 16px;
        }

        .location-icon {
            width: 48px;
            height: 48px;
            background: #e8edf5;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #051836;
            transition: all .3s ease;
        }

        .location-icon:hover {
            background: #051836;
            color: #fff;
            transform: scale(1.1);
        }

        /* Responsive Map */
        @media (max-width: 768px) {
            .map-container iframe {
                height: 350px;
            }
        }
    </style>
@endpush

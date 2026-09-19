﻿@extends('layouts.app')

@section('title', $item['title'] . ' - urca')
@section('description', $item['excerpt'])

@section('content')

    {{-- Hero --}}
    <div style="background:linear-gradient(135deg,#0f172a 0%,#030f1f 100%);padding:3rem 0 2rem;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <span class="news-hero-cat">{{ $item['category'] }}</span>
                    <h1 class="text-white fw-bold mt-3 mb-4" style="font-size:clamp(1.5rem,3.5vw,2.25rem);line-height:1.35;">
                        {{ $item['title'] }}
                    </h1>
                    <div class="d-flex flex-wrap gap-3" style="font-size:.875rem;">
                        <span class="news-meta-item"><i
                                class="fas fa-calendar-alt"></i>{{ \Carbon\Carbon::parse($item['date'])->format('d M Y') }}</span>
                        <span class="news-meta-item"><i class="fas fa-user"></i>{{ $item['author'] }}</span>
                        <span class="news-meta-item"><i class="fas fa-eye"></i>{{ number_format($item['views']) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Breadcrumb --}}
    <div class="bg-white border-bottom py-2">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size:.875rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            class="text-primary text-decoration-none">{{ __('app.nav_home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('news.index') }}"
                            class="text-primary text-decoration-none">{{ __('app.nav_news') }}</a></li>
                    <li class="breadcrumb-item active text-muted">{{ Str::limit($item['title'], 45) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5" style="background:#f8fafc;">
        <div class="container">
            <div class="row g-4">

                {{-- Main Article --}}
                <div class="col-lg-8">
                    <article class="news-article">
                        {{-- Cover --}}
                        <div class="news-article-cover mb-5">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-tv text-white opacity-20" style="font-size:7rem;"></i>
                            </div>
                        </div>

                        {{-- Excerpt lead --}}
                        <p class="article-lead">{{ $item['excerpt'] }}</p>

                        {{-- Content --}}
                        <div class="article-body">
                            {!! nl2br(e($item['content'])) !!}
                        </div>

                        {{-- Share --}}
                        <div class="article-share mt-5 pt-4 border-top">
                            <span class="text-muted fw-semibold me-3" style="font-size:.875rem;">
                                {{ app()->getLocale() === 'ar' ? 'شارك الخبر:' : 'Share:' }}
                            </span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank" rel="noopener" class="share-btn share-fb" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($item['title'] . ' ' . url()->current()) }}"
                                target="_blank" rel="noopener" class="share-btn share-wa" aria-label="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <button
                                onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(()=>showToast('{{ app()->getLocale() === 'ar' ? 'تم نسخ الرابط' : 'Link copied!' }}'))"
                                class="share-btn share-copy" aria-label="Copy">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('news.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                                <i class="fas fa-arrow-left me-2"></i>
                                {{ app()->getLocale() === 'ar' ? 'العودة للأخبار' : 'Back to News' }}
                            </a>
                        </div>
                    </article>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">

                    {{-- Related news --}}
                    <div class="sidebar-widget">
                        <div class="sidebar-widget-header">
                            <i class="fas fa-newspaper text-primary me-2"></i>
                            {{ app()->getLocale() === 'ar' ? 'أخبار ذات صلة' : 'More News' }}
                        </div>
                        <div class="p-3">
                            @foreach ($related as $rel)
                                <a href="{{ route('news.show', $rel['id']) }}"
                                    class="d-flex gap-3 text-decoration-none {{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }} sidebar-news-item">
                                    <div class="sidebar-icon flex-shrink-0">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <h6 class="fw-semibold text-dark mb-1 sidebar-news-title">
                                            {{ Str::limit($rel['title'], 55) }}</h6>
                                        <small class="text-muted">
                                            <i
                                                class="fas fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($rel['date'])->format('d M Y') }}
                                            &nbsp;·&nbsp;<i class="fas fa-eye me-1"></i>{{ number_format($rel['views']) }}
                                        </small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Track order CTA --}}
                    <div class="sidebar-widget mt-4">
                        <div class="p-4 text-center">
                            <div class="track-cta-icon mx-auto mb-3">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-2">
                                {{ app()->getLocale() === 'ar' ? 'تتبع طلبك' : 'Track Your Order' }}
                            </h6>
                            <p class="text-muted small mb-3">
                                {{ app()->getLocale() === 'ar' ? 'اعرف وين وصل طلبك في أي وقت.' : 'Know your order status anytime.' }}
                            </p>
                            <a href="{{ route('track-order') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                                <i class="fas fa-search-location me-1"></i>
                                {{ app()->getLocale() === 'ar' ? 'تتبع الآن' : 'Track Now' }}
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .news-hero-cat {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(10px);
            color: #fff;
            font-size: .8rem;
            font-weight: 700;
            padding: .35rem 1rem;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, .25);
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .news-meta-item {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            color: rgba(255, 255, 255, .75);
            background: rgba(255, 255, 255, .08);
            padding: .3rem .8rem;
            border-radius: 50px;
            font-size: .8125rem;
        }

        .news-meta-item i {
            opacity: .7;
            font-size: .85em;
        }

        .news-article {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
            border: 1px solid #e2e8f0;
        }

        .news-article-cover {
            height: 300px;
            background: linear-gradient(135deg, #0f172a 0%, #051836 100%);
            border-radius: 14px;
        }

        .article-lead {
            font-size: 1.125rem;
            color: #334155;
            line-height: 1.9;
            font-weight: 500;
            border-left: 4px solid #051836;
            padding-left: 1.25rem;
            margin-bottom: 2rem;
        }

        [dir="rtl"] .article-lead {
            border-left: none;
            border-right: 4px solid #051836;
            padding-left: 0;
            padding-right: 1.25rem;
        }

        .article-body {
            font-size: 1.0625rem;
            color: #475569;
            line-height: 2;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            font-size: .9375rem;
            text-decoration: none;
            transition: all .25s ease;
            border: none;
            cursor: pointer;
            margin-right: .5rem;
        }

        .share-fb {
            background: #1877f2;
            color: #fff;
        }

        .share-wa {
            background: #25d366;
            color: #fff;
        }

        .share-copy {
            background: #f1f5f9;
            color: #475569;
        }

        .share-btn:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 6px 16px rgba(0, 0, 0, .2);
        }

        .sidebar-widget {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .sidebar-widget-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.25rem;
            font-weight: 700;
            font-size: .9375rem;
            color: #0f172a;
            display: flex;
            align-items: center;
        }

        .sidebar-icon {
            width: 44px;
            height: 44px;
            background: #e8edf5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #051836;
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .sidebar-news-item {
            transition: all .25s ease;
        }

        .sidebar-news-item:hover .sidebar-news-title {
            color: #051836;
        }

        .sidebar-news-title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
            transition: color .2s ease;
        }

        .track-cta-icon {
            width: 64px;
            height: 64px;
            background: #e8edf5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: #051836;
        }

        @media (max-width: 768px) {
            .news-article {
                padding: 1.5rem;
            }

            .news-article-cover {
                height: 200px;
            }
        }
    </style>
@endpush

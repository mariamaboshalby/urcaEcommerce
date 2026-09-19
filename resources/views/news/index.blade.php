﻿@extends('layouts.app')

@section('title', (app()->getLocale() === 'ar' ? 'أحدث الأخبار' : 'Latest News') . ' - urca')

@section('content')

    {{-- Page Header --}}
    <div style="background:linear-gradient(135deg,#0f172a 0%,#030f1f 100%);padding:2.5rem 0;">
        <div class="container">
            <h1 class="text-white fw-bold mb-1">{{ app()->getLocale() === 'ar' ? 'أحدث الأخبار' : 'Latest News' }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            class="text-white-50 text-decoration-none">{{ __('app.nav_home') }}</a></li>
                    <li class="breadcrumb-item active text-white-50">{{ __('app.nav_news') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="bg-white border-bottom shadow-sm py-3">
        <div class="container">
            <ul class="nav gap-2 flex-wrap" id="newsTabs">
                <li class="nav-item">
                    <button class="news-tab active" data-filter="all">
                        <i class="fas fa-th-large me-1"></i>
                        {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
                    </button>
                </li>
                @php $cats = collect($news)->pluck('category')->unique(); @endphp
                @foreach ($cats as $cat)
                    <li class="nav-item">
                        <button class="news-tab" data-filter="{{ $cat }}">{{ $cat }}</button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- News Grid --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4" id="newsGrid">
                @foreach ($news as $item)
                    <div class="col-lg-4 col-md-6 news-item" data-category="{{ $item['category'] }}">
                        <article class="news-card card h-100 border-0 shadow-sm">
                            {{-- Image area --}}
                            <div class="news-img-area position-relative">
                                <div class="news-placeholder d-flex align-items-center justify-content-center">
                                    <i class="fas fa-tv text-white opacity-15" style="font-size:4rem;"></i>
                                </div>
                                <span
                                    class="badge bg-white text-primary position-absolute top-0 end-0 m-3 px-3 py-2 fw-bold"
                                    style="border-radius:50px;font-size:.75rem;">
                                    {{ $item['category'] }}
                                </span>
                                <span
                                    class="position-absolute bottom-0 start-0 m-3 d-flex align-items-center gap-1 text-white-50"
                                    style="font-size:.75rem;">
                                    <i class="fas fa-eye"></i> {{ number_format($item['views']) }}
                                </span>
                            </div>

                            <div class="card-body d-flex flex-column p-4">
                                {{-- Meta --}}
                                <div class="d-flex gap-3 text-muted mb-3" style="font-size:.8125rem;">
                                    <span><i
                                            class="fas fa-calendar-alt text-primary me-1"></i>{{ \Carbon\Carbon::parse($item['date'])->format('d M Y') }}</span>
                                    <span><i class="fas fa-user text-primary me-1"></i>{{ $item['author'] }}</span>
                                </div>

                                {{-- Title --}}
                                <h5 class="fw-bold text-dark news-title mb-2">{{ $item['title'] }}</h5>

                                {{-- Excerpt --}}
                                <p class="text-secondary news-excerpt flex-grow-1 mb-3" style="font-size:.9375rem;">
                                    {{ $item['excerpt'] }}</p>

                                {{-- Read More --}}
                                <a href="{{ route('news.show', $item['id']) }}"
                                    class="btn btn-outline-primary btn-sm align-self-start px-4 rounded-pill">
                                    {{ app()->getLocale() === 'ar' ? 'اقرأ المزيد' : 'Read More' }}
                                    <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            {{-- Empty state --}}
            <div id="newsEmpty" class="d-none text-center py-5">
                <div
                    style="width:80px;height:80px;background:#e8edf5;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;color:#051836;margin:0 auto 1.25rem;">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">
                    {{ app()->getLocale() === 'ar' ? 'لا توجد أخبار في هذه الفئة' : 'No news in this category' }}</h5>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .news-card {
            border-radius: 16px !important;
            overflow: hidden;
            transition: all .3s ease;
            border-top: 3px solid transparent !important;
        }

        .news-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, .12) !important;
            border-top-color: #051836 !important;
        }

        .news-img-area {
            height: 200px;
            background: linear-gradient(135deg, #030f1f 0%, #051836 100%);
            overflow: hidden;
        }

        .news-placeholder {
            width: 100%;
            height: 100%;
        }

        .news-title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .news-excerpt {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.7;
        }

        .news-card:hover .news-title {
            color: #051836 !important;
        }

        .news-tab {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: .45rem 1.1rem;
            font-size: .875rem;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all .2s ease;
        }

        .news-tab:hover,
        .news-tab.active {
            background: #051836;
            border-color: #051836;
            color: #fff;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.news-tab');
            const items = document.querySelectorAll('.news-item');
            const empty = document.getElementById('newsEmpty');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.dataset.filter;
                    let visible = 0;
                    items.forEach(item => {
                        const match = filter === 'all' || item.dataset.category === filter;
                        item.style.display = match ? '' : 'none';
                        if (match) visible++;
                    });
                    empty.classList.toggle('d-none', visible > 0);
                });
            });
        });
    </script>
@endpush

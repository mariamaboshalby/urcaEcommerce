@extends('layouts.app')
@section('title', __('app.nav_blog') . ' - urca')

@section('content')

    {{-- Hero Header --}}
    <div class="blog-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span
                        class="badge bg-white bg-opacity-20 text-white px-3 py-2 mb-3 d-inline-flex align-items-center gap-2"
                        style="border-radius:50px;border:1px solid rgba(255,255,255,.3);">
                        <i class="fas fa-pen-fancy"></i> {{ __('app.home_blog_badge') }}
                    </span>
                    <h1 class="text-white fw-bold mb-2" style="font-size:clamp(1.75rem,4vw,2.75rem);">
                        {{ __('app.home_blog_title') }}</h1>
                    <p class="text-white-50 mb-0" style="font-size:1.0625rem;">
                        {{ app()->getLocale() === 'ar' ? 'نشارككم أحدث المقالات والمراجعات في عالم الإلكترونيات والملحقات والتقنية' : 'Stay updated with the latest electronics reviews, accessories, and tech guides' }}
                    </p>
                </div>
                <div class="col-lg-5 mt-4 mt-lg-0">
                    {{-- Search Bar --}}
                    <form action="{{ route('blog.index') }}" method="GET" class="blog-search-form">
                        <div class="blog-search-wrap">
                            <i class="fas fa-search blog-search-icon"></i>
                            <input type="text" name="search"
                                placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث في المقالات...' : 'Search articles...' }}"
                                value="{{ request('search') }}" class="blog-search-input" autocomplete="off">
                            <button type="submit" class="blog-search-btn">
                                {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
                            </button>
                        </div>
                    </form>
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
                    <li class="breadcrumb-item active text-muted">{{ __('app.nav_blog') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5" style="background:#f8fafc;">
        <div class="container">

            {{-- Results count --}}
            @if (request('search'))
                <div class="alert border-0 bg-white shadow-sm rounded-4 d-flex align-items-center gap-3 mb-4"
                    style="border-left:4px solid #051836 !important;">
                    <i class="fas fa-search text-primary fs-5"></i>
                    <span class="text-secondary">
                        {{ app()->getLocale() === 'ar' ? 'نتائج البحث عن' : 'Search results for' }}
                        <strong class="text-dark">"{{ request('search') }}"</strong>
                        — {{ $posts->count() }} {{ app()->getLocale() === 'ar' ? 'مقالة' : 'article(s)' }}
                    </span>
                    <a href="{{ route('blog.index') }}" class="ms-auto btn btn-sm btn-outline-secondary rounded-pill">
                        <i class="fas fa-times me-1"></i>{{ app()->getLocale() === 'ar' ? 'مسح' : 'Clear' }}
                    </a>
                </div>
            @endif

            @if ($posts->count() > 0)

                {{-- Featured post (first one, bigger) --}}
                @if (!request('search') && $posts->count() >= 1)
                    @php
                        $featured = $posts->first();
                        $rest = $posts->skip(1);
                    @endphp
                    <div class="blog-featured-card mb-5">
                        <a href="{{ route('blog.show', $featured->id) }}" class="text-decoration-none">
                            <div class="blog-featured-inner">
                                <div class="blog-featured-img">
                                    <div class="blog-featured-gradient d-flex align-items-center justify-content-center">
                                        <i class="fas fa-pen-nib text-white" style="font-size:6rem;opacity:.15;"></i>
                                    </div>
                                    <div class="blog-featured-overlay">
                                        <span class="blog-cat-badge">{{ $featured->category }}</span>
                                    </div>
                                </div>
                                <div class="blog-featured-body">
                                    <div class="d-flex flex-wrap gap-3 mb-3" style="font-size:.875rem;">
                                        <span class="text-muted"><i
                                                class="fas fa-calendar-alt text-primary me-1"></i>{{ $featured->published_at?->format('d M Y') }}</span>
                                        <span class="text-muted"><i
                                                class="fas fa-user text-primary me-1"></i>{{ $featured->author }}</span>
                                        <span class="text-muted"><i
                                                class="fas fa-clock text-primary me-1"></i>{{ $featured->read_time }}
                                            {{ __('app.home_blog_min_read') }}</span>
                                        <span class="text-muted"><i
                                                class="fas fa-eye text-primary me-1"></i>{{ number_format($featured->views) }}</span>
                                    </div>
                                    <h2 class="fw-bold text-dark blog-featured-title mb-3">{{ $featured->getLocalTitle() }}
                                    </h2>
                                    <p class="text-secondary mb-4" style="font-size:1rem;line-height:1.8;">
                                        {{ $featured->getLocalExcerpt() }}</p>
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                        <div class="d-flex gap-2 flex-wrap">
                                            @foreach ($featured->tags ?? [] as $tag)
                                                <span class="blog-tag">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                        <span class="btn btn-primary rounded-pill px-4">
                                            {{ __('app.home_blog_read_more') }} <i class="fas fa-arrow-right ms-2"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Rest of posts --}}
                    <div class="row g-4">
                        @foreach ($rest as $post)
                            <div class="col-md-6 col-xl-4">
                                @include('blog._card', ['post' => $post])
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Search results grid --}}
                    <div class="row g-4">
                        @foreach ($posts as $post)
                            <div class="col-md-6 col-xl-4">
                                @include('blog._card', ['post' => $post])
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="text-center py-5 my-3">
                    <div class="empty-icon-wrap mx-auto mb-4">
                        <i class="fas fa-blog"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">
                        {{ app()->getLocale() === 'ar' ? 'لا توجد مقالات' : 'No Articles Found' }}
                    </h4>
                    <p class="text-secondary mb-4">
                        {{ request('search')
                            ? (app()->getLocale() === 'ar'
                                ? 'لم نجد مقالات تطابق بحثك. جرّب كلمات أخرى.'
                                : 'No articles match your search. Try different keywords.')
                            : (app()->getLocale() === 'ar'
                                ? 'لم يتم نشر أي مقالات بعد. عد لاحقاً!'
                                : 'No articles published yet. Check back soon!') }}
                    </p>
                    <a href="{{ route('blog.index') }}" class="btn btn-primary rounded-pill px-5">
                        <i
                            class="fas fa-home me-2"></i>{{ app()->getLocale() === 'ar' ? 'العودة للمدونة' : 'Back to Blog' }}
                    </a>
                </div>
            @endif

        </div>
    </section>

@endsection

@push('styles')
    <style>
        /* ── Hero ── */
        .blog-hero {
            background: linear-gradient(135deg, #0f172a 0%, #030f1f 60%, #051836 100%);
            padding: 3.5rem 0 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .blog-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* ── Search ── */
        .blog-search-wrap {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, .12);
            border: 1.5px solid rgba(255, 255, 255, .25);
            border-radius: 50px;
            padding: .375rem .375rem .375rem 1.25rem;
            backdrop-filter: blur(10px);
            transition: all .3s ease;
        }

        .blog-search-wrap:focus-within {
            background: rgba(255, 255, 255, .2);
            border-color: rgba(255, 255, 255, .5);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, .1);
        }

        .blog-search-icon {
            color: rgba(255, 255, 255, .6);
            margin-right: .5rem;
            flex-shrink: 0;
        }

        .blog-search-input {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            color: #fff;
            font-size: .9375rem;
            min-width: 0;
        }

        .blog-search-input::placeholder {
            color: rgba(255, 255, 255, .5);
        }

        .blog-search-btn {
            background: #051836;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: .55rem 1.25rem;
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all .2s ease;
        }

        .blog-search-btn:hover {
            background: #030f1f;
        }

        /* ── Featured Card ── */
        .blog-featured-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .08);
            transition: all .35s ease;
            border: 1px solid #e2e8f0;
        }

        .blog-featured-card:hover {
            box-shadow: 0 16px 56px rgba(37, 99, 235, .15);
            transform: translateY(-4px);
        }

        .blog-featured-inner {
            display: grid;
            grid-template-columns: 380px 1fr;
        }

        .blog-featured-img {
            position: relative;
            min-height: 280px;
        }

        .blog-featured-gradient {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0f172a 0%, #051836 100%);
            min-height: 280px;
        }

        .blog-featured-overlay {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
        }

        .blog-cat-badge {
            display: inline-block;
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(10px);
            color: #fff;
            font-size: .75rem;
            font-weight: 700;
            padding: .35rem 1rem;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, .3);
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .blog-featured-body {
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .blog-featured-title {
            font-size: clamp(1.25rem, 2.5vw, 1.625rem);
            line-height: 1.35;
            color: #0f172a;
            transition: color .25s ease;
        }

        .blog-featured-card:hover .blog-featured-title {
            color: #051836;
        }

        /* ── Post Card ── */
        .blog-card {
            border-radius: 16px !important;
            overflow: hidden;
            transition: all .3s ease;
            border: 1px solid #e2e8f0 !important;
        }

        .blog-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, .12) !important;
        }

        .blog-header-area {
            height: 200px;
            position: relative;
        }

        .blog-gradient-bg {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #030f1f 0%, #051836 100%);
        }

        .blog-title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .blog-excerpt {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.7;
        }

        .blog-card:hover .blog-title {
            color: #051836 !important;
        }

        .blog-tag {
            display: inline-block;
            background: #e8edf5;
            color: #051836;
            font-size: .75rem;
            font-weight: 600;
            padding: .25rem .7rem;
            border-radius: 50px;
            border: 1px solid #c3d0e3;
        }

        /* ── Empty State ── */
        .empty-icon-wrap {
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

        @media (max-width: 768px) {
            .blog-featured-inner {
                grid-template-columns: 1fr;
            }

            .blog-featured-img {
                min-height: 200px;
            }

            .blog-featured-body {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

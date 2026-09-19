﻿@extends('layouts.app')

@section('title', (app()->getLocale() === 'ar' ? 'مركز التحميل' : 'Download Center') . ' - urca')

@section('content')

    {{-- Page Header --}}
    <div style="background:linear-gradient(135deg,#0f172a 0%,#030f1f 100%);padding:2.5rem 0;">
        <div class="container">
            <h1 class="text-white fw-bold mb-1">
                {{ app()->getLocale() === 'ar' ? 'مركز التحميل' : 'Download Center' }}
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">{{ __('app.nav_home') }}</a>
                    </li>
                    <li class="breadcrumb-item active text-white-50">{{ __('app.nav_downloads') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="bg-white border-bottom shadow-sm py-3">
        <div class="container">
            <ul class="nav gap-2 flex-wrap" id="downloadTabs">
                <li class="nav-item">
                    <button class="dl-tab active" data-filter="all">
                        <i class="fas fa-th-large me-1"></i>
                        {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
                    </button>
                </li>
                @foreach ($categories as $cat)
                    <li class="nav-item">
                        <button class="dl-tab" data-filter="{{ $cat }}">
                            @php
                                $catIcons = [
                                    'Drivers' => 'fa-microchip',
                                    'Software' => 'fa-laptop-code',
                                    'Manuals' => 'fa-file-pdf',
                                    'Catalogues' => 'fa-book',
                                ];
                            @endphp
                            <i class="fas {{ $catIcons[$cat] ?? 'fa-folder' }} me-1"></i>{{ $cat }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Downloads List --}}
    <section class="py-5 bg-light">
        <div class="container">

            @if ($downloads->count() > 0)
                <div class="d-flex flex-column gap-3" id="downloadsList">
                    @foreach ($downloads as $item)
                        <div class="download-card card border-0 shadow-sm" data-category="{{ $item->category }}">
                            <div class="card-body d-flex align-items-center gap-4 p-4">

                                {{-- Icon / Image --}}
                                <div class="dl-icon flex-shrink-0">
                                    @if ($item->image)
                                        <img src="{{ $item->image }}" alt="{{ $item->title }}"
                                            class="w-100 h-100 rounded-3" style="object-fit:cover;">
                                    @else
                                        <i class="fas {{ $item->icon ?? 'fa-file-download' }}"></i>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                                        <h5 class="mb-0 fw-bold text-dark">{{ $item->title }}</h5>
                                        @if ($item->category)
                                            <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold"
                                                style="border-radius:50px;">{{ $item->category }}</span>
                                        @endif
                                        @if ($item->brand)
                                            <span class="badge bg-info bg-opacity-10 text-info fw-semibold"
                                                style="border-radius:50px;">{{ $item->brand }}</span>
                                        @endif
                                    </div>
                                    @if ($item->description)
                                        <p class="text-secondary mb-2 small">{{ $item->description }}</p>
                                    @endif
                                    <div class="d-flex flex-wrap gap-3 text-muted" style="font-size:.8125rem;">
                                        @if ($item->version)
                                            <span><i
                                                    class="fas fa-code-branch text-primary me-1"></i>v{{ $item->version }}</span>
                                        @endif
                                        @if ($item->size)
                                            <span><i class="fas fa-hdd text-primary me-1"></i>{{ $item->size }}</span>
                                        @endif
                                        @if ($item->os)
                                            <span><i
                                                    class="fas fa-desktop text-primary me-1"></i>{{ $item->os }}</span>
                                        @endif
                                        <span>
                                            <i class="fas fa-download text-primary me-1"></i>
                                            {{ number_format($item->downloads) }}
                                            {{ app()->getLocale() === 'ar' ? 'تحميل' : 'downloads' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Download Button --}}
                                <div class="flex-shrink-0">
                                    @if ($item->file_url)
                                        <a href="{{ $item->file_url }}" target="_blank" rel="noopener"
                                            class="btn btn-primary d-flex flex-column align-items-center px-4 py-3 gap-1 dl-btn">
                                            <i class="fas fa-download fs-5"></i>
                                            <span
                                                style="font-size:.8rem;">{{ app()->getLocale() === 'ar' ? 'تحميل' : 'Download' }}</span>
                                        </a>
                                    @else
                                        <button
                                            class="btn btn-secondary d-flex flex-column align-items-center px-4 py-3 gap-1"
                                            disabled>
                                            <i class="fas fa-clock fs-5"></i>
                                            <span
                                                style="font-size:.8rem;">{{ app()->getLocale() === 'ar' ? 'قريباً' : 'Soon' }}</span>
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Empty state --}}
            <div id="emptyState" class="{{ $downloads->count() === 0 ? '' : 'd-none' }} text-center py-5">
                <div
                    style="width:80px;height:80px;background:#e8edf5;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;color:#051836;margin:0 auto 1.25rem;">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">
                    {{ app()->getLocale() === 'ar' ? 'لا توجد ملفات في هذه الفئة' : 'No files in this category' }}
                </h5>
                <p class="text-muted small">
                    {{ app()->getLocale() === 'ar' ? 'جرّب فئة أخرى أو عد لاحقاً.' : 'Try another category or check back later.' }}
                </p>
            </div>

        </div>
    </section>

@endsection

@push('styles')
    <style>
        .dl-icon {
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
            overflow: hidden;
            flex-shrink: 0;
        }

        .download-card {
            border: 2px solid transparent !important;
            transition: all .3s ease;
            border-radius: 14px !important;
        }

        .download-card:hover {
            border-color: #051836 !important;
            box-shadow: 0 8px 28px rgba(37, 99, 235, .12) !important;
        }

        .download-card:hover .dl-icon {
            background: #051836;
            color: #fff;
        }

        .dl-tab {
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

        .dl-tab:hover,
        .dl-tab.active {
            background: #051836;
            border-color: #051836;
            color: #fff;
        }

        .dl-btn {
            transition: all .25s ease;
            border-radius: 12px !important;
        }

        .dl-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, .3);
        }

        @media (max-width: 768px) {
            .download-card .card-body {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .download-card .card-body>div:last-child {
                width: 100%;
            }

            .download-card .card-body>div:last-child .btn,
            .download-card .card-body>div:last-child button {
                width: 100%;
                flex-direction: row;
                justify-content: center;
                gap: .5rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.dl-tab');
            const cards = document.querySelectorAll('.download-card');
            const empty = document.getElementById('emptyState');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.dataset.filter;
                    let visible = 0;
                    cards.forEach(card => {
                        const match = filter === 'all' || card.dataset.category === filter;
                        card.style.display = match ? '' : 'none';
                        if (match) visible++;
                    });
                    empty.classList.toggle('d-none', visible > 0);
                });
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('title', __('app.prod_page_title'))

@section('content')

{{-- Page Header --}}
<div style="background:linear-gradient(135deg,#0f172a 0%,#030f1f 100%);padding:2.5rem 0;">
    <div class="container-fluid px-3 px-lg-4" style="max-width:1680px;margin-inline:auto;">
        <h1 class="text-white fw-bold mb-1">{{ __('app.prod_header_title') }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">{{ __('app.prod_breadcrumb_home') }}</a>
                </li>
                <li class="breadcrumb-item active text-white-50">{{ __('app.prod_header_title') }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5 bg-light">
    <div class="container-fluid px-3 px-lg-4" style="max-width:1680px;margin-inline:auto;">
        <div class="row g-4">

            {{-- Sidebar --}}
            <div class="col-lg-3">

                {{-- Mobile: Filter toggle button --}}
                <button class="btn btn-primary w-100 d-lg-none mb-3 d-flex align-items-center justify-content-between px-4 py-2 rounded-3"
                        id="filterToggleBtn"
                        type="button"
                        aria-expanded="false"
                        aria-controls="filterCollapse">
                    <span class="d-flex align-items-center gap-2 fw-semibold">
                        <i class="fas fa-filter"></i> {{ __('app.prod_filter_btn') }}
                        @if($category !== 'all' || $sort !== 'default' || $search)
                        <span class="badge bg-white text-primary ms-1" style="font-size:.7rem;">{{ __('app.prod_filter_active') }}</span>
                        @endif
                    </span>
                    <i class="fas fa-chevron-down" id="filterChevron" style="transition:transform .25s ease;"></i>
                </button>

                {{-- Filter card --}}
                <div id="filterCollapse" class="d-none d-lg-block">
                    <div class="card border-0 shadow-sm sticky-top" style="border-radius:16px;top:90px;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2 d-none d-lg-flex">
                                <i class="fas fa-filter"></i> {{ __('app.prod_filter_title') }}
                            </h6>

                            {{-- Search --}}
                            @php $withSearch = $search ? ['search' => $search] : []; @endphp
                            <div class="mb-4">
                                <p class="text-uppercase text-muted fw-semibold mb-2" style="font-size:.75rem;letter-spacing:.5px;">{{ __('app.search') }}</p>
                                <form method="GET" action="{{ route('products.index') }}" role="search" class="mb-0" id="prodSearchForm" autocomplete="off">
                                    <input type="hidden" name="category" value="{{ $category }}">
                                    <input type="hidden" name="sort" value="{{ $sort }}">
                                    <div class="prod-search position-relative">
                                        <i class="fas fa-search" id="prodSearchIcon"></i>
                                        <i class="fas fa-circle-notch fa-spin" id="prodSearchSpinner" style="color:#051836;display:none;"></i>
                                        <input type="search" name="search" id="prodSearchInput" value="{{ $search }}" class="form-control"
                                               placeholder="{{ __('app.search_placeholder') }}" aria-label="{{ __('app.search') }}">
                                        <button type="button" id="prodSearchClear" class="prod-search-clear {{ $search ? '' : 'd-none' }}"
                                                aria-label="{{ __('app.prod_search_clear') }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Category tree filter --}}
                            <div class="mb-4">
                                <p class="text-uppercase text-muted fw-semibold mb-2" style="font-size:.75rem;letter-spacing:.5px;">{{ __('app.prod_cat_label') }}</p>

                                {{-- All --}}
                                <a href="{{ route('products.index', array_merge(['category' => 'all', 'sort' => $sort], $withSearch)) }}"
                                   class="filter-option d-flex align-items-center gap-2 px-3 py-2 rounded-3 mb-1 text-decoration-none {{ $category === 'all' ? 'active' : '' }}">
                                    <i class="fas fa-th-large"></i> {{ __('app.cat_all') }}
                                </a>

                                @foreach($dbCategories as $root)
                                {{-- Root --}}
                                <div class="mb-1">
                                    <a href="{{ route('products.index', array_merge(['category' => $root->slug, 'sort' => $sort], $withSearch)) }}"
                                       class="filter-option d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none {{ $category === $root->slug ? 'active' : '' }}"
                                       style="font-weight:600;">
                                        @if($root->image)
                                            <img src="{{ asset('storage/' . $root->image) }}" alt="" style="width:18px;height:18px;object-fit:cover;border-radius:3px;flex-shrink:0;">
                                        @else
                                            <i class="fas fa-{{ $root->icon ?? 'folder' }}" style="width:16px;text-align:center;"></i>
                                        @endif
                                        <span>{{ app()->getLocale() === 'ar' ? $root->name_ar : $root->name_en }}</span>
                                        @if($root->children->isNotEmpty())
                                            <i class="fas fa-chevron-down ms-auto" style="font-size:.65rem;color:#94a3b8;"></i>
                                        @endif
                                    </a>

                                    {{-- Level 1 children --}}
                                    @if($root->children->isNotEmpty())
                                    <div class="ps-3 mt-1" style="border-inline-start:2px solid #e2e8f0;margin-inline-start:1.1rem;">
                                        @foreach($root->children as $sub)
                                        <div class="mb-1">
                                            <a href="{{ route('products.index', array_merge(['category' => $sub->slug, 'sort' => $sort], $withSearch)) }}"
                                               class="filter-option d-flex align-items-center gap-2 px-2 py-1 rounded-3 text-decoration-none {{ $category === $sub->slug ? 'active' : '' }}"
                                               style="font-size:.85rem;">
                                                <i class="fas fa-{{ $sub->icon ?? 'tag' }}" style="font-size:.7rem;width:12px;text-align:center;color:#94a3b8;"></i>
                                                <span>{{ app()->getLocale() === 'ar' ? $sub->name_ar : $sub->name_en }}</span>
                                            </a>

                                            {{-- Level 2 grandchildren --}}
                                            @if($sub->children->isNotEmpty())
                                            <div class="ps-2 mt-1" style="border-inline-start:2px solid #f1f5f9;margin-inline-start:1rem;">
                                                @foreach($sub->children as $subsub)
                                                <a href="{{ route('products.index', array_merge(['category' => $subsub->slug, 'sort' => $sort], $withSearch)) }}"
                                                   class="filter-option d-flex align-items-center gap-1 px-2 py-1 rounded-3 text-decoration-none mb-1 {{ $category === $subsub->slug ? 'active' : '' }}"
                                                   style="font-size:.78rem;">
                                                    <i class="fas fa-circle" style="font-size:.35rem;color:#cbd5e1;width:10px;text-align:center;"></i>
                                                    <span>{{ app()->getLocale() === 'ar' ? $subsub->name_ar : $subsub->name_en }}</span>
                                                </a>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>

                            {{-- Sort By --}}
                            <div>
                                <p class="text-uppercase text-muted fw-semibold mb-2" style="font-size:.75rem;letter-spacing:.5px;">{{ __('app.prod_sort_label') }}</p>
                                <a href="{{ route('products.index', array_merge(['category' => $category, 'sort' => 'default'], $withSearch)) }}"
                                   class="filter-option d-flex align-items-center gap-2 px-3 py-2 rounded-3 mb-1 text-decoration-none {{ $sort === 'default' ? 'active' : '' }}">
                                    <i class="fas fa-list"></i> {{ __('app.prod_sort_default') }}
                                </a>
                                <a href="{{ route('products.index', array_merge(['category' => $category, 'sort' => 'price_asc'], $withSearch)) }}"
                                   class="filter-option d-flex align-items-center gap-2 px-3 py-2 rounded-3 mb-1 text-decoration-none {{ $sort === 'price_asc' ? 'active' : '' }}">
                                    <i class="fas fa-arrow-up"></i> {{ __('app.prod_sort_price_asc') }}
                                </a>
                                <a href="{{ route('products.index', array_merge(['category' => $category, 'sort' => 'price_desc'], $withSearch)) }}"
                                   class="filter-option d-flex align-items-center gap-2 px-3 py-2 rounded-3 mb-1 text-decoration-none {{ $sort === 'price_desc' ? 'active' : '' }}">
                                    <i class="fas fa-arrow-down"></i> {{ __('app.prod_sort_price_desc') }}
                                </a>
                                <a href="{{ route('products.index', array_merge(['category' => $category, 'sort' => 'rating'], $withSearch)) }}"
                                   class="filter-option d-flex align-items-center gap-2 px-3 py-2 rounded-3 mb-1 text-decoration-none {{ $sort === 'rating' ? 'active' : '' }}">
                                    <i class="fas fa-star"></i> {{ __('app.prod_sort_rating') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Products Main --}}
            <div class="col-lg-9">
                <div id="productsLive" class="products-live">
                    @include('products._grid')
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Product image lightbox --}}
<div class="prod-lightbox" id="prodLightbox" hidden>
    <div class="prod-lightbox-backdrop"></div>
    <div class="prod-lightbox-body">
        <button class="prod-lightbox-close" type="button" aria-label="Close">&times;</button>
        <img src="" alt="">
        <p class="prod-lightbox-cap"></p>
    </div>
</div>

@endsection

@push('styles')
<style>
.filter-option {
    color: #475569;
    font-size: .9rem;
    transition: all .2s ease;
}
.filter-option:hover,
.filter-option.active {
    background: #e8edf5;
    color: #051836;
    font-weight: 600;
}
.prod-search i {
    position: absolute;
    inset-inline-start: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: .85rem;
    pointer-events: none;
}
.prod-search input {
    padding-inline-start: 2.4rem;
    padding-inline-end: 2.2rem;
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    font-size: .9rem;
}
.prod-search input:focus {
    border-color: #051836;
    box-shadow: none;
}
.prod-search-clear {
    position: absolute;
    inset-inline-end: 8px;
    top: 50%;
    transform: translateY(-50%);
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f1f5f9;
    color: #64748b;
    text-decoration: none;
    font-size: .7rem;
}
.prod-search-clear:hover {
    background: #fee2e2;
    color: #ef4444;
}
.prod-search-clear {
    border: none;
    padding: 0;
    cursor: pointer;
}
.products-live {
    transition: opacity .2s ease;
}
.products-live.is-loading {
    opacity: .45;
    pointer-events: none;
}
.product-card {
    border-radius: 14px !important;
    overflow: hidden;
    transition: all .3s ease;
    position: relative;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 36px rgba(0,0,0,.12) !important;
}
.product-img-area {
    height: 180px;
    background: #f8fafc;
    overflow: hidden;
    position: relative;
}
.product-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    color: #cbd5e1;
}
.product-name {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}
.product-desc {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.6;
}
.d-grid { display: grid; }

/* ── Products per row: 2 (mobile) / 3 (md) / 4 (lg) / 5 (xl+) ── */
@media (min-width: 992px) {
    .products-live .row > .prod-col { flex: 0 0 25%; max-width: 25%; }
}
@media (min-width: 1200px) {
    .products-live .row > .prod-col { flex: 0 0 20%; max-width: 20%; }
}

/* ── Card action buttons ── */
.prod-actions {
    display: flex;
    align-items: stretch;
    gap: .4rem;
}
.prod-cart-btn {
    flex: 1 1 auto;
    min-width: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    padding: .45rem .6rem;
    font-size: .82rem;
    line-height: 1.1;
    border-radius: 10px;
}
.prod-cart-btn .fa-cart-shopping {
    flex-shrink: 0;
    font-size: .85rem;
}
.prod-cart-label {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.prod-view-btn {
    flex: 0 0 auto;
    width: 40px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
}

/* ── Fav button ── */
.fav-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    left: auto;
    z-index: 3;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(4px);
    color: #cbd5e1;
    font-size: .95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,.12);
    transition: color .2s ease, transform .2s ease, background .2s ease;
}
.fav-btn:hover {
    background: #fff;
    color: #f43f5e;
    transform: scale(1.12);
}
.fav-btn.active {
    color: #f43f5e;
    background: #fff0f3;
}
.fav-btn.pop {
    animation: fav-pop .3s ease;
}
@keyframes fav-pop {
    0%   { transform: scale(1);    }
    50%  { transform: scale(1.35); }
    100% { transform: scale(1);    }
}

/* ── Product image lightbox ── */
.product-img-zoom { cursor: zoom-in; }
.prod-lightbox { position: fixed; inset: 0; z-index: 2000; display: flex; align-items: center; justify-content: center; }
.prod-lightbox[hidden] { display: none; }
.prod-lightbox-backdrop { position: absolute; inset: 0; background: rgba(2,10,22,.8); backdrop-filter: blur(3px); }
.prod-lightbox-body { position: relative; max-width: 90vw; max-height: 88vh; background: #fff; border-radius: 16px; padding: 1rem; box-shadow: 0 24px 60px rgba(0,0,0,.45); display: flex; flex-direction: column; align-items: center; gap: .75rem; }
.prod-lightbox-body img { max-width: 82vw; max-height: 70vh; object-fit: contain; border-radius: 10px; }
.prod-lightbox-cap { margin: 0; color: #334155; font-weight: 600; text-align: center; }
.prod-lightbox-close { position: absolute; top: .5rem; inset-inline-end: .5rem; width: 34px; height: 34px; border: none; border-radius: 50%; background: #f1f5f9; color: #334155; font-size: 1.4rem; line-height: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.prod-lightbox-close:hover { background: #e2e8f0; }</style>
@endpush

@push('scripts')
<script>
(function () {
    const btn      = document.getElementById('filterToggleBtn');
    const collapse = document.getElementById('filterCollapse');
    const chevron  = document.getElementById('filterChevron');
    if (!btn) return;

    btn.addEventListener('click', function () {
        const isOpen = !collapse.classList.contains('d-none');
        if (isOpen) {
            collapse.classList.add('d-none');
            chevron.style.transform = 'rotate(0deg)';
            btn.setAttribute('aria-expanded', 'false');
        } else {
            collapse.classList.remove('d-none');
            chevron.style.transform = 'rotate(180deg)';
            btn.setAttribute('aria-expanded', 'true');
        }
    });
}());

/* ── Live search: re-renders the grid partial without a full page load ── */
(function () {
    const form    = document.getElementById('prodSearchForm');
    const input   = document.getElementById('prodSearchInput');
    const live    = document.getElementById('productsLive');
    const clear   = document.getElementById('prodSearchClear');
    const icon    = document.getElementById('prodSearchIcon');
    const spinner = document.getElementById('prodSearchSpinner');

    if (!form || !input || !live) return;

    const baseUrl = @json(route('products.index'));
    let timer = null;
    let controller = null;
    let seq = 0;

    function busy(on) {
        live.classList.toggle('is-loading', on);
        icon.style.display = on ? 'none' : '';
        spinner.style.display = on ? '' : 'none';
    }

    function loadFrom(partialUrl, shareUrl) {
        const my = ++seq;
        if (controller) controller.abort();
        controller = new AbortController();
        busy(true);

        fetch(partialUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, signal: controller.signal })
            .then(r => r.ok ? r.text() : Promise.reject(new Error('products/live: bad response (' + r.status + ')')))
            .then(html => {
                live.innerHTML = html;
                history.replaceState(null, '', shareUrl);
            })
            .catch(err => { if (err.name !== 'AbortError') console.error(err); })
            .finally(() => { if (my === seq) busy(false); });
    }

    function searchLoad() {
        const params = new URLSearchParams({
            category: form.category.value,
            sort: form.sort.value,
        });
        const term = input.value.trim();
        if (term) params.set('search', term);

        const partial = new URLSearchParams(params);
        partial.set('partial', '1');

        loadFrom(baseUrl + '?' + partial.toString(), baseUrl + '?' + params.toString());
    }

    input.addEventListener('input', function () {
        clear.classList.toggle('d-none', input.value.trim() === '');
        clearTimeout(timer);
        timer = setTimeout(searchLoad, 350);
    });

    // Enter still submits the form for no-JS visitors, so only intercept it here.
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearTimeout(timer);
        searchLoad();
    });

    clear.addEventListener('click', function () {
        input.value = '';
        clear.classList.add('d-none');
        clearTimeout(timer);
        searchLoad();
        input.focus();
    });

    // Pagination inside the grid is loaded the same way, keeping the sidebar in sync.
    live.addEventListener('click', function (e) {
        const link = e.target.closest('.pagination a');
        if (!link || !link.href) return;
        e.preventDefault();

        const u = new URL(link.href);
        const cat  = u.searchParams.get('category');
        const sort = u.searchParams.get('sort');
        const term = u.searchParams.get('search') || '';

        if (cat !== null) form.category.value = cat;
        if (sort !== null) form.sort.value = sort;
        input.value = term;
        clear.classList.toggle('d-none', term === '');

        u.searchParams.set('partial', '1');
        loadFrom(u.toString(), link.href);
    });
}());

/* ── Product image lightbox: click card image to enlarge (delegated to survive live-search re-renders) ── */
(function () {
    const lb = document.getElementById('prodLightbox');
    if (!lb) return;
    const lbImg = lb.querySelector('img');
    const lbCap = lb.querySelector('.prod-lightbox-cap');
    const open = (src, name) => {
        lbImg.src = src;
        lbImg.alt = name || '';
        lbCap.textContent = name || '';
        lb.hidden = false;
        document.body.style.overflow = 'hidden';
    };
    const close = () => {
        lb.hidden = true;
        lbImg.src = '';
        document.body.style.overflow = '';
    };
    document.addEventListener('click', function (e) {
        const z = e.target.closest('.product-img-zoom');
        if (!z) return;
        e.preventDefault();
        e.stopPropagation();
        const f = z.getAttribute('data-full');
        if (f) open(f, z.getAttribute('data-name'));
    });
    lb.addEventListener('click', function (e) {
        if (e.target === lb || e.target.classList.contains('prod-lightbox-backdrop') || e.target.classList.contains('prod-lightbox-close')) close();
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
}());
</script>
@endpush

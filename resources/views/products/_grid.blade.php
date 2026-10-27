{{-- Products grid: re-rendered on its own for live search (see ProductController::index) --}}

<div class="d-flex justify-content-between align-items-center mb-4 px-3 py-2 bg-white rounded-3 shadow-sm border">
    <span class="text-secondary fw-semibold">{{ __('app.prod_found', ['count' => $products->total()]) }}</span>
    @if($search)
        <a href="{{ route('products.index', ['category' => $category, 'sort' => $sort]) }}"
           class="d-flex align-items-center gap-2 text-decoration-none px-3 py-2 rounded-pill"
           style="background:#e8edf5;color:#051836;font-weight:600;font-size:.85rem;">
            {{ __('app.prod_search_results', ['term' => $search]) }}
            <i class="fas fa-times"></i>
        </a>
    @endif
</div>

@if(count($products) > 0)
<div class="row g-3">
    @foreach($products as $index => $product)
    <div class="col-6 col-md-4 prod-col">
        <a href="{{ route('products.show', $product['id']) }}"
           class="product-card card border-0 shadow-sm h-100 text-decoration-none">

            @if($product['badge'])
            <span class="badge bg-danger position-absolute top-0 m-2 px-2 py-1" style="z-index:2;border-radius:8px;left:8px;">{{ $product['badge'] }}</span>
            @endif

            {{-- Fav button --}}
            <button class="fav-btn"
                    data-id="{{ $product['id'] }}"
                    data-name="{{ $product['name'] }}"
                    data-price="{{ $product['price'] }}"
                    data-img="{{ $product['image_url'] }}"
                    aria-label="Add to favourites"
                    onclick="event.preventDefault();event.stopPropagation();toggleFav(this)">
                <i class="fas fa-heart"></i>
            </button>

            {{-- Image --}}
            <div class="product-img-area{{ !empty($product['full_url']) ? ' product-img-zoom' : '' }}" data-full="{{ $product['full_url'] ?? '' }}" data-name="{{ $product['name'] }}">
                @if(!empty($product['image_url']))
                    <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}"
                         class="w-100 h-100" style="object-fit:cover;"
                         loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                         {{ $index === 0 ? 'fetchpriority="high"' : '' }}
                         decoding="{{ $index < 3 ? 'sync' : 'async' }}"
                         width="300" height="180"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="product-placeholder" style="display:none;">
                        <i class="fas fa-image"></i>
                    </div>
                @else
                    <div class="product-placeholder">
                        <i class="fas fa-image"></i>
                    </div>
                @endif
            </div>

            <div class="card-body d-flex flex-column p-3">
                <span class="text-primary fw-bold mb-1" style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;">{{ $product['brand'] }}</span>
                <h6 class="fw-bold text-dark product-name mb-1">{{ $product['name'] }}</h6>
                <p class="text-secondary product-desc mb-2" style="font-size:.8125rem;">{{ $product['description'] }}</p>

                {{-- Stars --}}
                <div class="d-flex align-items-center gap-1 mb-2">
                    @php
                        $r = (int)$product['rating'];
                        $stars = str_repeat('<i class="fas fa-star" style="font-size:.7rem;color:#f59e0b;"></i>', $r)
                               . str_repeat('<i class="fas fa-star" style="font-size:.7rem;color:#d1d5db;"></i>', 5 - $r);
                    @endphp
                    {!! $stars !!}
                    <span class="text-muted ms-1" style="font-size:.75rem;">({{ $product['reviews'] }})</span>
                </div>

                {{-- Price --}}
                <div class="d-flex align-items-center gap-2 mb-3 mt-auto">
                    <span class="fw-bold text-primary" style="font-size:1.25rem;">{{ number_format($product['price']) }} EGP</span>
                    @if($product['old_price'])
                    <span class="text-muted text-decoration-line-through" style="font-size:.875rem;">{{ number_format($product['old_price']) }} EGP</span>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="prod-actions">
                    <button class="btn btn-primary btn-sm fw-semibold prod-cart-btn"
                            onclick="event.preventDefault();event.stopPropagation();addToCart({{ $product['id'] }}, '{{ addslashes($product['name']) }}', {{ $product['price'] }}, '{{ $product['image'] }}')">
                        <i class="fas fa-cart-shopping"></i><span class="prod-cart-label">{{ __('app.prod_add_cart') }}</span>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm prod-view-btn"
                            onclick="event.preventDefault();event.stopPropagation();window.location='{{ route('products.show', $product['id']) }}'">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

@else
{{-- Empty State --}}
<div class="text-center py-5">
    <i class="fas fa-box-open text-muted mb-3 d-block" style="font-size:3.5rem;opacity:.3;"></i>
    <h5 class="fw-bold text-dark mb-2">{{ __('app.prod_empty_title') }}</h5>
    <p class="text-secondary mb-4">{{ $search ? __('app.prod_empty_search', ['term' => $search]) : __('app.prod_empty_sub') }}</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary px-5">{{ __('app.prod_empty_btn') }}</a>
</div>
@endif

{{-- Pagination --}}
@if($products->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $products->appends(collect(request()->query())->except('partial')->all())->links() }}
</div>
@endif

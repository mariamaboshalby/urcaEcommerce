@extends('admin.layouts.app')

@section('title', 'إعدادات الصفحة الرئيسية')
@section('page-title', 'إعدادات الصفحة الرئيسية')
@section('breadcrumb')
    <i class="fas fa-chevron-left"></i>
    <span>إعدادات الصفحة الرئيسية</span>
@endsection

@section('content')
<div class="settings-container">

    <!-- Header Banner -->
    <div class="settings-hero-card">
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fas fa-sliders-h"></i>
            </div>
            <div>
                <h2>تخصيص وإعدادات الصفحة الرئيسية</h2>
                <p>تحكم في الأقسام الظاهرة لزوار متجرك، وإدارة عرض اليوم المميز، وربط وتحديث المنتجات عبر الـ API الخارجي.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="submitted" value="1">

        <!-- ════════════════════════════════════════════════════════════
             Tabs Navigation
        ════════════════════════════════════════════════════════════ -->
        <div class="settings-tabs">
            <button type="button" class="settings-tab active" data-tab="tab-sections">
                <i class="fas fa-layer-group"></i>
                <span>أقسام الصفحة الرئيسية</span>
            </button>
            <button type="button" class="settings-tab" data-tab="tab-deal">
                <i class="fas fa-bolt"></i>
                <span>عرض اليوم المميز</span>
            </button>
            <button type="button" class="settings-tab" data-tab="tab-slider">
                <i class="fas fa-images"></i>
                <span>صور السلايدر</span>
            </button>
            <button type="button" class="settings-tab" data-tab="tab-api">
                <i class="fas fa-cloud-arrow-down"></i>
                <span>ربط الـ API الخارجي</span>
            </button>
        </div>

        <!-- ════════════════════════════════════════════════════════════
             SECTION 1: Home Page Sections Toggles
        ════════════════════════════════════════════════════════════ -->
        <div class="tab-panel active" id="tab-sections">
        <div class="card mb-4">
            <div class="card-header">
                <h2>
                    <i class="fas fa-layer-group" style="color:var(--primary)"></i>
                    أقسام الصفحة الرئيسية (Sections Visibility)
                </h2>
                <span class="header-hint">تفعيل أو إخفاء أقسام الواجهة الرئيسية للمتجر</span>
            </div>
            <div class="card-body">
                <div class="toggles-grid">

                    <!-- Shop by Brand -->
                    <div class="toggle-card">
                        <div class="toggle-icon bg-blue">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="toggle-info">
                            <div class="toggle-title">تسوق حسب الماركة</div>
                            <div class="toggle-desc">عرض شعارات العلامات التجارية المميزة (Shop by Brand)</div>
                        </div>
                        <div class="toggle-action">
                            <label class="switch-toggle" title="تفعيل/تعطيل">
                                <input type="checkbox" id="home_show_brands" name="home_show_brands" value="1" {{ ($settings['home_show_brands'] ?? '0') == '1' ? 'checked' : '' }}>
                                <span class="switch-slider"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Recommended for You -->
                    <div class="toggle-card">
                        <div class="toggle-icon bg-purple">
                            <i class="fas fa-thumbs-up"></i>
                        </div>
                        <div class="toggle-info">
                            <div class="toggle-title">المقترحة لك</div>
                            <div class="toggle-desc">عرض منتجات مختارة للمستخدم (Recommended for You)</div>
                        </div>
                        <div class="toggle-action">
                            <label class="switch-toggle" title="تفعيل/تعطيل">
                                <input type="checkbox" id="home_show_recommended" name="home_show_recommended" value="1" {{ ($settings['home_show_recommended'] ?? '0') == '1' ? 'checked' : '' }}>
                                <span class="switch-slider"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Newsletter Subscription -->
                    <div class="toggle-card">
                        <div class="toggle-icon bg-green">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div class="toggle-info">
                            <div class="toggle-title">النشرة البريدية</div>
                            <div class="toggle-desc">صندوق اشتراك الزوار في العروض والجديد (Newsletter)</div>
                        </div>
                        <div class="toggle-action">
                            <label class="switch-toggle" title="تفعيل/تعطيل">
                                <input type="checkbox" id="home_show_newsletter" name="home_show_newsletter" value="1" {{ ($settings['home_show_newsletter'] ?? '0') == '1' ? 'checked' : '' }}>
                                <span class="switch-slider"></span>
                            </label>
                        </div>
                    </div>

                    <!-- FAQ Section -->
                    <div class="toggle-card">
                        <div class="toggle-icon bg-orange">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div class="toggle-info">
                            <div class="toggle-title">الأسئلة الشائعة</div>
                            <div class="toggle-desc">عرض قائمة الأسئلة الأكثر تكراراً وإجاباتها (FAQ)</div>
                        </div>
                        <div class="toggle-action">
                            <label class="switch-toggle" title="تفعيل/تعطيل">
                                <input type="checkbox" id="home_show_faq" name="home_show_faq" value="1" {{ ($settings['home_show_faq'] ?? '0') == '1' ? 'checked' : '' }}>
                                <span class="switch-slider"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Track Your Order -->
                    <div class="toggle-card">
                        <div class="toggle-icon bg-teal">
                            <i class="fas fa-truck-fast"></i>
                        </div>
                        <div class="toggle-info">
                            <div class="toggle-title">تتبع طلبك</div>
                            <div class="toggle-desc">قسم الاستعلام السريع عن حالة الشحنة بالرقم (Track Order)</div>
                        </div>
                        <div class="toggle-action">
                            <label class="switch-toggle" title="تفعيل/تعطيل">
                                <input type="checkbox" id="home_show_track_order" name="home_show_track_order" value="1" {{ ($settings['home_show_track_order'] ?? '0') == '1' ? 'checked' : '' }}>
                                <span class="switch-slider"></span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>

        <!-- ════════════════════════════════════════════════════════════
             SECTION 2: Deal of the Day Section
        ════════════════════════════════════════════════════════════ -->
        <div class="tab-panel" id="tab-deal">
        <div class="card mb-4">
            <div class="card-header">
                <h2>
                    <i class="fas fa-bolt" style="color:#F59E0B"></i>
                    عرض اليوم المميز (Deal of the Day)
                </h2>
                <div class="header-toggle">
                    <span class="toggle-label">تفعيل القسم:</span>
                    <label class="switch-toggle" title="تفعيل عرض اليوم">
                        <input type="checkbox" id="home_show_deal" name="home_show_deal" value="1" {{ ($settings['home_show_deal'] ?? '0') == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                </div>
            </div>
            <div class="card-body">
                <div class="deal-config-grid">
                    <div class="form-group">
                        <label class="form-label" for="home_deal_product_id">
                            <i class="fas fa-box-open text-muted me-1"></i> المنتج المعروض في الصفقة
                        </label>
                        <select name="home_deal_product_id" id="home_deal_product_id" class="form-control">
                            <option value="">-- اختر منتجاً لعرض اليوم --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ ($settings['home_deal_product_id'] ?? '') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ number_format($product->price, 2) }} ج.م)
                                </option>
                            @endforeach
                        </select>
                        <small class="form-hint">اختر المنتج الذي سيظهر في بنر العرض الترويجي اليومي.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="home_deal_end_time">
                            <i class="fas fa-clock text-muted me-1"></i> موعد انتهاء العرض (العد التنازلي)
                        </label>
                        <input type="datetime-local" 
                               id="home_deal_end_time" 
                               name="home_deal_end_time" 
                               class="form-control" 
                               value="{{ $settings['home_deal_end_time'] ?? '' }}">
                        <small class="form-hint">سيظهر مؤقت عد تنازلي للزوار ينتهي في هذا التوقيت.</small>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- ════════════════════════════════════════════════════════════
             SECTION 2.5: Homepage Slider Images (dynamic add / delete)
        ════════════════════════════════════════════════════════════ -->
        <input type="hidden" name="slider_count" id="sliderCount" value="{{ count($sliderSlides) }}">
        <div class="tab-panel" id="tab-slider">
        <div class="card mb-4">
            <div class="card-header">
                <h2>
                    <i class="fas fa-images" style="color:#0D9488"></i>
                    صور السلايدر في الصفحة الرئيسية (Hero Slider)
                </h2>
                <span class="header-hint">ارفع صورة واحدة لكل شريحة وسيتم تكييفها تلقائياً، ويمكنك إضافة أو حذف الشرائح بحرّية.</span>
            </div>
            <div class="card-body">
                <div class="alert alert-info" role="alert" style="font-size:.875rem;margin-bottom:1.25rem;">
                    <i class="fas fa-circle-info me-1"></i>
                    يُنصح بصورة بمقاس عريض (مثلاً 1600×800) بصيغة WebP أو JPG، بحد أقصى 4 ميجابايت. الشرائح تظهر بالترتيب المعروض هنا.
                </div>

                @php $sliderErrs = array_filter($errors->all(), fn($m) => str_contains(mb_strtolower($m), 'slider')); @endphp
                @if(!empty($sliderErrs))
                    <div class="alert alert-danger py-2" style="font-size:.85rem;">
                        @foreach($sliderErrs as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="slider-slides-grid" id="sliderSlidesContainer">
                    @foreach($sliderSlides as $i => $slide)
                        @php
                            $customImage = $slide['image'] ?? null;
                            $defaultSrc = $slide['src'] ?? null;
                            $slideLink = $slide['link'] ?? '';
                            $hasImage = $customImage && \Illuminate\Support\Facades\Storage::disk('public')->exists($customImage);
                            $imageSrc = $hasImage ? asset('storage/' . $customImage) : ($defaultSrc ? asset($defaultSrc) : '');
                        @endphp
                        <div class="slide-editor-card">
                            <div class="slide-editor-head">
                                <span class="slide-badge">الشريحة</span>
                                @if($hasImage)
                                    <span class="slide-status custom">مخصصة</span>
                                @elseif($defaultSrc)
                                    <span class="slide-status default">افتراضية</span>
                                @else
                                    <span class="slide-status new">جديدة</span>
                                @endif
                                <button type="button" class="btn-slide-delete" title="حذف الشريحة">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </button>
                            </div>
                            <div class="slide-field">
                                <div class="slide-preview" style="background-image:url('{{ $imageSrc }}')"></div>
                                <input type="hidden" data-name="slider_current[__IDX__]" name="slider_current[{{ $i }}]" value="{{ $customImage }}">
                                <input type="hidden" data-name="slider_src[__IDX__]" name="slider_src[{{ $i }}]" value="{{ $defaultSrc }}">
                                <input type="file" data-name="slider_image[__IDX__]" name="slider_image[{{ $i }}]" accept="image/jpeg,image/png,image/webp" class="form-control form-control-sm slider-file-input">
                                <small class="form-hint">صورة واحدة تكفي — يتم قصّها وتكييفها تلقائياً مع جميع الشاشات.</small>
                                <label class="slide-field-label mt-2"><i class="fas fa-link me-1"></i> رابط النقر على الصورة (اختياري)</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-arrow-pointer input-icon"></i>
                                    <input type="text" data-name="slider_link[__IDX__]" name="slider_link[{{ $i }}]" class="form-control form-control-sm" placeholder="مثال: /products أو رابط خارجي كامل" value="{{ $slideLink }}">
                                </div>
                                @if($hasImage)
                                    <label class="slide-remove">
                                        <input type="checkbox" data-name="remove_image[__IDX__]" name="remove_image[{{ $i }}]" value="1">
                                        <span>إزالة الصورة المخصصة (استرجاع الافتراضية)</span>
                                    </label>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="slider-add-bar">
                    <button type="button" class="btn btn-add-slide" id="btnAddSlide">
                        <i class="fas fa-plus"></i> إضافة شريحة جديدة
                    </button>
                </div>
            </div>
        </div>
        </div>

        {{-- Template for a new (client-side) slide row --}}
        <template id="slideRowTemplate">
            <div class="slide-editor-card">
                <div class="slide-editor-head">
                    <span class="slide-badge">الشريحة</span>
                    <span class="slide-status new">جديدة</span>
                    <button type="button" class="btn-slide-delete" title="حذف الشريحة">
                        <i class="fas fa-trash-alt"></i> حذف
                    </button>
                </div>
                <div class="slide-field">
                    <div class="slide-preview slide-preview-empty"></div>
                    <input type="hidden" data-name="slider_current[__IDX__]" name="slider_current[__IDX__]" value="">
                    <input type="hidden" data-name="slider_src[__IDX__]" name="slider_src[__IDX__]" value="">
                    <input type="file" data-name="slider_image[__IDX__]" name="slider_image[__IDX__]" accept="image/jpeg,image/png,image/webp" class="form-control form-control-sm slider-file-input">
                    <small class="form-hint">صورة واحدة تكفي — يتم قصّها وتكييفها تلقائياً مع جميع الشاشات.</small>
                    <label class="slide-field-label mt-2"><i class="fas fa-link me-1"></i> رابط النقر على الصورة (اختياري)</label>
                    <div class="input-with-icon">
                        <i class="fas fa-arrow-pointer input-icon"></i>
                        <input type="text" data-name="slider_link[__IDX__]" name="slider_link[__IDX__]" class="form-control form-control-sm" placeholder="مثال: /products أو رابط خارجي كامل" value="">
                    </div>
                </div>
            </div>
        </template>

        <!-- ════════════════════════════════════════════════════════════
             SECTION 3: External Products API Integration
        ════════════════════════════════════════════════════════════ -->
        <div class="tab-panel" id="tab-api">
        <div class="card mb-4" id="api-settings">
            <div class="card-header api-card-header">
                <div>
                    <h2>
                        <i class="fas fa-cloud-arrow-down" style="color:var(--primary)"></i>
                        ربط المنتجات من API خارجي (External Products API)
                    </h2>
                    <p class="api-header-subtitle">اربط متجرك مع نظام ERP أو API خارجي لجلب المنتجات وتحديثها تلقائياً.</p>
                </div>
                <span class="badge badge-blue">REST API</span>
            </div>
            <div class="card-body">
                <div class="api-inputs-grid">
                    <div class="form-group flex-2">
                        <label class="form-label" for="products_api_url">
                            رابط الـ API (Products Endpoint URL) <span style="color:var(--red)">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-link input-icon"></i>
                            <input type="url" 
                                   id="products_api_url" 
                                   name="products_api_url" 
                                   class="form-control" 
                                   placeholder="https://example.com/api/products" 
                                   value="{{ $settings['products_api_url'] ?? '' }}">
                        </div>
                        <small class="form-hint">يدعم صيغ JSON المختلفة، ويقوم بمطابقة حقول (الاسم، السعر، الصور، المخزون) تلقائياً.</small>
                    </div>

                    <div class="form-group flex-1">
                        <label class="form-label" for="products_api_token">
                            مفتاح الـ API / Bearer Token <span class="text-muted fw-normal">(اختياري)</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" 
                                   id="products_api_token" 
                                   name="products_api_token" 
                                   class="form-control" 
                                   placeholder="Bearer Token إن وُجد" 
                                   value="{{ $settings['products_api_token'] ?? '' }}">
                        </div>
                        <small class="form-hint">يُرسل في الـ Authorization Header للتوثيق مع الـ API.</small>
                    </div>
                </div>

                <!-- Auto-Sync Info & Live Action Box -->
                <div class="api-sync-box">
                    <div class="sync-status-col">
                        <div id="syncResultStatus" class="sync-status-msg">
                            @if(!empty($settings['products_api_last_synced_at']))
                                <span style="color:#10b981;font-weight:600;"><i class="fas fa-check-circle me-1"></i> التحديث التلقائي نشط: آخر مزامنة تمت في {{ $settings['products_api_last_synced_at'] }} (يتم التحديث تلقائياً دورياً وعند حفظ الإعدادات).</span>
                            @elseif(!empty($settings['products_api_url']))
                                <span style="color:#3b82f6;font-weight:600;"><i class="fas fa-bolt me-1"></i> التحديث التلقائي مفعّل: يتم تحديث ومزامنة المنتجات فوراً عند الحفظ وبشكل دوري تلقائياً.</span>
                            @else
                                <span class="text-muted"><i class="fas fa-info-circle me-1"></i> بمجرد إدخال الرابط، سيتم تحديث المنتجات تلقائياً ومزامنتها دورياً دائماً.</span>
                            @endif
                        </div>
                    </div>
                    <div class="sync-action-col">
                        <button type="button" id="btnSyncApiNow" class="btn btn-secondary sync-btn">
                            <i class="fas fa-sync-alt" id="syncIcon"></i> 
                            <span id="syncBtnText">مزامنة وجلب المنتجات الآن</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- Sticky Save Bar -->
        <div class="settings-footer-bar">
            <div class="footer-info">
                <i class="fas fa-check-double text-muted"></i>
                <span>تأكد من مراجعة التغييرات ثم اضغط حفظ لتطبيقها على المتجر مباشرة</span>
            </div>
            <div class="footer-actions">
                <button type="submit" class="btn btn-primary save-btn">
                    <i class="fas fa-save"></i>
                    <span>حفظ جميع الإعدادات</span>
                </button>
            </div>
        </div>

    </form>
</div>
@endsection

@push('styles')
<style>
/* ── Settings Container ── */
.settings-container {
    max-width: 1100px;
    margin: 0 auto;
}

.mb-4 {
    margin-bottom: 1.5rem !important;
}

/* ── Hero Banner ── */
.settings-hero-card {
    background: linear-gradient(135deg, #051836 0%, #0a2e5c 100%);
    border-radius: var(--r-xl, 20px);
    padding: 1.75rem 2rem;
    color: #fff;
    margin-bottom: 1.75rem;
    box-shadow: 0 10px 25px rgba(5, 24, 54, 0.15);
}

.hero-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.hero-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.12);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: #fff;
    flex-shrink: 0;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.hero-content h2 {
    font-size: 1.35rem;
    font-weight: 800;
    margin: 0 0 0.35rem 0;
    color: #fff;
}

.hero-content p {
    font-size: 0.925rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    line-height: 1.5;
}

/* ── Tabs ── */
.settings-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    background: #fff;
    border: 1px solid var(--ink-200, #E2E8F0);
    border-radius: var(--r-lg, 16px);
    padding: 0.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
}

.settings-tab {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
    background: transparent;
    color: var(--ink-500, #64748B);
    font-size: 0.9375rem;
    font-weight: 700;
    padding: 0.7rem 1.25rem;
    border-radius: var(--r-md, 12px);
    cursor: pointer;
    transition: all 0.25s ease;
    white-space: nowrap;
}

.settings-tab i {
    font-size: 1rem;
}

.settings-tab:hover {
    background: #f1f5f9;
    color: #051836;
}

.settings-tab.active {
    background: linear-gradient(135deg, #051836 0%, #0a2e5c 100%);
    color: #fff;
    box-shadow: 0 4px 14px rgba(5, 24, 54, 0.25);
}

.tab-panel {
    display: none;
    animation: tabFadeIn 0.3s ease;
}

.tab-panel.active {
    display: block;
}

@keyframes tabFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ── Card Header Refinements ── */
.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.header-hint {
    font-size: 0.8125rem;
    color: var(--ink-500, #64748B);
    font-weight: 500;
}

.header-toggle {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.header-toggle .toggle-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--ink-700, #334155);
}

/* ── Toggles Grid ── */
.toggles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1rem;
}

.toggle-card {
    background: #fff;
    border: 1.5px solid var(--ink-200, #E2E8F0);
    border-radius: var(--r-lg, 16px);
    padding: 1.125rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.25s ease;
}

.toggle-card:hover {
    border-color: #051836;
    box-shadow: var(--sh, 0 2px 8px rgba(0,0,0,0.08));
    transform: translateY(-2px);
}

.toggle-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.toggle-icon.bg-blue { background: #e8edf5; color: #051836; }
.toggle-icon.bg-purple { background: #EDE9FE; color: #7C3AED; }
.toggle-icon.bg-green { background: #D1FAE5; color: #059669; }
.toggle-icon.bg-orange { background: #FEF3C7; color: #D97706; }
.toggle-icon.bg-teal { background: #CCFBF1; color: #0D9488; }

.toggle-info {
    flex: 1;
    min-width: 0;
}

.toggle-title {
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--ink-900, #0F172A);
    margin-bottom: 0.2rem;
}

.toggle-desc {
    font-size: 0.8125rem;
    color: var(--ink-500, #64748B);
    line-height: 1.35;
}

.toggle-action {
    flex-shrink: 0;
}

/* ── Modern Custom Switch ── */
.switch-toggle {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 26px;
    cursor: pointer;
    margin: 0;
}

.switch-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
}

.switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #CBD5E1;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 34px;
}

.switch-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.switch-toggle input:checked + .switch-slider {
    background-color: #10B981;
}

.switch-toggle input:checked + .switch-slider:before {
    transform: translateX(22px);
}

/* ── Deal of the Day Section ── */
.deal-config-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-hint {
    display: block;
    font-size: 0.8125rem;
    color: var(--ink-400, #94A3B8);
    margin-top: 0.375rem;
}

/* ── API Section ── */
.api-card-header {
    background: #F8FAFC;
}

.api-header-subtitle {
    font-size: 0.875rem;
    color: var(--ink-500, #64748B);
    margin: 0.25rem 0 0 0;
}

.api-inputs-grid {
    display: flex;
    gap: 1.25rem;
}

.api-inputs-grid .flex-2 { flex: 2; }
.api-inputs-grid .flex-1 { flex: 1; }

.input-with-icon {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    right: 1rem;
    color: var(--ink-400, #94A3B8);
    pointer-events: none;
    font-size: 0.95rem;
}

.input-with-icon .form-control {
    padding-right: 2.75rem;
}

/* In LTR mode adjust icon position */
[dir="ltr"] .input-icon {
    right: auto;
    left: 1rem;
}
[dir="ltr"] .input-with-icon .form-control {
    padding-right: 1.125rem;
    padding-left: 2.75rem;
}

/* ── API Sync Box ── */
.api-sync-box {
    margin-top: 1.25rem;
    padding: 1.125rem 1.25rem;
    background: #F8FAFC;
    border: 1px dashed var(--ink-200, #CBD5E1);
    border-radius: var(--r-md, 12px);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.sync-status-msg {
    font-size: 0.875rem;
    font-weight: 500;
}

.sync-btn {
    background: #fff;
    border: 1.5px solid var(--ink-200, #E2E8F0);
    color: var(--primary, #051836);
    padding: 0.65rem 1.25rem;
    font-weight: 700;
    transition: all 0.25s ease;
}

.sync-btn:hover {
    background: #e8edf5;
    border-color: #051836;
    color: #051836;
    transform: translateY(-1px);
}

/* ── Sticky Save Footer Bar ── */
.settings-footer-bar {
    background: #fff;
    border: 1px solid var(--ink-200, #E2E8F0);
    border-radius: var(--r-lg, 16px);
    padding: 1.125rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    margin-top: 2rem;
    margin-bottom: 2rem;
}

.footer-info {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-size: 0.875rem;
    color: var(--ink-500, #64748B);
    font-weight: 500;
}

.save-btn {
    padding: 0.8rem 2rem;
    font-size: 1rem;
    font-weight: 700;
    border-radius: var(--r-md, 12px);
    box-shadow: 0 4px 15px rgba(5, 24, 54, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
}

.save-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(5, 24, 54, 0.35);
}

/* ── Slider Editor ── */
.slider-slides-grid {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.slide-editor-card {
    border: 1.5px solid var(--ink-200, #E2E8F0);
    border-radius: var(--r-lg, 16px);
    padding: 1.125rem 1.25rem;
    background: #fff;
    transition: border-color .25s ease;
}

.slide-editor-card:hover {
    border-color: #0D9488;
}

.slide-editor-head {
    display: flex;
    align-items: center;
    gap: .625rem;
    margin-bottom: 1rem;
}

.slide-badge {
    font-weight: 800;
    font-size: .95rem;
    color: var(--ink-900, #0F172A);
}

.slide-status {
    font-size: .75rem;
    font-weight: 700;
    padding: .2rem .6rem;
    border-radius: 999px;
}

.slide-status.custom { background: #CCFBF1; color: #0D9488; }
.slide-status.default { background: #F1F5F9; color: #64748B; }
.slide-status.new { background: #FEF3C7; color: #D97706; }

.btn-slide-delete {
    margin-inline-start: auto;
    border: 1px solid #FCA5A5;
    background: #FEF2F2;
    color: #DC2626;
    font-size: .8rem;
    font-weight: 700;
    padding: .3rem .7rem;
    border-radius: 10px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    transition: all .2s ease;
}

.btn-slide-delete:hover {
    background: #DC2626;
    color: #fff;
    border-color: #DC2626;
}

.slide-preview-empty {
    background-image: none !important;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ink-400, #94A3B8);
}

.slide-preview-empty::before {
    content: '\f570';
    font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: 1.75rem;
}

.slider-add-bar {
    margin-top: 1.25rem;
    display: flex;
    justify-content: center;
}

.btn-add-slide {
    background: #fff;
    border: 1.5px dashed #0D9488;
    color: #0D9488;
    font-weight: 700;
    padding: .7rem 1.5rem;
    border-radius: var(--r-md, 12px);
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    cursor: pointer;
    transition: all .25s ease;
}

.btn-add-slide:hover {
    background: #0D9488;
    color: #fff;
    border-style: solid;
}

.slide-editors {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}

.slide-field-label {
    font-size: .85rem;
    font-weight: 700;
    color: var(--ink-700, #334155);
    margin-bottom: .5rem;
    display: block;
}

.slide-preview {
    width: 100%;
    height: 150px;
    border-radius: 12px;
    background-size: cover;
    background-position: center;
    background-color: #F1F5F9;
    border: 1px dashed var(--ink-300, #CBD5E1);
    margin-bottom: .625rem;
}

.slide-preview-mobile {
    height: 150px;
    max-width: 130px;
    margin-inline-start: auto;
    margin-inline-end: auto;
}

.slider-file-input {
    font-size: .82rem;
}

.slide-remove {
    display: flex;
    align-items: center;
    gap: .4rem;
    margin-top: .5rem;
    font-size: .8rem;
    color: #DC2626;
    cursor: pointer;
}

.slide-remove input {
    width: 15px;
    height: 15px;
    accent-color: #DC2626;
}

@media (max-width: 700px) {
    .slide-editors {
        grid-template-columns: 1fr;
    }
}

/* ── Responsive ── */
@media (max-width: 900px) {
    .settings-tab {
        flex: 1 1 auto;
        justify-content: center;
        padding: 0.6rem 0.75rem;
        font-size: 0.8125rem;
    }
    .settings-tab span {
        display: none;
    }
    .settings-tab i {
        font-size: 1.1rem;
    }
    .deal-config-grid {
        grid-template-columns: 1fr;
    }
    .api-inputs-grid {
        flex-direction: column;
    }
    .settings-hero-card {
        padding: 1.25rem 1.5rem;
    }
    .hero-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    .toggles-grid {
        grid-template-columns: 1fr;
    }
    .settings-footer-bar {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
        text-align: center;
    }
    .save-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Tabs switching ──
    const tabs = document.querySelectorAll('.settings-tab');
    const panels = document.querySelectorAll('.tab-panel');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            const target = tab.getAttribute('data-tab');
            tabs.forEach(t => t.classList.toggle('active', t === tab));
            panels.forEach(p => p.classList.toggle('active', p.id === target));
        });
    });

    // Auto-open slider tab when there are validation errors on slider images
    @if(!empty($sliderErrs))
        const sliderTab = document.querySelector('[data-tab="tab-slider"]');
        if (sliderTab) sliderTab.click();
    @endif

    // ── Slider: dynamic add / delete / renumber ──
    const sliderContainer = document.getElementById('sliderSlidesContainer');
    const sliderTemplate = document.getElementById('slideRowTemplate');
    const sliderCountInput = document.getElementById('sliderCount');
    const btnAddSlide = document.getElementById('btnAddSlide');
    const settingsForm = document.getElementById('settingsForm');

    function renumberSlides() {
        if (!sliderContainer) return;
        const cards = sliderContainer.querySelectorAll('.slide-editor-card');
        cards.forEach(function (card, idx) {
            card.querySelectorAll('[data-name]').forEach(function (el) {
                el.name = el.getAttribute('data-name').replace('__IDX__', idx);
            });
            const badge = card.querySelector('.slide-badge');
            if (badge) badge.textContent = 'الشريحة ' + (idx + 1);
        });
        if (sliderCountInput) sliderCountInput.value = cards.length;
    }

    if (btnAddSlide) {
        btnAddSlide.addEventListener('click', function () {
            const node = sliderTemplate.content.cloneNode(true);
            sliderContainer.appendChild(node);
            renumberSlides();
            const cards = sliderContainer.querySelectorAll('.slide-editor-card');
            if (cards.length) cards[cards.length - 1].scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }

    // Delete slide (event delegation)
    if (sliderContainer) {
        sliderContainer.addEventListener('click', function (e) {
            const delBtn = e.target.closest('.btn-slide-delete');
            if (!delBtn) return;
            const card = delBtn.closest('.slide-editor-card');
            if (!card) return;
            if (sliderContainer.querySelectorAll('.slide-editor-card').length <= 1) {
                if (!confirm('سيتم حذف آخر شريحة، وسيقوم المتجر بإظهار الشرائح الافتراضية. متأكد؟')) return;
            }
            card.remove();
            renumberSlides();
        });

        // Live preview for file inputs (event delegation)
        sliderContainer.addEventListener('change', function (e) {
            const input = e.target;
            if (!input.classList.contains('slider-file-input') || !input.files || !input.files[0]) return;
            const box = input.closest('.slide-field').querySelector('.slide-preview');
            if (!box) return;
            const reader = new FileReader();
            reader.onload = function (ev) {
                box.style.backgroundImage = "url('" + ev.target.result + "')";
                box.classList.remove('slide-preview-empty');
            };
            reader.readAsDataURL(input.files[0]);
        });
    }

    // Ensure names are correctly indexed right before submit
    if (settingsForm) settingsForm.addEventListener('submit', renumberSlides);

    renumberSlides();

    const btnSync = document.getElementById('btnSyncApiNow');
    const syncIcon = document.getElementById('syncIcon');
    const syncBtnText = document.getElementById('syncBtnText');
    const statusDiv = document.getElementById('syncResultStatus');
    const urlInput = document.getElementById('products_api_url');
    const tokenInput = document.getElementById('products_api_token');

    if (btnSync) {
        btnSync.addEventListener('click', function () {
            const apiUrl = urlInput.value.trim();
            if (!apiUrl) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تنبيه',
                        text: 'يرجى إدخال رابط الـ API أولاً.',
                        confirmButtonColor: '#051836'
                    });
                } else {
                    alert('يرجى إدخال رابط الـ API أولاً.');
                }
                urlInput.focus();
                return;
            }

            // UI loading state
            btnSync.disabled = true;
            syncIcon.classList.add('fa-spin');
            syncBtnText.innerText = 'جاري جلب المنتجات والمزامنة...';
            statusDiv.innerHTML = '<span style="color:var(--primary, #051836)"><i class="fas fa-spinner fa-spin me-1"></i> جاري الاتصال بالـ API وجلب المنتجات...</span>';

            fetch("{{ route('admin.settings.sync_api') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    products_api_url: apiUrl,
                    products_api_token: tokenInput.value.trim()
                })
            })
            .then(res => res.json())
            .then(data => {
                btnSync.disabled = false;
                syncIcon.classList.remove('fa-spin');
                syncBtnText.innerText = 'مزامنة وجلب المنتجات الآن';

                if (data.success) {
                    statusDiv.innerHTML = `<span style="color:#10B981;font-weight:600"><i class="fas fa-check-circle me-1"></i> ${data.message}</span>`;
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'تمت المزامنة بنجاح!',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    }
                } else {
                    statusDiv.innerHTML = `<span style="color:#EF4444;font-weight:600"><i class="fas fa-exclamation-triangle me-1"></i> ${data.message}</span>`;
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'فشلت المزامنة',
                            text: data.message,
                            confirmButtonColor: '#051836'
                        });
                    }
                }
            })
            .catch(err => {
                btnSync.disabled = false;
                syncIcon.classList.remove('fa-spin');
                syncBtnText.innerText = 'مزامنة وجلب المنتجات الآن';
                statusDiv.innerHTML = `<span style="color:#EF4444;font-weight:600"><i class="fas fa-times-circle me-1"></i> حدث خطأ أثناء الاتصال بالخادم.</span>`;
            });
        });
    }
});
</script>
@endpush

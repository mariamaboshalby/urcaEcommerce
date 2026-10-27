@php $isAr = app()->getLocale() === 'ar'; @endphp

{{-- Floating Social Buttons — collapsed into one toggle --}}
<div class="sfb-wrap" id="sfbWrap">

    {{-- Child buttons — absolutely stacked above toggle --}}
    <a href="https://wa.me/201067596149"
       target="_blank" rel="noopener noreferrer"
       class="sfb-btn sfb-whatsapp"
       aria-label="WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <span class="sfb-label">WhatsApp</span>
    </a>

    <a href="tel:+201067596149"
       class="sfb-btn sfb-phone"
       aria-label="{{ $isAr ? 'اتصل بنا' : 'Call us' }}">
        <i class="fas fa-phone-alt"></i>
        <span class="sfb-label">{{ $isAr ? 'اتصل' : 'Call' }}</span>
    </a>

    <a href="https://m.me/181WTrqgHu"
       target="_blank" rel="noopener noreferrer"
       class="sfb-btn sfb-messenger"
       aria-label="Messenger">
        <i class="fab fa-facebook-messenger"></i>
        <span class="sfb-label">Messenger</span>
    </a>

    {{-- Toggle button — anchors the whole widget --}}
    <button class="sfb-toggle" id="sfbToggle" aria-label="{{ $isAr ? 'تواصل معنا' : 'Contact us' }}" aria-expanded="false">
        <i class="fas fa-headset sfb-icon-open"></i>
        <i class="fas fa-times  sfb-icon-close"></i>
    </button>
</div>

<style>
/* ─── Wrapper: only as big as the toggle button ─── */
.sfb-wrap {
    position: fixed;
    bottom: 24px;
    {{ $isAr ? 'right' : 'right' }}: 20px;
    right: 20px;
    z-index: 9999;
    width: 56px;   /* exactly toggle size — no extra height */
    height: 56px;
}

/* ─── Toggle button ─── */
.sfb-toggle {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    background: linear-gradient(135deg, #051836 0%, #1e3a8a 100%);
    color: #fff;
    font-size: 1.375rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 20px rgba(0,0,0,.28);
    transition: transform .3s ease, box-shadow .3s ease, background .3s ease;
    z-index: 2;
}
.sfb-toggle:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 28px rgba(0,0,0,.38);
}

/* pulse ring */
.sfb-toggle::before {
    content: '';
    position: absolute;
    inset: -5px;
    border-radius: 50%;
    background: rgba(30,58,138,.35);
    animation: sfb-pulse 2s infinite;
    z-index: -1;
}
@keyframes sfb-pulse {
    0%,100% { transform: scale(.92); opacity:.6; }
    50%      { transform: scale(1.12); opacity:.2; }
}

/* icon swap */
.sfb-icon-close { display: none; }
.sfb-wrap.is-open .sfb-icon-open  { display: none; }
.sfb-wrap.is-open .sfb-icon-close { display: block; }
.sfb-wrap.is-open .sfb-toggle {
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
}

/* ─── Child buttons — absolutely positioned above toggle ─── */
.sfb-btn {
    position: absolute;
    bottom: 0;           /* start at same position as toggle */
    right: 2px;          /* slight inset for alignment */
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.375rem;
    text-decoration: none;
    box-shadow: 0 4px 16px rgba(0,0,0,.22);
    opacity: 0;
    transform: translateY(0) scale(.5);
    pointer-events: none;
    transition: opacity .22s ease, transform .22s ease, box-shadow .22s ease;
    z-index: 1;
}

/* stack upward: each button offset by 66px from toggle bottom */
.sfb-btn:nth-child(1) { --sfb-offset: 198px; }   /* top:    WhatsApp  */
.sfb-btn:nth-child(2) { --sfb-offset: 132px; }   /* middle: Phone     */
.sfb-btn:nth-child(3) { --sfb-offset: 66px;  }   /* bottom: Messenger */

.sfb-wrap.is-open .sfb-btn {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: auto;
    bottom: var(--sfb-offset);
}

/* stagger: bottom button appears first */
.sfb-wrap.is-open .sfb-btn:nth-child(3) { transition-delay: .00s; }
.sfb-wrap.is-open .sfb-btn:nth-child(2) { transition-delay: .06s; }
.sfb-wrap.is-open .sfb-btn:nth-child(1) { transition-delay: .12s; }

.sfb-btn:hover {
    transform: scale(1.12) !important;
    box-shadow: 0 6px 24px rgba(0,0,0,.32);
    color: #fff;
}

/* Colors */
.sfb-whatsapp  { background: linear-gradient(135deg,#25D366,#128C7E); }
.sfb-phone     { background: linear-gradient(135deg,#051836,#0a2e5c); }
.sfb-messenger { background: linear-gradient(135deg,#0084FF,#0066CC); }

/* ─── Tooltip label ─── */
.sfb-label {
    position: absolute;
    right: calc(100% + 10px);
    top: 50%;
    transform: translateY(-50%);
    background: #1e293b;
    color: #fff;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: .8rem;
    font-weight: 600;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity .2s ease;
}
.sfb-btn:hover .sfb-label { opacity: 1; }

/* ─── Mobile ─── */
@media (max-width: 768px) {
    .sfb-wrap { bottom: 80px; right: 14px; width: 50px; height: 50px; }
    .sfb-toggle { width: 50px; height: 50px; font-size: 1.2rem; }
    .sfb-btn    { width: 46px; height: 46px; font-size: 1.15rem; right: 2px; }
    .sfb-btn:nth-child(1) { --sfb-offset: 180px; }
    .sfb-btn:nth-child(2) { --sfb-offset: 120px; }
    .sfb-btn:nth-child(3) { --sfb-offset: 60px;  }
    .sfb-label { display: none; }
}
</style>

<script>
(function () {
    var wrap   = document.getElementById('sfbWrap');
    var toggle = document.getElementById('sfbToggle');
    if (!wrap || !toggle) return;

    toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = wrap.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', function (e) {
        if (!wrap.contains(e.target)) {
            wrap.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });
}());
</script>

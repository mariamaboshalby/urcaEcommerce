/**
 * urca E-Commerce - Main JavaScript
 * Handles all interactive features
 */

(function() {
    'use strict';

    // ========================================================================
    // DOM Elements
    // ========================================================================
    const elements = {
        navbar: document.getElementById('mainNavbar'),
        mobileMenuBtn: document.getElementById('mobileMenuBtn'),
        navbarMenu: document.getElementById('navbarMenu'),
        cartBtn: document.getElementById('cartBtn'),
        cartSidebar: document.getElementById('cartSidebar'),
        cartOverlay: document.getElementById('cartOverlay'),
        closeCart: document.getElementById('closeCart'),
        cartBadge: document.getElementById('cartBadge'),
        backToTop: document.getElementById('backToTop'),
        toastContainer: document.getElementById('toastContainer'),
    };

    // ========================================================================
    // Search toggle
    const searchToggle = document.getElementById('navSearchToggle');
    const searchWrap   = document.getElementById('navSearchWrap');
    if (searchToggle && searchWrap) {
        searchToggle.addEventListener('click', () => {
            searchWrap.classList.toggle('open');
            searchToggle.classList.toggle('active');
            if (searchWrap.classList.contains('open')) {
                searchWrap.querySelector('input')?.focus();
            }
        });
        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!searchToggle.contains(e.target) && !searchWrap.contains(e.target)) {
                searchWrap.classList.remove('open');
                searchToggle.classList.remove('active');
            }
        });
    }

    // Mobile Menu Toggle
    // ========================================================================
    if (elements.mobileMenuBtn && elements.navbarMenu) {
        elements.mobileMenuBtn.addEventListener('click', () => {
            elements.navbarMenu.classList.toggle('active');
            elements.mobileMenuBtn.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!elements.navbarMenu.contains(e.target) && 
                !elements.mobileMenuBtn.contains(e.target) &&
                elements.navbarMenu.classList.contains('active')) {
                elements.navbarMenu.classList.remove('active');
                elements.mobileMenuBtn.classList.remove('active');
            }
        });

        // Handle dropdown in mobile
        const dropdowns = document.querySelectorAll('.has-dropdown');
        dropdowns.forEach(dropdown => {
            const link = dropdown.querySelector('a');
            link.addEventListener('click', (e) => {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    dropdown.classList.toggle('active');
                }
            });
        });
    }

    // ========================================================================
    // Cart Sidebar
    // ========================================================================
    function openCart() {
        elements.cartSidebar.classList.add('active');
        elements.cartOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        loadCartItems();
    }

    function closeCart() {
        elements.cartSidebar.classList.remove('active');
        elements.cartOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (elements.cartBtn) {
        elements.cartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openCart();
        });
    }

    if (elements.closeCart) {
        elements.closeCart.addEventListener('click', closeCart);
    }

    if (elements.cartOverlay) {
        elements.cartOverlay.addEventListener('click', closeCart);
    }

    // ========================================================================
    // Load Cart Items — fetch real data from server
    // ========================================================================
    let cartState = { items: [], total: 0 };
    let quantityUpdateTimers = {};

    function fetchCartItems() {
        return fetch('/cart/items', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                cartState.items = data.items || [];
                cartState.total = data.total || 0;
                renderCartSidebar(cartState.items, cartState.total);
                updateCartBadge(data.cart_count ?? cartState.items.length);
            })
            .catch(() => {});
    }

    function renderCartSidebar(items, total) {
        const cartBody = document.getElementById('cartSidebarBody');
        if (!cartBody) return;

        if (!items || items.length === 0) {
            cartBody.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-shopping-bag mb-3 d-block" style="font-size:2.5rem;opacity:.3;"></i>
                    <p class="mb-0 fw-semibold">${document.documentElement.dir === 'rtl' ? 'سلة المشتريات فارغة' : 'Your cart is empty'}</p>
                </div>`;
            updateCartTotal(0);
            return;
        }

        let html = '';
        items.forEach(item => {
            const hasImg = item.image && item.image.trim().length > 0 && !item.image.includes('product-1');
            const imgHtml = hasImg
                ? `<img src="${item.image}" alt="${item.name}" style="width:52px;height:52px;object-fit:cover;border-radius:8px;" onerror="this.outerHTML='<div class=\\'flex-shrink-0 bg-light rounded-3 d-flex align-items-center justify-content-center\\' style=\\'width:52px;height:52px;font-size:1.25rem;color:#051836;\\'><i class=\\'fas fa-box\\'></i></div>'">`
                : `<div class="flex-shrink-0 bg-light rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px;font-size:1.25rem;color:#051836;"><i class="fas fa-box"></i></div>`;

            html += `
                <div class="d-flex align-items-center gap-3 py-3 border-bottom cart-item-row" id="cart-item-${item.id}" data-id="${item.id}">
                    ${imgHtml}
                    <div class="flex-grow-1 min-w-0">
                        <p class="fw-semibold mb-1 small text-dark" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${item.name}</p>
                        <p class="text-primary fw-bold mb-0 small" id="cart-item-price-${item.id}">${Number(item.price * item.quantity).toLocaleString()} EGP</p>
                    </div>
                    <div class="d-flex align-items-center flex-shrink-0" style="direction: ltr !important; user-select: none;">
                        <button type="button"
                                onclick="window.changeQuantity(${item.id}, -1)"
                                class="btn btn-sm btn-light border fw-bold d-flex align-items-center justify-content-center"
                                style="width:30px;height:30px;padding:0;border-radius:6px 0 0 6px;font-size:1rem;cursor:pointer;">−</button>
                        <input
                            type="number"
                            id="cart-qty-input-${item.id}"
                            value="${item.quantity}"
                            min="1" max="99"
                            onchange="window.updateQuantity(${item.id}, Math.max(1, parseInt(this.value)||1))"
                            onkeydown="if(event.key==='Enter')this.blur()"
                            class="border-top border-bottom text-center fw-bold bg-white"
                            style="width:38px;height:30px;font-size:.85rem;border-left:none;border-right:none;outline:none;-moz-appearance:textfield;">
                        <button type="button"
                                onclick="window.changeQuantity(${item.id}, 1)"
                                class="btn btn-sm btn-light border fw-bold d-flex align-items-center justify-content-center"
                                style="width:30px;height:30px;padding:0;border-radius:0 6px 6px 0;font-size:1rem;cursor:pointer;">+</button>
                    </div>
                    <button type="button" onclick="window.removeFromCart(${item.id})" class="btn btn-sm text-danger flex-shrink-0 p-1 ms-1" style="font-size:1rem;cursor:pointer;" title="حذف">
                        <i class="fas fa-times"></i>
                    </button>
                </div>`;
        });

        cartBody.innerHTML = html;
        updateCartTotal(total);
    }

    // Keep old name as alias so openCart() still works
    function loadCartItems() { fetchCartItems(); }

    function updateCartTotal(total) {
        const totalElement = document.getElementById('sidebarTotal');
        if (totalElement) {
            totalElement.textContent = `${Number(total).toLocaleString()} EGP`;
        }
    }

    // ========================================================================
    // Add to Cart
    // ========================================================================
    window.addToCart = function(productId, productName, productPrice, productImage) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        const params = new URLSearchParams({
            _token:        csrfToken,
            product_id:    productId,
            product_name:  productName,
            product_price: productPrice,
            product_image: productImage || '',
            quantity:      1,
        });

        fetch('/cart/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: params.toString(),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('success', document.documentElement.dir === 'rtl' ? 'تمت إضافة المنتج إلى السلة!' : 'Product added to cart!');
                updateCartBadge(data.cart_count);
                if (data.items) {
                    cartState.items = data.items;
                    cartState.total = data.total;
                    renderCartSidebar(data.items, data.total);
                }
                openCart();
            }
        })
        .catch(() => showToast('error', document.documentElement.dir === 'rtl' ? 'حدث خطأ. حاول مرة أخرى.' : 'Something went wrong. Please try again.'));
    };

    // ========================================================================
    // Quick Quantity Step (+1 / -1) with Optimistic UI & Debounced Sync
    // ========================================================================
    window.changeQuantity = function(productId, delta) {
        const item = cartState.items.find(i => Number(i.id) === Number(productId));
        if (!item) return;

        const newQty = item.quantity + delta;
        window.updateQuantity(productId, newQty);
    };

    // ========================================================================
    // Update Quantity with Local Calculation & Network Sync
    // ========================================================================
    window.updateQuantity = function(productId, newQuantity) {
        newQuantity = parseInt(newQuantity, 10);
        if (isNaN(newQuantity) || newQuantity < 1) {
            window.removeFromCart(productId);
            return;
        }

        const item = cartState.items.find(i => Number(i.id) === Number(productId));
        if (item) {
            // Optimistic update locally
            item.quantity = newQuantity;
            const inputEl = document.getElementById(`cart-qty-input-${productId}`);
            if (inputEl) inputEl.value = newQuantity;

            const priceEl = document.getElementById(`cart-item-price-${productId}`);
            if (priceEl) priceEl.textContent = `${Number(item.price * newQuantity).toLocaleString()} EGP`;

            // Recalculate and update total instantly
            cartState.total = cartState.items.reduce((sum, it) => sum + (it.price * it.quantity), 0);
            updateCartTotal(cartState.total);
        }

        // Debounce backend sync so rapid clicks don't lag
        if (quantityUpdateTimers[productId]) {
            clearTimeout(quantityUpdateTimers[productId]);
        }

        quantityUpdateTimers[productId] = setTimeout(() => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const params = new URLSearchParams({ _token: csrfToken, product_id: productId, quantity: newQuantity });

            fetch('/cart/update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: params.toString(),
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.items) {
                    cartState.items = data.items;
                    cartState.total = data.total;
                    updateCartTotal(data.total);
                    updateCartBadge(data.cart_count);
                }
            })
            .catch(() => {});
        }, 150);
    };

    // ========================================================================
    // Remove from Cart
    // ========================================================================
    window.removeFromCart = function(productId) {
        // Optimistic DOM removal
        const rowEl = document.getElementById(`cart-item-${productId}`);
        if (rowEl) {
            rowEl.style.opacity = '0.3';
            rowEl.style.pointerEvents = 'none';
        }

        cartState.items = cartState.items.filter(i => Number(i.id) !== Number(productId));
        cartState.total = cartState.items.reduce((sum, it) => sum + (it.price * it.quantity), 0);
        updateCartTotal(cartState.total);
        updateCartBadge(cartState.items.length);

        if (cartState.items.length === 0) {
            renderCartSidebar([], 0);
        } else if (rowEl) {
            rowEl.remove();
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const params = new URLSearchParams({ _token: csrfToken, product_id: productId });

        fetch('/cart/remove', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: params.toString(),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message || 'Item removed.');
                if (data.items) {
                    cartState.items = data.items;
                    cartState.total = data.total;
                    renderCartSidebar(data.items, data.total);
                }
                updateCartBadge(data.cart_count);
            }
        })
        .catch(() => showToast('error', 'Something went wrong.'));
    };

    // ========================================================================
    // Update Cart Badge (Desktop & Mobile)
    // ========================================================================
    function updateCartBadge(count) {
        const desktopBadge = document.getElementById('cartBadge');
        if (desktopBadge) {
            desktopBadge.textContent = count;
            desktopBadge.style.display = count > 0 ? 'flex' : 'none';
        }
        const mobileBadge = document.getElementById('cartBadgeMobile');
        if (mobileBadge) {
            mobileBadge.textContent = count;
            mobileBadge.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    // ========================================================================
    // Toast Notifications
    // ========================================================================
    function showToast(type, message) {
        if (!elements.toastContainer) return;

        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            info: 'fa-info-circle',
        };

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <i class="fas ${icons[type]}"></i>
            <span>${message}</span>
        `;

        elements.toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // ========================================================================
    // Back to Top Button
    // ========================================================================
    let scrollTicking = false;
    function handleScroll() {
        if (!scrollTicking) {
            window.requestAnimationFrame(() => {
                if (elements.backToTop) {
                    if (window.scrollY > 300) {
                        elements.backToTop.classList.add('visible');
                    } else {
                        elements.backToTop.classList.remove('visible');
                    }
                }
                scrollTicking = false;
            });
            scrollTicking = true;
        }
    }

    if (elements.backToTop) {
        elements.backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    window.addEventListener('scroll', handleScroll, { passive: true });

    // ========================================================================
    // Smooth Scroll for Anchor Links
    // ========================================================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === '') return;

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ========================================================================
    // Image Placeholder Handler
    // ========================================================================
    document.querySelectorAll('img[data-src]').forEach(img => {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
    });

    // ========================================================================
    // Form Validation
    // ========================================================================
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });

            if (!isValid) {
                e.preventDefault();
                showToast('error', 'الرجاء ملء جميع الحقول المطلوبة');
            }
        });
    });

    // ========================================================================
    // Initialize on Load
    // ========================================================================
    document.addEventListener('DOMContentLoaded', () => {
        console.log('urca E-Commerce initialized');
        handleScroll();
    });

})();

// ========================================================================
// Animations on Scroll
// ========================================================================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.animate-on-scroll').forEach(el => {
    observer.observe(el);
});


// ============================================================
// urca Premium Navbar — mobile menu wiring (new layout)
// ============================================================
(function () {
    const hamburger  = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', function () {
            mobileMenu.classList.toggle('open');
            hamburger.classList.toggle('active');
        });

        document.addEventListener('click', function (e) {
            if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.remove('open');
                hamburger.classList.remove('active');
            }
        });
    }
}());

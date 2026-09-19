/**
 * urca Landing Page Scripts
 * Utilizes jQuery for DOM manipulation and animations
 */

(function($) {
    'use strict';

    // Namespace to prevent collisions
    const urcaLanding = {
        init: function() {
            this.cacheDOM();
            this.bindEvents();
            this.checkScroll();
            this.initScrollReveal();
        },

        cacheDOM: function() {
            this.$window = $(window);
            this.$navbar = $('#urcaNavbar');
            this.$mobileToggle = $('#mobileToggle');
            this.$navLinks = $('#navLinks');
            this.$scrollLinks = $('a[href^="#"]');
            this.$revealElements = $('.reveal');
            this.$contactForm = $('#urcaContactForm');
        },

        bindEvents: function() {
            this.$window.on('scroll', this.handleScroll.bind(this));
            this.$mobileToggle.on('click', this.toggleMobileMenu.bind(this));
            this.$scrollLinks.on('click', this.smoothScroll.bind(this));
            this.$contactForm.on('submit', this.handleFormSubmit.bind(this));
        },

        handleScroll: function() {
            this.checkScroll();
            this.checkScrollReveal();
            this.updateActiveNavLink();
        },

        checkScroll: function() {
            if (this.$window.scrollTop() > 50) {
                this.$navbar.addClass('scrolled');
            } else {
                this.$navbar.removeClass('scrolled');
            }
        },

        toggleMobileMenu: function() {
            this.$navLinks.toggleClass('show');
            let $icon = this.$mobileToggle.find('i');
            if(this.$navLinks.hasClass('show')) {
                $icon.removeClass('fa-bars').addClass('fa-times');
            } else {
                $icon.removeClass('fa-times').addClass('fa-bars');
            }
        },

        smoothScroll: function(e) {
            let target = $(e.currentTarget).attr('href');
            if (target.length && target !== "#") {
                e.preventDefault();
                let $targetElement = $(target);
                if ($targetElement.length) {
                    $('html, body').animate({
                        scrollTop: $targetElement.offset().top - 70 // Adjust for navbar height
                    }, 800);
                    
                    // Close mobile menu if open
                    if (this.$navLinks.hasClass('show')) {
                        this.toggleMobileMenu();
                    }
                }
            }
        },

        updateActiveNavLink: function() {
            let scrollPos = this.$window.scrollTop();
            let $links = this.$navLinks.find('a');

            $links.each(function() {
                let currLink = $(this);
                let refElement = $(currLink.attr("href"));
                
                if (refElement.length) {
                    if (refElement.position().top - 100 <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                        $links.removeClass("active");
                        currLink.addClass("active");
                    }
                }
            });
        },

        initScrollReveal: function() {
            // Trigger once on load
            this.checkScrollReveal();
        },

        checkScrollReveal: function() {
            let windowHeight = this.$window.height();
            let scrollPos = this.$window.scrollTop();

            this.$revealElements.each(function() {
                let elementTop = $(this).offset().top;
                if (elementTop < scrollPos + windowHeight - 100) {
                    $(this).addClass('active');
                }
            });
        },

        handleFormSubmit: function(e) {
            e.preventDefault();
            let $form = $(e.currentTarget);
            let $btn = $form.find('button[type="submit"]');
            let originalText = $btn.text();

            // Simple validation
            let name = $form.find('input[name="name"]').val();
            let email = $form.find('input[name="email"]').val();
            let message = $form.find('textarea[name="message"]').val();

            if (!name || !email || !message) {
                alert('الرجاء ملء جميع الحقول المطلوبة');
                return;
            }

            // Simulate Ajax request (replace with actual endpoint later)
            $btn.text('جاري الإرسال...').prop('disabled', true);

            setTimeout(function() {
                alert('تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.');
                $form[0].reset();
                $btn.text(originalText).prop('disabled', false);
            }, 1500);
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        urcaLanding.init();
    });

})(jQuery);

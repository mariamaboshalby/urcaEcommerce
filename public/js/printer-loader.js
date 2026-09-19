/**
 * urca - 3D Printer Loading Animation
 * Shows a 3D printer animation on page load
 */

(function () {
    'use strict';

    // Minimum display time in ms
    const MIN_DISPLAY_TIME = 1200;

    const startTime = Date.now();

    function hideLoader() {
        const elapsed = Date.now() - startTime;
        const remaining = Math.max(0, MIN_DISPLAY_TIME - elapsed);

        setTimeout(function () {
            const overlay = document.getElementById('printerLoaderOverlay');
            if (overlay) {
                overlay.classList.add('hidden');
                // Remove from DOM after transition
                setTimeout(function () {
                    overlay.remove();
                }, 600);
            }
        }, remaining);
    }

    // Hide when page is fully loaded
    if (document.readyState === 'complete') {
        hideLoader();
    } else {
        window.addEventListener('load', hideLoader);
    }

    // Fallback: force hide after 3 seconds
    setTimeout(function () {
        const overlay = document.getElementById('printerLoaderOverlay');
        if (overlay && !overlay.classList.contains('hidden')) {
            overlay.classList.add('hidden');
            setTimeout(function () { overlay.remove(); }, 600);
        }
    }, 3000);

})();

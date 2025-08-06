// Mobile enhancement script for job applications page
// This adds mobile-specific functionality without modifying existing code

(function() {
    'use strict';

    // Check if we're on mobile
    function isMobile() {
        return window.innerWidth <= 768;
    }

    // Initialize mobile enhancements
    function initMobileEnhancements() {
        if (isMobile()) {
            enhanceTouchTargets();
            addMobileNavigation();
            optimizeForTouch();
        }
    }

    // Make touch targets larger on mobile
    function enhanceTouchTargets() {
        const buttons = document.querySelectorAll('.apply-btn, .btn');
        buttons.forEach(button => {
            button.style.minHeight = '44px';
            button.style.minWidth = '44px';
            button.style.padding = '12px 16px';
        });
    }

    // Add mobile-friendly navigation
    function addMobileNavigation() {
        // Add swipe gestures for pagination
        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swiped left - go to next page
                    const nextBtn = document.querySelector('a[href*="page="]:not([href*="page=1"])');
                    if (nextBtn) nextBtn.click();
                } else {
                    // Swiped right - go to previous page
                    const prevBtn = document.querySelector('a[href*="page="]:not([href*="page="]:last-child)');
                    if (prevBtn) prevBtn.click();
                }
            }
        }
    }

    // Optimize for touch interactions
    function optimizeForTouch() {
        // Add touch feedback
        const interactiveElements = document.querySelectorAll('.apply-btn, .btn, .media');
        interactiveElements.forEach(element => {
            element.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });
            
            element.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Prevent zoom on double tap
        let lastTouchEnd = 0;
        document.addEventListener('touchend', function(event) {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    }

    // Handle window resize
    function handleResize() {
        initMobileEnhancements();
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMobileEnhancements);
    } else {
        initMobileEnhancements();
    }

    // Handle window resize
    window.addEventListener('resize', handleResize);

})();

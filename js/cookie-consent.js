/**
 * Cookie Consent Banner Script
 *
 * [The Final Version - Take 6 Logic]
 *
 * Customizer Preview: Buttons will "flash" but NOT hide the banner.
 * Live Site: Buttons will set cookie and hide the banner.
 * Event Delegation: Uses .closest() for robust click handling.
 * Partial Refresh: Listens for partial refresh to re-show the banner.
 * Revoke Button: Allows users to bring back the banner.
 */
document.addEventListener('DOMContentLoaded', function () {

    const cookieName = 'slatan_cookie_consent';
    const isPreview = typeof wp !== 'undefined' && wp.customize && wp.customize.previewer;

    /**
     * Finds the current banner element in the DOM.
     * @returns {HTMLElement|null} The banner element
     */
    function getBanner() {
        return document.getElementById('cookie-consent-banner');
    }

    /**
     * Finds the revoke button element.
     * @returns {HTMLElement|null}
     */
    function getRevokeButton() {
        return document.getElementById('slatan-revoke-consent');
    }

    /**
     * Handles the click on either the accept or decline button.
     * @param {string} action - 'accept' or 'decline'
     */
    function handleConsent(action) {
        const banner = getBanner();
        if (!banner) return;

        // ==========================================================
        //  CUSTOMIZER PREVIEW LOGIC
        // ==========================================================
        if (isPreview) {
            // In Preview mode, DO NOT HIDE the banner.
            // Just "flash" it to give feedback.
            banner.style.transition = 'opacity 0.1s linear';
            banner.style.opacity = '0.7';

            setTimeout(() => {
                banner.style.opacity = '1';
                setTimeout(() => {
                    banner.style.transition = '';
                }, 100);
            }, 100);

            return; // We are done for preview mode.
        }
        // ==========================================================

        // --- [LIVE SITE LOGIC] ---
        const date = new Date();
        date.setFullYear(date.getFullYear() + 1);

        if (action === 'accept') {
            document.cookie = cookieName + '=accepted; path=/; expires=' + date.toUTCString() + '; SameSite=Lax';
            // Hide banner and show revoke button (no reload)
            banner.classList.remove('is-visible');
            showRevokeButton();
        } else {
            document.cookie = cookieName + '=declined; path=/; expires=' + date.toUTCString() + '; SameSite=Lax';
            banner.classList.remove('is-visible');
            showRevokeButton();
        }
    }

    /**
     * Checks if the user has already given consent.
     * @returns {boolean} True if the cookie exists
     */
    function hasConsentCookie() {
        return document.cookie.split(';').some((item) => {
            const cookie = item.trim();
            return cookie.startsWith(cookieName + '=accepted') ||
                cookie.startsWith(cookieName + '=declined');
        });
    }

    /**
     * Shows the revoke button.
     */
    function showRevokeButton() {
        const btn = getRevokeButton();
        if (btn) btn.classList.add('is-visible');
    }

    /**
     * Hides the revoke button.
     */
    function hideRevokeButton() {
        const btn = getRevokeButton();
        if (btn) btn.classList.remove('is-visible');
    }

    /**
     * This function initializes the banner logic (showing it).
     */
    function showBanner() {
        const banner = getBanner();
        if (!banner) return;

        if (isPreview) {
            // In Customizer, always clear cookie and show banner
            document.cookie = cookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';

            setTimeout(() => {
                const freshBanner = getBanner();
                if (freshBanner) {
                    freshBanner.classList.add('is-visible');
                }
            }, 100);
        } else {
            // On live site, show only if no cookie
            if (!hasConsentCookie()) {
                setTimeout(() => {
                    banner.classList.add('is-visible');
                }, 100);
            } else {
                // If cookie exists, show revoke button
                showRevokeButton();
            }
        }
    }

    // --- 1. Initial Load ---
    showBanner();

    // --- 2. Event Delegation (Using .closest()) ---
    document.body.addEventListener('click', function (event) {

        const acceptButton = event.target.closest('#cookie-consent-accept');
        if (acceptButton) {
            handleConsent('accept');
            return;
        }

        const declineButton = event.target.closest('#cookie-consent-decline');
        if (declineButton) {
            handleConsent('decline');
            return;
        }

        const revokeButton = event.target.closest('#slatan-revoke-consent');
        if (revokeButton) {
            // Clear cookie
            document.cookie = cookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            // Hide button
            hideRevokeButton();
            // Show banner
            const banner = getBanner();
            if (banner) banner.classList.add('is-visible');
            return;
        }
    });

    // --- 3. Customizer Partial Refresh Logic ---
    if (isPreview && wp.customize.previewer) {
        wp.customize.previewer.bind('partially-refreshed', function () {
            setTimeout(() => {
                showBanner();
            }, 100);
        });
    }
});
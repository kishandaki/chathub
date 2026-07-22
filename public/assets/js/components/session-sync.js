/**
 * Chat HUB - Session Sync across tabs
 * Handles same-browser multi-tab logout synchronization
 */

(function () {
    'use strict';

    const STORAGE_KEY = 'chathub_auth_logout_event';

    // Listen for storage events from other tabs
    window.addEventListener('storage', (e) => {
        if (e.key === STORAGE_KEY && e.newValue) {
            const timestamp = parseInt(e.newValue, 10);
            if (!isNaN(timestamp)) {
                handleLogoutFromOtherTab();
            }
        }
    });

    // Listen for our own logout event
    window.addEventListener('beforeunload', () => {
        if (document.querySelector('form[action="' + window.Laravel.logoutUrl + '"]')) {
            localStorage.setItem(STORAGE_KEY, Date.now());
        }
    });

    function handleLogoutFromOtherTab() {
        // Clear any stored auth state
        sessionStorage.clear();

        // Redirect to login with session expired message
        if (window.location.pathname !== '/login' && window.location.pathname !== '/session-expired') {
            window.location.href = '/session-expired';
        }
    }

    // Expose logout trigger for forms
    window.Laravel = window.Laravel || {};
    window.Laravel.logoutUrl = '/logout';
})();
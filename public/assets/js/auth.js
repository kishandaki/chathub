/**
 * Chat HUB - Authentication JavaScript
 * Common auth functionality across all auth pages
 */

(function () {
    'use strict';

    // Theme Toggle
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        const html = document.documentElement;
        themeToggle.addEventListener('click', () => {
            const isDark = html.getAttribute('data-theme') === 'dark';
            html.setAttribute('data-theme', isDark ? 'light' : 'dark');
            localStorage.setItem('chathub-theme', isDark ? 'light' : 'dark');
        });

        // Load saved theme
        const savedTheme = localStorage.getItem('chathub-theme');
        if (savedTheme) {
            html.setAttribute('data-theme', savedTheme);
        }
    }

    // Password Toggle
    document.querySelectorAll('.password-toggle').forEach((button) => {
        button.addEventListener('click', () => {
            const input = button.parentElement.querySelector('input');
            const eyeOpen = button.querySelector('.eye-open');
            const eyeClosed = button.querySelector('.eye-closed');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach((alert) => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Form submission loader
    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', (e) => {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.dataset.originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="loader-spinner" style="width:20px;height:20px;border-width:2px;"></span> Processing...';
            }
        });
    });

})();
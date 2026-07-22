/**
 * Chat HUB - Workspace JavaScript
 * Static UI interactions for the Chat HUB shell (conversation list, chat window, composer).
 */

(function () {
    'use strict';

    const THEME_STORAGE_KEY = 'chathub-theme';

    const html = document.documentElement;
    const themeToggle = document.getElementById('chathubThemeToggle');
    const threads = Array.from(document.querySelectorAll('.chathub-thread'));
    const tabs = Array.from(document.querySelectorAll('.chathub-tab'));
    const searchInput = document.getElementById('chathubSearchInput');
    const activeName = document.getElementById('chathubActiveName');
    const activeRole = document.getElementById('chathubActiveRole');
    const activeAvatar = document.getElementById('chathubActiveAvatar');
    const messages = document.getElementById('chathubMessages');
    const messageInput = document.getElementById('chathubMessageInput');
    const sendBtn = document.getElementById('chathubSendBtn');
    const toast = document.getElementById('chathubToast');
    const toastText = document.getElementById('chathubToastText');
    const modal = document.getElementById('chathubModal');
    const openModal = document.getElementById('chathubOpenModal');
    const closeModal = document.getElementById('chathubCloseModal');
    const currentUserInitials = document.body.dataset.userInitials || 'ME';

    const savedTheme = localStorage.getItem(THEME_STORAGE_KEY);
    if (savedTheme) {
        html.setAttribute('data-theme', savedTheme);
    }

    function showToast(text) {
        if (!toast || !toastText) return;
        toastText.textContent = text;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2200);
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem(THEME_STORAGE_KEY, next);
            showToast(next === 'dark' ? 'Dark theme enabled' : 'Light theme enabled');
        });
    }

    threads.forEach((thread) => {
        thread.addEventListener('click', () => {
            threads.forEach((t) => t.classList.remove('active'));
            thread.classList.add('active');

            if (activeName) activeName.textContent = thread.dataset.name;
            if (activeRole) activeRole.innerHTML = '<span class="chathub-live-dot"></span> ' + thread.dataset.role;
            if (activeAvatar) {
                activeAvatar.className = 'chathub-avatar ' + (thread.dataset.color || '');
                activeAvatar.innerHTML = thread.dataset.avatar + '<span class="chathub-presence"></span>';
            }

            if (messages) {
                messages.style.opacity = '0';
                messages.style.transform = 'translateY(8px)';
                setTimeout(() => {
                    messages.style.opacity = '1';
                    messages.style.transform = 'translateY(0)';
                }, 120);
            }
        });
    });

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            tabs.forEach((t) => t.classList.remove('active'));
            tab.classList.add('active');
            const filter = tab.dataset.filter;
            threads.forEach((thread) => {
                const tags = thread.dataset.tags || '';
                thread.style.display = filter === 'all' || tags.includes(filter) ? 'grid' : 'none';
            });
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const value = searchInput.value.toLowerCase().trim();
            threads.forEach((thread) => {
                thread.style.display = thread.innerText.toLowerCase().includes(value) ? 'grid' : 'none';
            });
        });
    }

    function sendMessage() {
        if (!messageInput || !messages) return;
        const value = messageInput.value.trim();
        if (!value) return;

        const node = document.createElement('article');
        node.className = 'chathub-message mine';
        node.innerHTML = '<span class="chathub-small-avatar"></span><div class="chathub-bubble"><span class="chathub-sender">You</span><p></p><div class="chathub-meta"><span>Now</span><span>Sent ✓</span></div></div>';
        node.querySelector('.chathub-small-avatar').textContent = currentUserInitials;
        node.querySelector('p').textContent = value;
        messages.appendChild(node);
        messageInput.value = '';
        messages.scrollTop = messages.scrollHeight;
        showToast('Message sent securely');
    }

    if (sendBtn) sendBtn.addEventListener('click', sendMessage);
    if (messageInput) {
        messageInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') sendMessage();
        });
    }

    if (openModal && modal) openModal.addEventListener('click', () => modal.classList.add('open'));
    if (closeModal && modal) closeModal.addEventListener('click', () => modal.classList.remove('open'));
    if (modal) {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) modal.classList.remove('open');
        });
    }
})();

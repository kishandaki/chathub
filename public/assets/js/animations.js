/* Chat HUB — Scroll-triggered entrance animations */
(function () {
  'use strict';

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  var selector = '.fade-up, .stagger > *';

  var observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.style.animationPlayState = 'running';
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.08,
      rootMargin: '0px 0px -40px 0px',
    }
  );

  document.querySelectorAll(selector).forEach(function (el) {
    el.style.animationPlayState = 'paused';
    observer.observe(el);
  });
})();
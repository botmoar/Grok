(function () {
  'use strict';

  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('site-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  document.querySelectorAll('.site-nav__drop-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      btn.parentElement.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', btn.parentElement.classList.contains('is-open') ? 'true' : 'false');
    });
  });

  document.querySelectorAll('[data-flip]').forEach(function (card) {
    card.addEventListener('click', function () {
      card.classList.toggle('is-flipped');
    });
    card.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        card.classList.toggle('is-flipped');
      }
    });
    card.setAttribute('tabindex', '0');
  });

  document.querySelectorAll('[data-slider]').forEach(function (root) {
    var slides = Array.prototype.slice.call(root.querySelectorAll('.slider__slide'));
    if (!slides.length) return;
    var i = 0;
    var dotsWrap = root.querySelector('.slider__dots');
    var dots = [];

    function go(n) {
      i = (n + slides.length) % slides.length;
      slides.forEach(function (s, idx) {
        s.classList.toggle('is-active', idx === i);
      });
      dots.forEach(function (d, idx) {
        d.classList.toggle('is-active', idx === i);
      });
    }

    if (dotsWrap) {
      slides.forEach(function (_, idx) {
        var b = document.createElement('button');
        b.type = 'button';
        b.setAttribute('aria-label', 'שקופית ' + (idx + 1));
        if (idx === 0) b.className = 'is-active';
        b.addEventListener('click', function () { go(idx); });
        dotsWrap.appendChild(b);
        dots.push(b);
      });
    }

    var prev = root.querySelector('.slider__prev');
    var next = root.querySelector('.slider__next');
    if (prev) prev.addEventListener('click', function () { go(i - 1); });
    if (next) next.addEventListener('click', function () { go(i + 1); });

    if (slides.length > 1) {
      setInterval(function () { go(i + 1); }, 4500);
    }
  });
})();

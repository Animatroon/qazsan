import { initHeader } from './modules/header.js';
import { initMenu } from './modules/menu.js';

const ready = () =>
  document.readyState === 'loading'
    ? new Promise((resolve) => document.addEventListener('DOMContentLoaded', resolve, { once: true }))
    : Promise.resolve();

function initReviewsCarousel() {
  const track = document.getElementById('reviewsTrack');
  const prev = document.getElementById('reviewsPrev');
  const next = document.getElementById('reviewsNext');
  const dotsWrap = document.getElementById('reviewsDots');
  if (!track) return;

  const cards = track.querySelectorAll('.review-card');
  const total = cards.length;
  let current = 0;
  let perView = 3;

  const getPerView = () => {
    if (window.innerWidth < 640) return 1;
    if (window.innerWidth < 1024) return 2;
    return 3;
  };

  const maxIndex = () => Math.max(0, total - perView);

  const go = (idx) => {
    perView = getPerView();
    current = Math.max(0, Math.min(idx, maxIndex()));
    const cardWidth = cards[0].offsetWidth + 20;
    track.style.transform = `translateX(-${current * cardWidth}px)`;
    prev && (prev.disabled = current === 0);
    next && (next.disabled = current >= maxIndex());
    dotsWrap?.querySelectorAll('.reviews-dot').forEach((d, i) =>
      d.classList.toggle('is-active', Math.floor(current / (perView || 1)) === i));
  };

  prev?.addEventListener('click', () => go(current - 1));
  next?.addEventListener('click', () => go(current + 1));
  dotsWrap?.addEventListener('click', (e) => {
    const dot = e.target.closest('.reviews-dot');
    if (dot) go(parseInt(dot.dataset.index) * perView);
  });

  let startX = 0;
  track.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; }, { passive: true });
  track.addEventListener('touchend', (e) => {
    const diff = startX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) go(diff > 0 ? current + 1 : current - 1);
  });

  window.addEventListener('resize', () => go(current), { passive: true });
  go(0);
}

(async () => {
  await ready();
  initHeader();
  initMenu();
  initReviewsCarousel();
})();

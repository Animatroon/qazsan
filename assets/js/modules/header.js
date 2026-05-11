export function initHeader() {
  const header = document.querySelector('[data-header]');
  if (!header) return;

  const hasHero = !!document.querySelector('[data-hero]');
  const SCROLL_THRESHOLD = 24;

  const update = () => {
    const scrolled = !hasHero || window.scrollY > SCROLL_THRESHOLD;
    header.classList.toggle('is-scrolled', scrolled);
  };

  update();
  window.addEventListener('scroll', update, { passive: true });
}

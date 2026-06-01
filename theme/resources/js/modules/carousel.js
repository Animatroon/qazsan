export function initCarousel(root) {
  if (!root) return null;

  const track = root.querySelector('[data-carousel-track]');
  const prev = root.querySelector('[data-carousel-prev]');
  const next = root.querySelector('[data-carousel-next]');
  if (!track) return null;

  const scrollByStep = (direction) => {
    const step = track.clientWidth * 0.8;
    track.scrollBy({ left: direction * step, behavior: 'smooth' });
  };

  prev?.addEventListener('click', () => scrollByStep(-1));
  next?.addEventListener('click', () => scrollByStep(1));

  return { scrollByStep };
}

export function initMenu() {
  const trigger = document.querySelector('[data-menu-trigger]');
  const drawer = document.querySelector('[data-menu-drawer]');
  if (!trigger || !drawer) return;

  const toggle = (force) => {
    const isOpen = typeof force === 'boolean' ? force : !drawer.classList.contains('is-open');
    drawer.classList.toggle('is-open', isOpen);
    trigger.setAttribute('aria-expanded', String(isOpen));
    document.body.style.overflow = isOpen ? 'hidden' : '';
  };

  trigger.addEventListener('click', () => toggle());

  drawer.addEventListener('click', (event) => {
    if (event.target.closest('[data-menu-close]')) toggle(false);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') toggle(false);
  });
}

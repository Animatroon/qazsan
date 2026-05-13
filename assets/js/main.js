import '../css/app.css';
import { initHeader } from './modules/header.js';
import { initMenu } from './modules/menu.js';

const ready = () =>
  document.readyState === 'loading'
    ? new Promise((resolve) => document.addEventListener('DOMContentLoaded', resolve, { once: true }))
    : Promise.resolve();

async function loadPartials() {
  const nodes = Array.from(document.querySelectorAll('[data-include]'));
  await Promise.all(
    nodes.map(async (node) => {
      const name = node.getAttribute('data-include');
      try {
        const res = await fetch(`${import.meta.env.BASE_URL}components/${name}.html`);
        if (!res.ok) throw new Error(`Failed to load ${name}: ${res.status}`);
        const html = await res.text();
        const tpl = document.createElement('template');
        tpl.innerHTML = html.trim();
        node.replaceWith(tpl.content);
      } catch (error) {
        console.error(error);
      }
    })
  );
}

(async () => {
  await ready();
  await loadPartials();
  initHeader();
  initMenu();
})();

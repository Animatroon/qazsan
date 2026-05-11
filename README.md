# QAZAQSTAN Resort — Дизайн-верстка (Фаза 1)

Статичный прототип сайта АО «Санаторий Казахстан» для согласования с заказчиком. После одобрения макета — посадка на WordPress (Sage 11).

## Стек

- HTML5 + Tailwind CSS 3.4
- Vite (dev-сервер с HMR, multi-page билд)
- Vanilla JS (модульная структура)
- Google Fonts: Manrope, PT Sans, Caveat

## Запуск

```bash
npm install
npm run dev
```

Откроется `http://localhost:5173`.

## Скрипты

- `npm run dev` — dev-сервер с HMR
- `npm run build` — продакшен-сборка в `dist/`
- `npm run preview` — превью продакшен-билда

## Страницы

- `/` — главная
- `/about.html` — о санатории
- `/treatment.html` — лечение
- `/accommodation.html` — проживание
- `/contacts.html` — контакты
- `/style-guide.html` — превью дизайн-системы

## Структура

```
.
├── index.html              главная
├── about.html              о санатории
├── treatment.html          лечение
├── accommodation.html      проживание
├── contacts.html           контакты
├── style-guide.html        превью компонентов
├── components/             переиспользуемые HTML-фрагменты (header, footer)
├── assets/
│   ├── css/                app.css (entry) + custom.css (компоненты)
│   ├── js/                 main.js + modules/
│   ├── images/             фото (плейсхолдеры Unsplash)
│   ├── icons/              кастомные SVG
│   └── fonts/              локальные шрифты (опционально)
├── tailwind.config.js      бренд-токены
├── vite.config.js          multi-page entries
└── docs/                   ТЗ, гайдлайны
```

## Бренд-токены (Tailwind)

Цвета: `klein-blue`, `may-green`, `bright-cerulean`, `light-green`, `mustard`, `off-white`, `warm-grey`, `charcoal`, `soft-grey`, `footer-navy`.

Шрифты: `font-display` (Manrope), `font-body` (PT Sans), `font-accent` (Caveat).

Тени: `shadow-card`, `shadow-card-hover`, `shadow-modal`.

Градиенты-фоны: `bg-gradient-water`, `bg-gradient-nature`.

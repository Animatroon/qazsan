# CLAUDE.md — QAZAQSTAN Resort

Единственный источник правды. Если что-то противоречит — спрашивай, не додумывай.

## Проект

- Заказчик: АО «Санаторий Казахстан», бренд QAZAQSTAN Resort
- Сайт: kazakhstansan.kz, WordPress, многостраничный корпоративный
- Языки: RU (default), KK обязательно, EN опционально (фаза 2)
- Срок: 18 рабочих дней (10 разработка + 5 тест + 3 запуск)
- Аудитория: физлица (лечение), корпоративные клиенты (конф-залы), посетители спорткомплекса, пенсионеры и МВД РК (скидки)

## Стек

- WordPress 6.x, PHP 8.2+, MySQL/MariaDB
- Тема: кастомная на **Sage 11** (Roots) — Blade, Vite, Tailwind. Не underscores, не дефолт.
- Хостинг: казахстанский (PS.KZ / Hoster.kz)
- Браузеры: Chrome, Firefox, Safari, Edge, Yandex (последние 2 версии)
- PageSpeed: ≥80 mobile, ≥90 desktop
- Адаптивность mobile-first, breakpoints: 360 / 768 / 1024 / 1280 / 1536

### Плагины (обязательно)

ACF Pro · Polylang (или WPML) · Yoast SEO (или Rank Math) · WP Rocket · Wordfence · Contact Form 7 (или Gravity Forms)

### Запрещено

ThemeForest темы · Elementor/WPBakery/Divi · jQuery-плагины (только Alpine.js или vanilla) · inline-стили · вывод HTML без экранирования

## Стандарты кода

**Главное правило: никаких комментариев в коде.** Самодокументируемые имена. Исключение — PHPDoc над публичными функциями.

### PHP

- PSR-12 + WordPress Coding Standards
- Типизация: `function get_room(int $id): ?Room`
- Никаких `extract()`, `eval()`, query без `prepare()`
- Все строки через `__('...', 'qazaqstan')`
- Префикс функций: `qazaqstan_*`

### JS

- ES2022+, vanilla или Alpine.js
- Сборка через Vite
- Не тащить тяжёлые npm-пакеты ради одной фичи

### CSS

- Tailwind utility-first
- Кастом только когда Tailwind не покрывает
- CSS-переменные для бренд-токенов
- БЭМ для редких кастомов: `.card`, `.card__title`, `.card--featured`

### Именование

CSS: kebab-case · JS: camelCase · PHP функции: `qazaqstan_*` · ACF поля: snake_case · Константы: UPPER_SNAKE_CASE

### Безопасность

- `$_POST`/`$_GET` через `sanitize_*`
- Вывод через `esc_html`/`esc_attr`/`esc_url`
- Nonce на всех формах
- `current_user_can()` для capability checks
- SQL через `$wpdb->prepare()`

## Дизайн-токены

```css
:root {
  --klein-blue: #3872B8;        /* primary, кнопки, ссылки, лого */
  --may-green: #5E9340;         /* secondary, "Resort", nature */
  --bright-cerulean: #2EAAE1;   /* water/medical accent */
  --light-green: #8DB25F;       /* nature/wellness accent */
  --mustard: #FFDE59;           /* ТОЛЬКО для бейджей скидок */
  --off-white: #F8F9F6;         /* фон страницы (не чистый белый) */
  --warm-grey: #E5E7E2;         /* бордеры, разделители */
  --charcoal: #2A2D2B;          /* текст (не чёрный #000) */
  --soft-grey: #6B6E6A;         /* вторичный текст */
  --footer-navy: #1F3A52;       /* фон футера */
}
```

Градиенты:

- water/medical: `linear-gradient(135deg, #3872B8, #2EAAE1)`
- nature/wellness: `linear-gradient(135deg, #5E9340, #8DB25F)`

Off-brand цвета запрещены.

### Шрифты

- Заголовки H1–H3: **Manrope** (800/700). Intro как опциональный апгрейд при наличии лицензии.
- Текст и UI: **PT Sans** (400/700/italic) — Google Fonts, поддерживает RU+KK
- Декор: **Caveat** — только для слогана и 1-2 акцентов на страницу

### Размеры (desktop / mobile)

- H1: 80/40 px, line-height 1.1, weight 800
- H2: 48/32 px, line-height 1.2, weight 700
- H3: 32/24 px, line-height 1.3, weight 700
- Body L: 20/18 px, line-height 1.6
- Body M: 17/16 px, line-height 1.65
- Eyebrow: 14px, uppercase, letter-spacing 0.1em, weight 700

### Spacing scale

4 / 8 / 12 / 16 / 24 / 32 / 48 / 64 / 96 / 120 px

### Радиусы

sm 4 (inputs) · md 8 (buttons) · lg 16 (cards) · xl 24 (hero) · full 9999

### Тени (окрашены в klein-blue с прозрачностью)

- card: `0 4px 24px rgba(56,114,184,0.06)`
- card-hover: `0 8px 32px rgba(56,114,184,0.12)`
- modal: `0 16px 48px rgba(0,0,0,0.16)`

### Z-index

base 0 · dropdown 10 · sticky 20 · header 30 · backdrop 40 · modal 50 · toast 60

## Архитектура темы (Sage 11)

```
themes/qazaqstan/
├── app/
│   ├── setup.php, filters.php
│   ├── Blocks/         ACF Gutenberg блоки (Hero, MedicalProfiles, PricingTiers...)
│   ├── PostTypes/      Room, Doctor, Procedure, Vacancy
│   └── Fields/         ACF группы в КОДЕ, не в админке
├── resources/
│   ├── views/          Blade (layouts, partials, blocks, single-*, archive-*, page-*)
│   ├── styles/         app.css (Tailwind entry) + components/
│   ├── scripts/        app.js + modules/
│   └── images/
└── public/             собранные ассеты (gitignore)
```

CPT: `room`, `doctor`, `procedure`, `vacancy`
Taxonomies: `medical_profile` (5 профилей), `room_type` (стандарт/люкс/президентский)

## Структура сайта

| URL | Шаблон |
|---|---|
| `/` | front-page (hero + 12 секций) |
| `/about/` `/treatment/` `/sport/` `/conferences/` `/services/` `/gallery/` `/contacts/` `/booking/` | page-* |
| `/accommodation/` + `/accommodation/{slug}/` | archive-room, single-room |
| `/blog/` + `/blog/{slug}/` | archive, single |
| `/procurement/` `/anti-corruption/` | page-* |
| `/vacancies/` + `/vacancies/{slug}/` | archive-vacancy, single-vacancy |
| `/kk/...` | Polylang |

ЧПУ: только латиница, kebab-case, без stop-слов.

## Производительность

LCP <2.5s · INP <200ms · CLS <0.1 · PageSpeed 80/90

Обязательно: lazy load всех изображений, `srcset` + WebP/AVIF, `font-display: swap` + preload, critical CSS inline, минификация (Vite + WP Rocket), Brotli/Gzip, HTTP/2, HTTPS. Hero видео: `<video>` с poster, `preload="metadata"`, не autoplay на mobile.

## SEO

ЧПУ · robots.txt + sitemap.xml · Schema.org (LocalBusiness, MedicalBusiness, LodgingBusiness, Hotel, Room, BreadcrumbList, FAQPage) · OG + Twitter Cards · hreflang RU/KK · canonical · один H1 · alt у всех картинок · breadcrumbs

Аналитика через GTM: GA4 + Яндекс.Метрика

## Контент

### Цены (2026)

| Номер | ₸/сутки |
|---|---|
| Стандарт 1м | 32 000 |
| Стандарт 2м | 56 000 |
| Люкс 1м | 45 000 |
| Люкс 2м | 70 000 |
| Президентский 1м | 80 000 |
| Президентский 2м | 140 000 |

### Скидки

- до 10% — пенсионеры по возрасту
- 20% — действующие сотрудники МВД РК и близкие родственники
- 30% — пенсионеры МВД РК и близкие родственники

### В путёвку входит

Проживание · 5-разовое питание · Первичная консультация (терапевт, невропатолог, дерматолог, кардиолог, уролог, гинеколог) · Бассейн с минеральной бальнеологической водой · Сауна · Озокеритовая аппликация · Массаж · Фитобар · Кислородный коктейль · Диетотерапия · ЛФК · Процедуры по назначению (УЗТ, СМТ, УВЧ, душ Шарко/Виши/циркулярный/восходящий, электромагнитотерапия, УФО, ингаляции, минеральные ванны)

### Формы

1. Бронирование (5 шагов): даты, номер, услуги, гости, оплата
2. Обратная связь: селектор темы (Президенту АО / Сотрудничество / Жалоба / Общий вопрос)
3. Заказать звонок: имя, телефон, время
4. Подписка (footer): email

Все формы: nonce + honeypot + reCAPTCHA v3 + серверная валидация + email + БД.

### Контакты

г. Алматы, пр. Достык, 308 · +7 (727) 264-64-54 · +7 707 691 5008 · @sanatorium_kazakhstan

## Workflow

### Перед задачей

Читай этот файл и связанные `/docs`. Дизайн — сверяйся с токенами выше. CPT/блок — сверяйся со структурой темы.

### При коде

Никаких комментариев. Blade, не PHP-в-шаблонах. Все строки через `__()`. Экранируй вывод. Цвета и шрифты — только через токены.

### Новый компонент

Props → Blade-партиал → ACF поля (если нужны) → стили (Tailwind utility-first) → JS (если интеракт)

### Спрашивай

- Реальные тексты и фото
- Решения по интеграциям (платёжка, бронирование)
- Конфликты между ТЗ и DESIGN.md

### НЕ спрашивай

- Технические решения (выбирай сам, документируй в commit)
- Имена переменных и структуру файлов

## Чеклист перед коммитом

- [ ] Нет комментариев
- [ ] PHP типизирован
- [ ] Строки через `__()`
- [ ] Вывод экранирован
- [ ] Токены, не хардкод
- [ ] Mobile-first, проверено на 360px
- [ ] Картинки: alt + lazy
- [ ] Семантика: `<article>`, `<section>`, `<nav>`
- [ ] Lighthouse 80/90

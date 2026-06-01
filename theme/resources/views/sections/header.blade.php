@php
  $currentLang = function_exists('pll_current_language') ? pll_current_language() : 'ru';
  $langSwitch  = [];
  if (function_exists('pll_the_languages')) {
    $langs = pll_the_languages(['raw' => 1]);
    foreach ($langs as $lang) {
      $langSwitch[$lang['slug']] = $lang['url'];
    }
  }
  $phone = qazaqstan_option('phone_primary') ?: '+7 (727) 264-64-54';
@endphp

<header data-header class="fixed top-0 inset-x-0 z-[30] transition-all duration-300">
  <div class="container flex items-center justify-between h-20">

    <a href="{{ home_url('/') }}" class="header-logo transition-opacity duration-300 select-none" aria-label="{{ __('QAZAQSTAN Resort — главная', 'qazaqstan') }}">
      @include('partials.logo')
    </a>

    <nav class="hidden lg:flex items-center gap-4" aria-label="{{ __('Главное меню', 'qazaqstan') }}">
      <a href="{{ home_url('/about/') }}" class="header-nav-link">{{ __('О санатории', 'qazaqstan') }}</a>

      <div class="header-dropdown-wrap">
        <button class="header-nav-link--btn" type="button" aria-haspopup="true" aria-expanded="false">
          {{ __('Услуги', 'qazaqstan') }}
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="header-dropdown" role="menu" style="margin-left:-90px">
          <a href="{{ home_url('/treatment/') }}" role="menuitem">
            <span class="header-dropdown__icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></span>
            {{ __('Лечение', 'qazaqstan') }}
          </a>
          <a href="{{ home_url('/sport/') }}" role="menuitem">
            <span class="header-dropdown__icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.4 14.4 9.6 9.6"/><path d="m21 21-1-1"/><path d="m3 3 1 1"/><path d="m18 22 4-4"/><path d="m2 6 4-4"/><path d="m3 10 7-7"/><path d="m14 21 7-7"/></svg></span>
            {{ __('Спорт и бассейн', 'qazaqstan') }}
          </a>
          <a href="{{ home_url('/services/') }}" role="menuitem">
            <span class="header-dropdown__icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg></span>
            {{ __('Доп. услуги', 'qazaqstan') }}
          </a>
        </div>
      </div>

      <div class="header-dropdown-wrap">
        <button class="header-nav-link--btn" type="button" aria-haspopup="true" aria-expanded="false">
          {{ __('Пресс-центр', 'qazaqstan') }}
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="header-dropdown" role="menu" style="margin-left:-100px">
          <a href="{{ home_url('/blog/') }}" role="menuitem">
            <span class="header-dropdown__icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></span>
            {{ __('Блог и новости', 'qazaqstan') }}
          </a>
          <a href="{{ home_url('/vacancies/') }}" role="menuitem">
            <span class="header-dropdown__icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-4 0v2"/></svg></span>
            {{ __('Вакансии', 'qazaqstan') }}
          </a>
          <a href="{{ home_url('/procurement/') }}" role="menuitem">
            <span class="header-dropdown__icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg></span>
            {{ __('Госзакупки', 'qazaqstan') }}
          </a>
        </div>
      </div>

      <div class="header-dropdown-wrap">
        <button class="header-nav-link--btn" type="button" aria-haspopup="true" aria-expanded="false">
          {{ __('Инфраструктура', 'qazaqstan') }}
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="header-dropdown" role="menu" style="margin-left:-100px">
          <a href="{{ home_url('/accommodation/') }}" role="menuitem">
            <span class="header-dropdown__icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
            {{ __('Номера', 'qazaqstan') }}
          </a>
          <a href="{{ home_url('/conferences/') }}" role="menuitem">
            <span class="header-dropdown__icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
            {{ __('Конференц-залы', 'qazaqstan') }}
          </a>
          <a href="{{ home_url('/gallery/') }}" role="menuitem">
            <span class="header-dropdown__icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></span>
            {{ __('Галерея', 'qazaqstan') }}
          </a>
        </div>
      </div>

      <a href="{{ home_url('/anti-corruption/') }}" class="header-nav-link">{{ __('Антикоррупция', 'qazaqstan') }}</a>
      <a href="{{ home_url('/contacts/') }}" class="header-nav-link">{{ __('Контакты', 'qazaqstan') }}</a>
    </nav>

    <div class="flex items-center gap-2 md:gap-3">
      <div class="header-lang hidden md:flex">
        @if(!empty($langSwitch))
          @foreach($langSwitch as $slug => $url)
            <a href="{{ esc_url($url) }}" class="header-lang__btn {{ $currentLang === $slug ? 'is-active' : '' }}" hreflang="{{ $slug }}">
              {{ $slug === 'kk' ? 'ҚАЗ' : 'РУС' }}
            </a>
          @endforeach
        @else
          <button class="header-lang__btn is-active" type="button">РУС</button>
          <button class="header-lang__btn" type="button">ҚАЗ</button>
        @endif
      </div>

      <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="header-phone hidden xl:block font-display font-bold text-[13px] transition-colors duration-300">
        {{ esc_html($phone) }}
      </a>
      <a href="{{ home_url('/booking/') }}" class="header-cta btn btn--sm rounded-md font-bold text-[13px]">{{ __('Забронировать', 'qazaqstan') }}</a>

      <button data-menu-trigger type="button" aria-label="{{ __('Открыть меню', 'qazaqstan') }}" aria-expanded="false" class="header-menu-icon lg:hidden p-2 -mr-2 transition-colors duration-300">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true">
          <line x1="3" y1="6" x2="21" y2="6"/>
          <line x1="3" y1="12" x2="21" y2="12"/>
          <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>
    </div>

  </div>
</header>

<aside data-menu-drawer class="fixed inset-0 z-[50] bg-white translate-x-full transition-transform duration-300 ease-out lg:hidden [&.is-open]:translate-x-0 overflow-y-auto" aria-label="{{ __('Мобильное меню', 'qazaqstan') }}">
  <div class="container flex items-center justify-between h-20 border-b border-warm-grey">
    <a href="{{ home_url('/') }}" class="select-none" aria-label="{{ __('На главную', 'qazaqstan') }}">
      @include('partials.logo', ['class' => 'h-8'])
    </a>
    <button data-menu-close type="button" aria-label="{{ __('Закрыть меню', 'qazaqstan') }}" class="p-2 -mr-2 text-charcoal">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  </div>
  <nav class="container flex flex-col mt-4 pb-8 text-charcoal" aria-label="{{ __('Мобильное меню', 'qazaqstan') }}">
    <p class="text-[11px] font-bold uppercase tracking-widest text-soft-grey mt-4 mb-1">{{ __('Основное', 'qazaqstan') }}</p>
    <a href="{{ home_url('/') }}"                class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Главная', 'qazaqstan') }}</a>
    <a href="{{ home_url('/about/') }}"           class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('О санатории', 'qazaqstan') }}</a>
    <a href="{{ home_url('/contacts/') }}"        class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Контакты', 'qazaqstan') }}</a>
    <p class="text-[11px] font-bold uppercase tracking-widest text-soft-grey mt-5 mb-1">{{ __('Услуги', 'qazaqstan') }}</p>
    <a href="{{ home_url('/treatment/') }}"       class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Лечение', 'qazaqstan') }}</a>
    <a href="{{ home_url('/sport/') }}"           class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Спорт и бассейн', 'qazaqstan') }}</a>
    <a href="{{ home_url('/services/') }}"        class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Доп. услуги', 'qazaqstan') }}</a>
    <p class="text-[11px] font-bold uppercase tracking-widest text-soft-grey mt-5 mb-1">{{ __('Инфраструктура', 'qazaqstan') }}</p>
    <a href="{{ home_url('/accommodation/') }}"   class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Номера', 'qazaqstan') }}</a>
    <a href="{{ home_url('/conferences/') }}"     class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Конференц-залы', 'qazaqstan') }}</a>
    <a href="{{ home_url('/gallery/') }}"         class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Галерея', 'qazaqstan') }}</a>
    <p class="text-[11px] font-bold uppercase tracking-widest text-soft-grey mt-5 mb-1">{{ __('Пресс-центр', 'qazaqstan') }}</p>
    <a href="{{ home_url('/blog/') }}"            class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Блог и новости', 'qazaqstan') }}</a>
    <a href="{{ home_url('/vacancies/') }}"       class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Вакансии', 'qazaqstan') }}</a>
    <a href="{{ home_url('/procurement/') }}"     class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Госзакупки', 'qazaqstan') }}</a>
    <a href="{{ home_url('/anti-corruption/') }}" class="py-3 border-b border-warm-grey font-display font-bold text-base uppercase tracking-wide hover:text-klein-blue transition-colors">{{ __('Антикоррупция', 'qazaqstan') }}</a>

    @if(!empty($langSwitch))
    <div class="mt-6 flex gap-2">
      @foreach($langSwitch as $slug => $url)
        <a href="{{ esc_url($url) }}" class="header-lang__btn {{ $currentLang === $slug ? 'is-active' : '' }}" hreflang="{{ $slug }}">
          {{ $slug === 'kk' ? 'ҚАЗ' : 'РУС' }}
        </a>
      @endforeach
    </div>
    @endif

    <div class="mt-6 flex flex-col gap-3">
      <a href="{{ home_url('/booking/') }}"                  class="btn btn--primary btn--lg w-full justify-center">{{ __('Забронировать путёвку', 'qazaqstan') }}</a>
      <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}"  class="btn btn--secondary btn--lg w-full justify-center">{{ esc_html($phone) }}</a>
    </div>
  </nav>
</aside>

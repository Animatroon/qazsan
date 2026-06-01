@extends('layouts.app')

@section('content')

@php
  $address   = qazaqstan_option('address')        ?: 'г. Алматы, пр. Достык, 308';
  $phone1    = qazaqstan_option('phone_primary')   ?: '+7 (727) 264-64-54';
  $phone2    = qazaqstan_option('phone_secondary') ?: '+7 707 691 5008';
  $email     = qazaqstan_option('email')           ?: 'info@kazakhstansan.kz';
  $hours     = qazaqstan_option('work_hours')      ?: 'Пн–Пт: 08:00–18:00';
  $lat       = qazaqstan_option('map_lat')         ?: '43.2567';
  $lng       = qazaqstan_option('map_lng')         ?: '76.9286';
  $requisites = qazaqstan_option('requisites')     ?: '';
@endphp

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Контакты', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Контакты', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Свяжитесь с нами', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65" style="font-size:17px;line-height:1.6;">
      {{ __('Мы находимся в Алматы на проспекте Достык. Принимаем заявки по телефону, форме обратной связи и электронной почте.', 'qazaqstan') }}
    </p>
  </div>
</div>

{{-- Контакты-карточки --}}
<section class="py-20 bg-off-white" aria-labelledby="contacts-cards-heading">
  <div class="container">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="contact-card">
        <div class="contact-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div>
          <p class="contact-card__label">{{ __('Адрес', 'qazaqstan') }}</p>
          <p class="contact-card__value">{{ esc_html($address) }}</p>
          <a href="https://2gis.kz/almaty/search/{{ rawurlencode($address) }}" target="_blank" rel="noopener noreferrer" class="contact-card__link">
            {{ __('Открыть на 2ГИС', 'qazaqstan') }}
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          </a>
        </div>
      </div>

      <div class="contact-card">
        <div class="contact-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.43a2 2 0 0 1 1.99-2.18h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.91A16 16 0 0 0 14.09 16l1.04-.95a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </div>
        <div>
          <p class="contact-card__label">{{ __('Телефоны', 'qazaqstan') }}</p>
          <a href="{{ esc_url(qazaqstan_phone_link($phone1)) }}" class="contact-card__value contact-card__value--link">{{ esc_html($phone1) }}</a>
          @if($phone2)
            <a href="{{ esc_url(qazaqstan_phone_link($phone2)) }}" class="contact-card__value contact-card__value--link">{{ esc_html($phone2) }}</a>
          @endif
          <a href="{{ esc_url(qazaqstan_phone_link($phone1)) }}" class="contact-card__link">{{ __('Позвонить сейчас', 'qazaqstan') }} <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg></a>
        </div>
      </div>

      @if($email)
      <div class="contact-card">
        <div class="contact-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <div>
          <p class="contact-card__label">{{ __('Электронная почта', 'qazaqstan') }}</p>
          <a href="mailto:{{ esc_attr($email) }}" class="contact-card__value contact-card__value--link">{{ esc_html($email) }}</a>
          <p class="contact-card__value" style="color:var(--soft-grey);font-size:13px;">{{ __('Ответ в течение 1 рабочего дня', 'qazaqstan') }}</p>
        </div>
      </div>
      @endif

      <div class="contact-card">
        <div class="contact-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
          <p class="contact-card__label">{{ __('Режим работы', 'qazaqstan') }}</p>
          <p class="contact-card__value">{{ esc_html($hours) }}</p>
          <p class="contact-card__link" style="color:var(--may-green);font-weight:700;cursor:default;">{{ __('Приём заявок 24/7', 'qazaqstan') }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Карта + форма обращения --}}
<section class="py-20 bg-white" aria-labelledby="contact-form-heading">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

      {{-- Карта --}}
      <div>
        <p class="eyebrow">{{ __('Как нас найти', 'qazaqstan') }}</p>
        <h2 class="h2 mt-3">{{ __('Мы на карте', 'qazaqstan') }}</h2>
        <p class="mt-4 text-soft-grey" style="font-size:17px;line-height:1.65;">
          {{ __('Санаторий расположен у подножия гор Заилийского Алатау. Удобный подъезд с проспекта Достык, охраняемая парковка.', 'qazaqstan') }}
        </p>
        <div class="mt-6 rounded-2xl overflow-hidden border border-warm-grey map-embed">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2906.7!2d{{ esc_attr($lng) }}!3d{{ esc_attr($lat) }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zQVpBUVNUQU4!5e0!3m2!1sru!2skz!4v1700000000000"
            width="100%" height="360" style="border:0;" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="{{ __('Карта проезда к санаторию «Казахстан»', 'qazaqstan') }}"></iframe>
        </div>
        <div class="mt-8 flex flex-col gap-4">
          @foreach([
            ['На машине', 'По пр. Достык в сторону гор. Ориентир — «Достык Плаза». Санаторий за ним.'],
            ['На автобусе', 'Маршруты №17, №28, №65 — остановка «Ул. Аль-Фараби». 5 минут пешком вверх по Достык.'],
            ['Такси', 'Скажите: «Санаторий "Казахстан", проспект Достык 308». Яндекс Go, inDriver, Uber.'],
          ] as [$how, $desc])
            <div class="flex gap-4 items-start">
              <div class="contact-card__icon flex-shrink-0">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
              </div>
              <div>
                <p class="font-display font-bold text-charcoal text-[14px]">{{ __($how, 'qazaqstan') }}</p>
                <p class="text-soft-grey text-[14px] mt-1 leading-relaxed">{{ __($desc, 'qazaqstan') }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      {{-- Форма обращения --}}
      <div>
        <p class="eyebrow">{{ __('Обратная связь', 'qazaqstan') }}</p>
        <h2 class="h2 mt-3" id="contact-form-heading">{{ __('Напишите нам', 'qazaqstan') }}</h2>
        <p class="mt-4 text-soft-grey" style="font-size:17px;line-height:1.65;">{{ __('Выберите тему — ответим в течение одного рабочего дня.', 'qazaqstan') }}</p>

        <div class="form-type-tabs mt-7" id="contactTypeTabs" role="tablist">
          @foreach([
            ['general',    'Общий вопрос'],
            ['booking',    'Бронирование'],
            ['complaint',  'Жалоба'],
            ['president',  'Президенту АО'],
          ] as $i => [$type, $label])
            <button class="form-type-tab {{ $i === 0 ? 'form-type-tab--active' : '' }}"
              data-target="cf-panel-{{ $type }}" role="tab"
              aria-selected="{{ $i === 0 ? 'true' : 'false' }}" type="button">
              {{ __($label, 'qazaqstan') }}
            </button>
          @endforeach
        </div>

        @foreach([
          ['general',   'Общий вопрос',       'Опишите ваш вопрос...'],
          ['booking',   'Вопрос по брони',     'Тип номера, даты, число гостей...'],
          ['complaint', 'Жалоба или предложение', 'Опишите ситуацию подробно...'],
          ['president', 'Обращение к руководству', 'Текст обращения...'],
        ] as $i => [$type, $title, $placeholder])
          <div id="cf-panel-{{ $type }}" class="form-panel {{ $i === 0 ? 'form-panel--active' : '' }} mt-6">
            <form class="contact-form" data-appeal-form data-type="{{ $type }}" novalidate>
              {!! wp_nonce_field('qazaqstan_appeal', '_wpnonce', true, false) !!}
              <input type="hidden" name="appeal_type" value="{{ $type }}">
              <input type="text" name="website" class="sr-only" tabindex="-1" autocomplete="off" aria-hidden="true">
              <div class="contact-form__row">
                <div class="contact-form__field">
                  <label for="cf-{{ $type }}-name" class="contact-form__label">{{ __('ФИО', 'qazaqstan') }} <span aria-hidden="true">*</span></label>
                  <input type="text" id="cf-{{ $type }}-name" name="name" class="contact-form__input" required autocomplete="name">
                </div>
                <div class="contact-form__field">
                  <label for="cf-{{ $type }}-phone" class="contact-form__label">{{ __('Телефон', 'qazaqstan') }} <span aria-hidden="true">*</span></label>
                  <input type="tel" id="cf-{{ $type }}-phone" name="phone" class="contact-form__input" required autocomplete="tel">
                </div>
              </div>
              <div class="contact-form__field">
                <label for="cf-{{ $type }}-email" class="contact-form__label">{{ __('Email', 'qazaqstan') }}</label>
                <input type="email" id="cf-{{ $type }}-email" name="email" class="contact-form__input" autocomplete="email">
              </div>
              <div class="contact-form__field">
                <label for="cf-{{ $type }}-msg" class="contact-form__label">{{ __('Сообщение', 'qazaqstan') }} <span aria-hidden="true">*</span></label>
                <textarea id="cf-{{ $type }}-msg" name="message" class="contact-form__textarea" rows="5" placeholder="{{ __($placeholder, 'qazaqstan') }}" required></textarea>
              </div>
              <button type="submit" class="btn btn--primary btn--lg w-full justify-center mt-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                {{ __('Отправить', 'qazaqstan') }}
              </button>
              <div class="contact-form__status mt-3 hidden" aria-live="polite"></div>
            </form>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- Реквизиты --}}
@if($requisites)
<section class="py-20 bg-off-white" aria-labelledby="requisites-heading">
  <div class="container">
    <div class="max-w-3xl mx-auto">
      <p class="eyebrow">{{ __('Документы', 'qazaqstan') }}</p>
      <h2 class="h2 mt-3" id="requisites-heading">{{ __('Реквизиты', 'qazaqstan') }}</h2>
      <div class="mt-8 p-8 bg-white border border-warm-grey rounded-xl">
        <pre class="text-charcoal text-[15px] leading-relaxed whitespace-pre-wrap font-body">{{ esc_html($requisites) }}</pre>
      </div>
    </div>
  </div>
</section>
@endif

@include('partials.cta-band', ['heading' => __('Готовы к оздоровлению?', 'qazaqstan')])

<script>
(function () {
  const tabs = document.querySelectorAll('.form-type-tab');
  const panels = document.querySelectorAll('.form-panel');
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => { t.classList.remove('form-type-tab--active'); t.setAttribute('aria-selected', 'false'); });
      panels.forEach(p => p.classList.remove('form-panel--active'));
      tab.classList.add('form-type-tab--active');
      tab.setAttribute('aria-selected', 'true');
      document.getElementById(tab.dataset.target)?.classList.add('form-panel--active');
    });
  });
})();
</script>

@endsection

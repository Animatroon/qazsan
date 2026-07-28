@extends('layouts.app')

@section('content')
@php
  $docs = get_posts([
    'post_type'      => 'document',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'tax_query'      => [['taxonomy' => 'doc_type', 'field' => 'slug', 'terms' => 'anti-corruption']],
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);
  $phone = qazaqstan_option('phone_primary') ?: '+7 (727) 264-64-54';
  $email = qazaqstan_option('email') ?: 'info@kazakhstansan.kz';
@endphp

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Антикоррупция', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Прозрачность', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Антикоррупционная политика', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65 text-[17px] leading-[1.6]">
      {{ __('АО «Санаторий Казахстан» придерживается принципов прозрачности и нулевой толерантности к коррупции.', 'qazaqstan') }}
    </p>
  </div>
</div>

{{-- Горячая линия --}}
<section class="section bg-off-white">
  <div class="container">
    <div class="max-w-2xl mx-auto text-center p-10 border-2 border-klein-blue rounded-2xl bg-white">
      <div class="w-16 h-16 rounded-full mx-auto mb-5 flex items-center justify-center bg-klein-blue/8 text-klein-blue">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.43a2 2 0 0 1 1.99-2.18h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.91A16 16 0 0 0 14.09 16l1.04-.95a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      </div>
      <p class="eyebrow text-center mb-3">{{ __('Горячая линия', 'qazaqstan') }}</p>
      <h2 class="h3">{{ __('Сообщить о факте коррупции', 'qazaqstan') }}</h2>
      <p class="mt-3 text-soft-grey text-[16px]">{{ __('Все обращения рассматриваются в установленные законом сроки. Конфиденциальность гарантируется.', 'qazaqstan') }}</p>
      <div class="flex flex-wrap gap-3 justify-center mt-6">
        <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--primary">{{ esc_html($phone) }}</a>
        @if($email)<a href="mailto:{{ esc_attr($email) }}" class="btn btn--secondary">{{ esc_html($email) }}</a>@endif
      </div>
    </div>
  </div>
</section>

{{-- Принципы --}}
<section class="section bg-white">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Политика', 'qazaqstan') }}</p>
      <h2 class="h2 mt-4">{{ __('Антикоррупционная политика компании', 'qazaqstan') }}</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach([
        ['Нулевая толерантность',    'АО «Санаторий Казахстан» не допускает никаких форм коррупции, взяточничества и злоупотребления должностным положением.'],
        ['Прозрачность закупок',     'Все закупки товаров, работ и услуг проводятся в строгом соответствии с законодательством РК о государственных закупках.'],
        ['Защита информаторов',      'Лица, сообщившие о фактах коррупции, находятся под защитой. Преследование информаторов не допускается.'],
      ] as [$title, $text])
        <div class="value-card">
          <div class="value-card__icon value-card__icon--blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <h3 class="value-card__title">{{ __($title, 'qazaqstan') }}</h3>
          <p class="value-card__text">{{ __($text, 'qazaqstan') }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Документы --}}
@if(count($docs))
  <section class="section">
    <div class="container">
      <div class="section-header section-header--center mb-12">
        <p class="eyebrow">{{ __('Документы', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ __('Нормативная база и декларации', 'qazaqstan') }}</h2>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($docs as $doc)
          @php $file = qazaqstan_field('document_file', $doc->ID); @endphp
          <div class="flex gap-4 p-5 border border-warm-grey rounded-xl bg-white hover:border-klein-blue transition-colors">
            <div class="w-11 h-11 rounded-[10px] flex items-center justify-center flex-shrink-0 bg-klein-blue/8 text-klein-blue">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div class="flex-1 min-w-0">
              <p class="font-display font-bold text-charcoal text-[14px]">{{ esc_html($doc->post_title) }}</p>
              @if($doc->post_excerpt)
                <p class="text-soft-grey text-[12px] mt-1">{{ esc_html($doc->post_excerpt) }}</p>
              @endif
              @if(!empty($file['url']))
                <a href="{{ esc_url($file['url']) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-klein-blue text-[13px] font-bold mt-2 hover:underline">
                  PDF <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </a>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endif

{{-- Форма сообщения --}}
<section id="report-form" class="section bg-white">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
      <div>
        <p class="eyebrow">{{ __('Сообщить', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ __('Сообщить о факте коррупции', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Обращение рассматривается в течение 15 рабочих дней. Анонимность обеспечивается при желании заявителя.', 'qazaqstan') }}
        </p>
        <div class="mt-8 p-6 bg-off-white rounded-xl">
          <p class="font-display font-bold text-[15px] text-charcoal mb-3">{{ __('Также можно обратиться:', 'qazaqstan') }}</p>
          @foreach([
            ['Агентство по противодействию коррупции РК', 'https://anticor.gov.kz'],
            ['Генеральная прокуратура РК', 'https://www.gov.kz/memleket/entities/procuror'],
            ['Портал egov.kz', 'https://egov.kz'],
          ] as [$name, $url])
            <div class="flex items-center justify-between py-2.5 border-b border-warm-grey last:border-0">
              <span class="text-charcoal text-[14px]">{{ $name }}</span>
              <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="text-klein-blue text-[13px] font-bold hover:underline">{{ __('Перейти', 'qazaqstan') }}</a>
            </div>
          @endforeach
        </div>
      </div>

      <form class="contact-form" data-appeal-form data-type="corruption" novalidate>
        {!! wp_nonce_field('qazaqstan_appeal', '_wpnonce', true, false) !!}
        <input type="hidden" name="appeal_type" value="corruption">
        <input type="text" name="website" class="sr-only" tabindex="-1" autocomplete="off" aria-hidden="true">
        <div class="contact-form__field">
          <label for="ac-name" class="contact-form__label">{{ __('ФИО (необязательно)', 'qazaqstan') }}</label>
          <input type="text" id="ac-name" name="name" class="contact-form__input" autocomplete="name" placeholder="{{ __('Можно оставить анонимно', 'qazaqstan') }}">
        </div>
        <div class="contact-form__field">
          <label for="ac-contact" class="contact-form__label">{{ __('Контакт для ответа', 'qazaqstan') }}</label>
          <input type="text" id="ac-contact" name="contact" class="contact-form__input" placeholder="{{ __('Телефон или email', 'qazaqstan') }}">
        </div>
        <div class="contact-form__field">
          <label for="ac-msg" class="contact-form__label">{{ __('Описание ситуации', 'qazaqstan') }} <span aria-hidden="true">*</span></label>
          <textarea id="ac-msg" name="message" class="contact-form__textarea" rows="6" required placeholder="{{ __('Опишите факт коррупции, дату, место, лиц причастных к нарушению...', 'qazaqstan') }}"></textarea>
        </div>
        <button type="submit" class="btn btn--primary btn--lg w-full justify-center mt-2">{{ __('Отправить обращение', 'qazaqstan') }}</button>
        <p class="text-soft-grey text-[13px] mt-3 text-center">{{ __('Конфиденциальность гарантируется законодательством РК.', 'qazaqstan') }}</p>
        <div class="contact-form__status mt-3 hidden" aria-live="polite"></div>
      </form>
    </div>
  </div>
</section>

@endsection

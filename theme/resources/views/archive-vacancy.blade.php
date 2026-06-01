@extends('layouts.app')

@section('content')
@php
  $vacancies = get_posts([
    'post_type'      => 'vacancy',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => [['key' => 'vacancy_status', 'value' => 'open']],
  ]);
  $closed = get_posts([
    'post_type'      => 'vacancy',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => [['key' => 'vacancy_status', 'value' => 'closed']],
  ]);
@endphp

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Вакансии', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Карьера', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Работайте там, где важно здоровье', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65" style="font-size:17px;line-height:1.6;">
      {{ __('Мы ищем специалистов, которые разделяют нашу миссию — помогать людям быть здоровыми.', 'qazaqstan') }}
    </p>
  </div>
</div>

{{-- Преимущества --}}
<section class="section bg-white" aria-label="{{ __('Преимущества работодателя', 'qazaqstan') }}">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Работодатель', 'qazaqstan') }}</p>
      <h2 class="h2 mt-4">{{ __('Мы заботимся о команде', 'qazaqstan') }}</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach([
        ['Официальное трудоустройство', 'Оформление по ТК РК, полный соцпакет и отчисления в ЕНПФ.'],
        ['Льготные путёвки', 'Сотрудники и их семьи получают скидки на санаторно-курортное лечение.'],
        ['Профессиональный рост', 'Обучение, курсы повышения квалификации и участие в отраслевых конференциях.'],
        ['Стабильный работодатель', '40 лет на рынке. АО с государственным участием — надёжность и стабильность.'],
      ] as [$title, $desc])
        <div class="value-card">
          <div class="value-card__icon value-card__icon--blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <h3 class="value-card__title">{{ __($title, 'qazaqstan') }}</h3>
          <p class="value-card__text">{{ __($desc, 'qazaqstan') }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Открытые вакансии --}}
<section id="vacancies-list" class="section" aria-label="{{ __('Открытые вакансии', 'qazaqstan') }}">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Вакансии', 'qazaqstan') }}</p>
      <h2 class="h2 mt-4">{{ count($vacancies) ? sprintf(__('%d открытых вакансии', 'qazaqstan'), count($vacancies)) : __('Вакансии', 'qazaqstan') }}</h2>
    </div>

    @if(count($vacancies))
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach($vacancies as $v)
          @php
            $dept     = qazaqstan_field('vacancy_department', $v->ID);
            $salary   = qazaqstan_field('vacancy_salary', $v->ID);
            $deadline = qazaqstan_field('vacancy_deadline', $v->ID);
            $duties   = qazaqstan_field('vacancy_duties', $v->ID) ?: [];
          @endphp
          <article class="card p-6">
            <div class="flex items-start justify-between gap-4">
              <div>
                @if($dept)<span class="card__eyebrow">{{ esc_html($dept) }}</span>@endif
                <h3 class="card__title mt-1">
                  <a href="{{ get_permalink($v) }}" class="hover:text-klein-blue transition-colors">{{ esc_html($v->post_title) }}</a>
                </h3>
              </div>
              <span class="badge badge--discount flex-shrink-0">{{ __('Открыта', 'qazaqstan') }}</span>
            </div>
            @if($salary)
              <p class="mt-3 font-display font-bold text-[18px] text-klein-blue">{{ esc_html($salary) }}</p>
            @endif
            @if(count($duties) > 0)
              <ul class="mt-4 space-y-1 text-soft-grey text-[14px]">
                @foreach(array_slice($duties, 0, 3) as $d)
                  <li class="flex gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-0.5" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ esc_html($d['item']) }}
                  </li>
                @endforeach
              </ul>
            @endif
            <div class="flex items-center justify-between mt-6">
              @if($deadline)
                <span class="text-soft-grey text-[13px]">{{ __('до', 'qazaqstan') }} {{ esc_html(date_i18n('d.m.Y', strtotime($deadline))) }}</span>
              @endif
              <a href="{{ get_permalink($v) }}" class="btn btn--primary btn--sm">{{ __('Подробнее', 'qazaqstan') }}</a>
            </div>
          </article>
        @endforeach
      </div>
    @else
      <div class="text-center py-16 bg-off-white rounded-2xl">
        <p class="text-soft-grey text-[17px]">{{ __('Сейчас открытых вакансий нет.', 'qazaqstan') }}</p>
        <p class="text-soft-grey text-[15px] mt-2">{{ __('Оставьте резюме — свяжемся, когда появится подходящая позиция.', 'qazaqstan') }}</p>
      </div>
    @endif
  </div>
</section>

{{-- Форма отклика --}}
<section id="apply" class="section bg-white" aria-label="{{ __('Форма отклика', 'qazaqstan') }}">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
      <div>
        <p class="eyebrow">{{ __('Откликнуться', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ __('Не нашли подходящую вакансию?', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Оставьте резюме — мы рассмотрим вашу кандидатуру и свяжемся при появлении подходящей позиции.', 'qazaqstan') }}
        </p>
      </div>
      <form class="contact-form" data-apply-form novalidate>
        {!! wp_nonce_field('qazaqstan_apply', '_wpnonce', true, false) !!}
        <input type="hidden" name="vacancy_id" value="0">
        <input type="text" name="website" class="sr-only" tabindex="-1" autocomplete="off" aria-hidden="true">
        <div class="contact-form__row">
          <div class="contact-form__field">
            <label for="apply-name" class="contact-form__label">{{ __('ФИО', 'qazaqstan') }} <span aria-hidden="true">*</span></label>
            <input type="text" id="apply-name" name="name" class="contact-form__input" required autocomplete="name">
          </div>
          <div class="contact-form__field">
            <label for="apply-phone" class="contact-form__label">{{ __('Телефон', 'qazaqstan') }} <span aria-hidden="true">*</span></label>
            <input type="tel" id="apply-phone" name="phone" class="contact-form__input" required autocomplete="tel">
          </div>
        </div>
        <div class="contact-form__field">
          <label for="apply-email" class="contact-form__label">{{ __('Email', 'qazaqstan') }}</label>
          <input type="email" id="apply-email" name="email" class="contact-form__input" autocomplete="email">
        </div>
        <div class="contact-form__field">
          <label for="apply-position" class="contact-form__label">{{ __('Желаемая должность', 'qazaqstan') }}</label>
          <input type="text" id="apply-position" name="position" class="contact-form__input">
        </div>
        <div class="contact-form__field">
          <label for="apply-message" class="contact-form__label">{{ __('О себе', 'qazaqstan') }}</label>
          <textarea id="apply-message" name="message" class="contact-form__textarea" rows="4" placeholder="{{ __('Опыт работы, навыки, пожелания...', 'qazaqstan') }}"></textarea>
        </div>
        <button type="submit" class="btn btn--primary btn--lg w-full justify-center mt-2">{{ __('Отправить резюме', 'qazaqstan') }}</button>
        <div class="contact-form__status mt-3 hidden" aria-live="polite"></div>
      </form>
    </div>
  </div>
</section>

@endsection

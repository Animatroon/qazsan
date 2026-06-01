@extends('layouts.app')

@section('content')
@php
  $post    = get_queried_object();
  $dept    = qazaqstan_field('vacancy_department', $post->ID);
  $salary  = qazaqstan_field('vacancy_salary', $post->ID);
  $status  = qazaqstan_field('vacancy_status', $post->ID) ?: 'open';
  $deadline = qazaqstan_field('vacancy_deadline', $post->ID);
  $reqs    = qazaqstan_field('vacancy_requirements', $post->ID) ?: [];
  $duties  = qazaqstan_field('vacancy_duties', $post->ID) ?: [];
@endphp

@include('partials.breadcrumbs', ['breadcrumbs' => [
  ['label' => __('Вакансии', 'qazaqstan'), 'url' => get_post_type_archive_link('vacancy')],
  ['label' => $post->post_title],
]])

<section class="section">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-12 items-start">
      <div>
        @if($dept)<p class="eyebrow">{{ esc_html($dept) }}</p>@endif
        <h1 id="vacancy-heading" class="h2 mt-3">{{ esc_html($post->post_title) }}</h1>
        @if($salary)
          <p class="mt-3 font-display font-bold text-[22px] text-klein-blue">{{ esc_html($salary) }}</p>
        @endif

        @if($post->post_content)
          <div class="prose prose-lg max-w-none mt-8">{!! apply_filters('the_content', $post->post_content) !!}</div>
        @endif

        @if(count($duties))
          <div class="mt-10">
            <h2 class="h3 mb-5">{{ __('Обязанности', 'qazaqstan') }}</h2>
            <ul class="space-y-2">
              @foreach($duties as $d)
                <li class="flex gap-3 text-charcoal text-[16px]">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--klein-blue)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-1" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                  {{ esc_html($d['item']) }}
                </li>
              @endforeach
            </ul>
          </div>
        @endif

        @if(count($reqs))
          <div class="mt-10">
            <h2 class="h3 mb-5">{{ __('Требования', 'qazaqstan') }}</h2>
            <ul class="space-y-2">
              @foreach($reqs as $r)
                <li class="flex gap-3 text-charcoal text-[16px]">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--may-green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-1" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                  {{ esc_html($r['item']) }}
                </li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>

      <aside class="sticky top-28">
        <div class="p-6 border border-warm-grey rounded-xl bg-white">
          <div class="flex items-center gap-3 mb-5">
            <span class="badge {{ $status === 'open' ? 'badge--discount' : 'bg-warm-grey text-soft-grey' }}">
              {{ $status === 'open' ? __('Открыта', 'qazaqstan') : __('Закрыта', 'qazaqstan') }}
            </span>
            @if($deadline)
              <span class="text-soft-grey text-[13px]">{{ __('до', 'qazaqstan') }} {{ esc_html(date_i18n('d.m.Y', strtotime($deadline))) }}</span>
            @endif
          </div>

          @if($status === 'open')
            <h3 class="font-display font-bold text-[17px] text-charcoal mb-4">{{ __('Откликнуться на вакансию', 'qazaqstan') }}</h3>
            <form data-apply-form novalidate>
              {!! wp_nonce_field('qazaqstan_apply', '_wpnonce', true, false) !!}
              <input type="hidden" name="vacancy_id" value="{{ $post->ID }}">
              <input type="hidden" name="vacancy_title" value="{{ esc_attr($post->post_title) }}">
              <input type="text" name="website" class="sr-only" tabindex="-1" autocomplete="off" aria-hidden="true">
              <div class="contact-form__field">
                <label for="sv-name" class="contact-form__label">{{ __('ФИО', 'qazaqstan') }} *</label>
                <input type="text" id="sv-name" name="name" class="contact-form__input" required autocomplete="name">
              </div>
              <div class="contact-form__field">
                <label for="sv-phone" class="contact-form__label">{{ __('Телефон', 'qazaqstan') }} *</label>
                <input type="tel" id="sv-phone" name="phone" class="contact-form__input" required autocomplete="tel">
              </div>
              <div class="contact-form__field">
                <label for="sv-email" class="contact-form__label">Email</label>
                <input type="email" id="sv-email" name="email" class="contact-form__input" autocomplete="email">
              </div>
              <div class="contact-form__field">
                <label for="sv-msg" class="contact-form__label">{{ __('О себе', 'qazaqstan') }}</label>
                <textarea id="sv-msg" name="message" class="contact-form__textarea" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn--primary w-full justify-center mt-2">{{ __('Отправить отклик', 'qazaqstan') }}</button>
              <div class="contact-form__status mt-3 hidden" aria-live="polite"></div>
            </form>
          @else
            <p class="text-soft-grey text-[15px]">{{ __('Эта вакансия закрыта. Смотрите другие открытые позиции.', 'qazaqstan') }}</p>
            <a href="{{ get_post_type_archive_link('vacancy') }}" class="btn btn--secondary w-full justify-center mt-4">{{ __('Все вакансии', 'qazaqstan') }}</a>
          @endif
        </div>
      </aside>
    </div>
  </div>
</section>

@endsection

@extends('layouts.app')

@section('content')
@php
  $rooms = get_posts([
    'post_type'      => 'room',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_key'       => 'room_price_single',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
  ]);
  $discounts = qazaqstan_option('discounts') ?: [
    ['label' => 'Пенсионеры по возрасту', 'percent' => 10],
    ['label' => 'Сотрудники МВД РК',       'percent' => 20],
    ['label' => 'Пенсионеры МВД РК',       'percent' => 30],
  ];
  $pkgItems = qazaqstan_option('package_includes') ?: [
    ['item' => 'Проживание и 5-разовое питание'],
    ['item' => 'Бассейн, сауна, тренажёрный зал'],
    ['item' => 'Все назначенные лечебные процедуры'],
    ['item' => 'Консультации 6 специалистов'],
  ];
  $selectedRoom = (int) ($_GET['room'] ?? 0);
@endphp

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Бронирование', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Онлайн-бронирование', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Забронируйте путёвку', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65" style="font-size:17px;line-height:1.6;">
      {{ __('Заполните форму — менеджер подтвердит бронирование в течение 30 минут.', 'qazaqstan') }}
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-12 items-start">

      {{-- Форма --}}
      <div>
        <form id="fullBookingForm" class="booking-form" data-booking-form novalidate>
          {!! wp_nonce_field('qazaqstan_booking', '_wpnonce', true, false) !!}
          <input type="text" name="website" class="booking-form__honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">

          <h2 class="h3 mb-6">{{ __('Ваши данные', 'qazaqstan') }}</h2>

          <div class="booking-form__row">
            <div class="booking-form__group">
              <label for="fb-name" class="booking-form__label">{{ __('Имя и фамилия', 'qazaqstan') }} *</label>
              <input type="text" id="fb-name" name="name" class="booking-form__input" required autocomplete="name">
            </div>
            <div class="booking-form__group">
              <label for="fb-phone" class="booking-form__label">{{ __('Телефон', 'qazaqstan') }} *</label>
              <input type="tel" id="fb-phone" name="phone" class="booking-form__input" placeholder="+7 (___) ___-__-__" required autocomplete="tel">
            </div>
          </div>

          <div class="booking-form__group">
            <label for="fb-email" class="booking-form__label">Email</label>
            <input type="email" id="fb-email" name="email" class="booking-form__input" autocomplete="email">
          </div>

          <h2 class="h3 mt-10 mb-6">{{ __('Параметры путёвки', 'qazaqstan') }}</h2>

          <div class="booking-form__row">
            <div class="booking-form__group">
              <label for="fb-checkin" class="booking-form__label">{{ __('Дата заезда', 'qazaqstan') }}</label>
              <input type="date" id="fb-checkin" name="checkin" class="booking-form__input">
            </div>
            <div class="booking-form__group">
              <label for="fb-checkout" class="booking-form__label">{{ __('Дата выезда', 'qazaqstan') }}</label>
              <input type="date" id="fb-checkout" name="checkout" class="booking-form__input">
            </div>
          </div>

          <div class="booking-form__group">
            <label for="fb-room" class="booking-form__label">{{ __('Тип номера', 'qazaqstan') }}</label>
            <select id="fb-room" name="room_type" class="booking-form__input">
              <option value="">{{ __('Выбрать тип номера', 'qazaqstan') }}</option>
              @if(count($rooms))
                @foreach($rooms as $r)
                  @php $rPrice = (int) qazaqstan_field('room_price_single', $r->ID); @endphp
                  <option value="{{ $r->ID }}" {{ $selectedRoom === $r->ID ? 'selected' : '' }}>
                    {{ esc_html($r->post_title) }}{{ $rPrice ? ' — ' . number_format($rPrice, 0, '.', ' ') . ' ₸/сут.' : '' }}
                  </option>
                @endforeach
              @else
                <option value="standard-1">{{ __('Стандарт 1-местный — 32 000 ₸/сут.', 'qazaqstan') }}</option>
                <option value="standard-2">{{ __('Стандарт 2-местный — 56 000 ₸/сут.', 'qazaqstan') }}</option>
                <option value="lux-1">{{ __('Люкс 1-местный — 45 000 ₸/сут.', 'qazaqstan') }}</option>
                <option value="lux-2">{{ __('Люкс 2-местный — 70 000 ₸/сут.', 'qazaqstan') }}</option>
                <option value="president-1">{{ __('Президентский 1-местный — 80 000 ₸/сут.', 'qazaqstan') }}</option>
                <option value="president-2">{{ __('Президентский 2-местный — 140 000 ₸/сут.', 'qazaqstan') }}</option>
              @endif
            </select>
          </div>

          <div class="booking-form__row">
            <div class="booking-form__group">
              <label for="fb-guests" class="booking-form__label">{{ __('Количество гостей', 'qazaqstan') }}</label>
              <select id="fb-guests" name="guests" class="booking-form__input">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4+</option>
              </select>
            </div>
            <div class="booking-form__group">
              <label for="fb-discount" class="booking-form__label">{{ __('Льготная категория', 'qazaqstan') }}</label>
              <select id="fb-discount" name="discount_category" class="booking-form__input">
                <option value="">{{ __('Не применяется', 'qazaqstan') }}</option>
                @foreach($discounts as $d)
                  <option value="{{ esc_attr($d['label']) }}">{{ esc_html($d['label']) }} ({{ $d['percent'] }}%)</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="booking-form__group">
            <label for="fb-comment" class="booking-form__label">{{ __('Комментарий', 'qazaqstan') }}</label>
            <textarea id="fb-comment" name="comment" class="booking-form__input booking-form__textarea" rows="4" placeholder="{{ __('Особые пожелания, вопросы по лечению, диете...', 'qazaqstan') }}"></textarea>
          </div>

          <button type="submit" class="btn btn--primary btn--block btn--lg mt-4">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            {{ __('Отправить заявку', 'qazaqstan') }}
          </button>
          <p class="booking-form__disclaimer mt-3">
            {{ __('Нажимая кнопку, вы соглашаетесь с', 'qazaqstan') }}
            <a href="{{ home_url('/privacy/') }}" class="underline underline-offset-2 hover:no-underline">{{ __('политикой конфиденциальности', 'qazaqstan') }}</a>
          </p>
          <div class="booking-form__status mt-4 hidden" aria-live="polite"></div>
        </form>
      </div>

      {{-- Правая колонка --}}
      <aside class="sticky top-28 space-y-5">
        <div class="p-6 bg-off-white border border-warm-grey rounded-xl">
          <p class="font-display font-bold text-[15px] text-charcoal mb-4">{{ __('В путёвку входит:', 'qazaqstan') }}</p>
          <ul class="space-y-2">
            @foreach($pkgItems as $pkg)
              <li class="flex gap-2.5 items-center text-charcoal text-[14px]">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--may-green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                {{ esc_html($pkg['item']) }}
              </li>
            @endforeach
          </ul>
        </div>

        <div class="p-6 bg-white border border-warm-grey rounded-xl">
          <p class="font-display font-bold text-[15px] text-charcoal mb-4">{{ __('Скидки:', 'qazaqstan') }}</p>
          <ul class="space-y-2">
            @foreach($discounts as $d)
              <li class="flex justify-between text-[14px]">
                <span class="text-charcoal">{{ esc_html($d['label']) }}</span>
                <span class="badge badge--discount">{{ $d['percent'] }}%</span>
              </li>
            @endforeach
          </ul>
        </div>

        <div class="p-6 bg-klein-blue rounded-xl text-white">
          <p class="font-display font-bold text-[15px] mb-2">{{ __('Есть вопросы?', 'qazaqstan') }}</p>
          @php $phone = qazaqstan_option('phone_primary') ?: '+7 (727) 264-64-54'; @endphp
          <p class="text-white/75 text-[13px] mb-4">{{ __('Звоните — ответим и поможем подобрать программу.', 'qazaqstan') }}</p>
          <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--white w-full justify-center">{{ esc_html($phone) }}</a>
        </div>
      </aside>

    </div>
  </div>
</section>

@endsection

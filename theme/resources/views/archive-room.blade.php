@extends('layouts.app')

@section('content')

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Проживание', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Проживание', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Номера', 'qazaqstan') }}<br><span class="text-white/70 text-[0.7em] font-body font-normal">{{ __('и размещение', 'qazaqstan') }}</span></h1>
    <p class="mt-5 max-w-xl text-white/72" style="font-size:17px;line-height:1.65;">
      {{ __('Три категории — Стандарт, Люкс и Президентский Люкс. В каждую путёвку включены питание, бассейн и все лечебные процедуры.', 'qazaqstan') }}
    </p>
    <div class="flex flex-wrap gap-3 mt-8">
      <a href="#rooms" class="btn btn--primary btn--lg">{{ __('Выбрать номер', 'qazaqstan') }}</a>
      @php $phone = qazaqstan_option('phone_primary') ?: '+7 (727) 264-64-54'; @endphp
      <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--ghost-white btn--lg">{{ esc_html($phone) }}</a>
    </div>
  </div>
</div>

{{-- Что включено в путёвку --}}
@php
  $pkgItems = qazaqstan_option('package_includes') ?: [];
  $defaultPkg = [
    ['item' => 'Проживание'],           ['item' => '5-разовое питание'],
    ['item' => 'Консультации 6 врачей'],['item' => 'Бассейн с минеральной водой'],
    ['item' => 'Сауна'],                ['item' => 'Лечебные процедуры'],
    ['item' => 'Массаж и ЛФК'],         ['item' => 'Фитобар'],
  ];
  $pkgList = count($pkgItems) ? $pkgItems : $defaultPkg;
@endphp
<section class="included-section" aria-labelledby="included-heading">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Базовая программа', 'qazaqstan') }}</p>
      <h2 id="included-heading" class="h2 mt-4">{{ __('Что входит в каждую путёвку', 'qazaqstan') }}</h2>
      <p class="mt-4 text-soft-grey max-w-[520px] mx-auto" style="font-size:17px;">
        {{ __('Независимо от категории — все эти услуги включены в стоимость без доплат', 'qazaqstan') }}
      </p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-4xl mx-auto">
      @foreach($pkgList as $pkg)
        <div class="included-item">
          <div class="included-item__icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <span class="included-item__text">{{ esc_html($pkg['item']) }}</span>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Список номеров --}}
@php
  $roomTypes = get_terms(['taxonomy' => 'room_type', 'hide_empty' => false]);
  $allRooms  = get_posts([
    'post_type'      => 'room',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_key'       => 'room_price_single',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
  ]);
@endphp
<section class="section" id="rooms" aria-labelledby="rooms-heading">
  <div class="container">
    <div class="section-header section-header--center mb-14">
      <p class="eyebrow">{{ __('Номера', 'qazaqstan') }}</p>
      <h2 id="rooms-heading" class="h2 mt-4">{{ count($allRooms) ?: '6' }} {{ __('типов номеров', 'qazaqstan') }}</h2>
    </div>

    @if(!is_wp_error($roomTypes) && count($roomTypes))
      @foreach($roomTypes as $type)
        @php
          $typeRooms = array_filter($allRooms, function($r) use ($type) {
            $terms = wp_get_post_terms($r->ID, 'room_type');
            return !is_wp_error($terms) && count(array_filter($terms, fn($t) => $t->term_id === $type->term_id));
          });
        @endphp
        @if(count($typeRooms))
          <div class="mb-16">
            <h3 class="h3 mb-8 pb-4 border-b border-warm-grey">{{ esc_html($type->name) }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              @foreach($typeRooms as $room)
                @include('partials.room-card', ['room' => $room])
              @endforeach
            </div>
          </div>
        @endif
      @endforeach
    @elseif(count($allRooms))
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($allRooms as $room)
          @include('partials.room-card', ['room' => $room])
        @endforeach
      </div>
    @else
      {{-- Заглушка до добавления номеров в админку --}}
      @foreach([
        ['Стандарт 1-местный', 32000, 18],
        ['Стандарт 2-местный', 56000, 18],
        ['Люкс 1-местный',     45000, 30],
        ['Люкс 2-местный',     70000, 30],
        ['Президентский 1-местный', 80000, 55],
        ['Президентский 2-местный', 140000, 55],
      ] as [$title, $price, $area])
        <article class="pricing-card">
          <div class="pricing-card__image bg-warm-grey h-48 flex items-center justify-center text-soft-grey text-sm">{{ __('Фото скоро', 'qazaqstan') }}</div>
          <div class="pricing-card__body">
            <h3 class="pricing-card__title">{{ __($title, 'qazaqstan') }}</h3>
            <div class="pricing-card__price">
              <span class="pricing-card__from">{{ __('от', 'qazaqstan') }}</span>
              <span class="pricing-card__amount">{{ number_format($price, 0, '.', ' ') }}</span>
              <span class="pricing-card__unit">₸&nbsp;/&nbsp;{{ __('сут.', 'qazaqstan') }}</span>
            </div>
            <a href="{{ home_url('/booking/') }}" class="btn btn--primary btn--block mt-6">{{ __('Забронировать', 'qazaqstan') }}</a>
          </div>
        </article>
      @endforeach
    @endif
  </div>
</section>

{{-- Скидки --}}
@php
  $discounts = qazaqstan_option('discounts') ?: [
    ['label' => 'Пенсионеры по возрасту', 'percent' => 10, 'note' => 'Пенсионное удостоверение'],
    ['label' => 'Сотрудники МВД РК',       'percent' => 20, 'note' => 'Действующие сотрудники и члены семей'],
    ['label' => 'Пенсионеры МВД РК',       'percent' => 30, 'note' => 'Ветераны МВД и члены семей'],
  ];
@endphp
<section class="section" style="background:var(--footer-navy);" aria-labelledby="disc-heading">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow eyebrow--cerulean">{{ __('Льготы', 'qazaqstan') }}</p>
      <h2 id="disc-heading" class="h2 mt-4 text-white">{{ __('Скидки на проживание', 'qazaqstan') }}</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      @foreach($discounts as $i => $d)
        <article class="discount-card {{ $i === 1 ? 'discount-card--featured' : '' }}">
          <div class="discount-card__percent">{{ esc_html($d['percent']) }}%</div>
          <h3 class="discount-card__title">{{ esc_html($d['label']) }}</h3>
          @if(!empty($d['note']))<p class="discount-card__text">{{ esc_html($d['note']) }}</p>@endif
        </article>
      @endforeach
    </div>
  </div>
</section>

@include('partials.cta-band', ['heading' => __('Найдите свой номер', 'qazaqstan')])

@endsection

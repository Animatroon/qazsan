@extends('layouts.app')

@section('content')
@php
  $phone = qazaqstan_option('phone_primary') ?: '+7 (727) 264-64-54';
@endphp

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Спорт и бассейн', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Спорт и оздоровление', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Движение — основа здоровья', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65 text-[17px] leading-[1.6]">
      {{ __('Бассейн с минеральной водой, тренажёрный зал, сауна и лечебная физкультура — всё включено в путёвку.', 'qazaqstan') }}
    </p>
  </div>
</div>

{{-- Ключевые показатели --}}
<section class="py-16 bg-white">
  <div class="container">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
      @foreach([
        ['28–32°C', 'температура воды'],
        ['365', 'дней в году'],
        ['7:00–22:00', 'работает зал'],
        ['15+', 'видов процедур'],
      ] as [$num, $label])
        <div class="about-stat text-center"><span class="about-stat__number block text-center">{{ $num }}</span><span class="about-stat__label text-center block">{{ __($label, 'qazaqstan') }}</span></div>
      @endforeach
    </div>
  </div>
</section>

{{-- Бассейн --}}
<section id="pool" class="section">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div>
        <p class="eyebrow">{{ __('Бассейн', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ __('Минеральная бальнеологическая вода', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Бассейн наполнен природной минеральной водой с уникальным составом. Температура поддерживается круглый год на уровне 28–32°C. Доступен всем гостям санатория.', 'qazaqstan') }}
        </p>
        <ul class="mt-6 space-y-3">
          @foreach(['Лечебно-профилактическое купание', 'Водная аэробика с инструктором', 'Индивидуальные занятия', 'Детский сеанс (по расписанию)'] as $item)
            <li class="flex gap-3 text-charcoal text-[16px]">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--bright-cerulean)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-1" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
              {{ __($item, 'qazaqstan') }}
            </li>
          @endforeach
        </ul>
      </div>
      <div class="rounded-xl overflow-hidden aspect-[4/3]">
        @php $poolImg = get_theme_mod('sport_pool_image'); @endphp
        @if($poolImg)
          <img src="{{ esc_url($poolImg) }}" alt="{{ __('Бассейн с минеральной водой — QAZAQSTAN Resort', 'qazaqstan') }}" loading="lazy" width="800" height="600" class="w-full h-full object-cover">
        @else
          @include('partials.media-placeholder', ['variant' => 'water', 'label' => __('Бассейн', 'qazaqstan')])
        @endif
      </div>
    </div>
  </div>
</section>

{{-- Сауна --}}
<section class="section bg-white">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div class="order-2 lg:order-1 rounded-xl overflow-hidden aspect-[4/3]">
        @php $saunaImg = get_theme_mod('sport_sauna_image'); @endphp
        @if($saunaImg)
          <img src="{{ esc_url($saunaImg) }}" alt="{{ __('Сауна — QAZAQSTAN Resort', 'qazaqstan') }}" loading="lazy" width="800" height="600" class="w-full h-full object-cover">
        @else
          @include('partials.media-placeholder', ['variant' => 'water', 'label' => __('Сауна', 'qazaqstan')])
        @endif
      </div>
      <div class="order-1 lg:order-2">
        <p class="eyebrow">{{ __('Релакс', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ __('Сауна, релакс-зона', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Финская сауна с регулируемой температурой для глубокого расслабления. Идеально сочетается с процедурами и бассейном.', 'qazaqstan') }}
        </p>
      </div>
    </div>
  </div>
</section>

{{-- Тренажёрный зал --}}
<section id="gym" class="section">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div>
        <p class="eyebrow">{{ __('Тренажёрный зал', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ __('Современное оборудование', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Кардио и силовые тренажёры ведущих производителей. Работает ежедневно с 7:00 до 22:00. Доступен гостям санатория.', 'qazaqstan') }}
        </p>
      </div>
      <div class="rounded-xl overflow-hidden aspect-[4/3]">
        @php $gymImg = get_theme_mod('sport_gym_image'); @endphp
        @if($gymImg)
          <img src="{{ esc_url($gymImg) }}" alt="{{ __('Тренажёрный зал — QAZAQSTAN Resort', 'qazaqstan') }}" loading="lazy" width="800" height="600" class="w-full h-full object-cover">
        @else
          @include('partials.media-placeholder', ['variant' => 'nature', 'label' => __('Тренажёрный зал', 'qazaqstan')])
        @endif
      </div>
    </div>
  </div>
</section>

{{-- ЛФК --}}
<section class="section bg-white" id="lfk">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
      <div>
        <p class="eyebrow">{{ __('ЛФК', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ __('Лечебная физкультура под наблюдением врача', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Групповые и индивидуальные занятия с инструктором. Программа формируется лечащим врачом и включена в путёвку.', 'qazaqstan') }}
        </p>
        <ul class="mt-6 space-y-3">
          @foreach(['Дыхательная гимнастика', 'Суставная гимнастика', 'Кардио-ЛФК', 'Реабилитационные упражнения'] as $item)
            <li class="flex gap-3 text-charcoal text-[16px]">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--may-green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-1" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
              {{ __($item, 'qazaqstan') }}
            </li>
          @endforeach
        </ul>
      </div>
      <div class="p-8 bg-off-white rounded-xl">
        <p class="font-display font-bold text-[17px] text-charcoal mb-4">{{ __('Хотите попасть к нам?', 'qazaqstan') }}</p>
        <p class="text-soft-grey text-[15px] mb-6">{{ __('Весь спортивный комплекс входит в стоимость путёвки. Запишитесь на проживание.', 'qazaqstan') }}</p>
        <a href="{{ home_url('/booking/') }}" class="btn btn--primary w-full justify-center">{{ __('Забронировать путёвку', 'qazaqstan') }}</a>
        <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--secondary w-full justify-center mt-3">{{ esc_html($phone) }}</a>
      </div>
    </div>
  </div>
</section>

@include('partials.cta-band')

@endsection

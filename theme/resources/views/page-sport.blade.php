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

{{-- Спортивный зал --}}
<section class="section bg-white" id="sport-hall">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div class="order-2 lg:order-1 rounded-xl overflow-hidden aspect-[4/3]">
        @php $sportHallImg = get_theme_mod('sport_hall_image'); @endphp
        @if($sportHallImg)
          <img src="{{ esc_url($sportHallImg) }}" alt="{{ __('Спортивный зал — волейбол и баскетбол, QAZAQSTAN Resort', 'qazaqstan') }}" loading="lazy" width="800" height="600" class="w-full h-full object-cover">
        @else
          @include('partials.media-placeholder', ['variant' => 'nature', 'label' => __('Спортивный зал', 'qazaqstan')])
        @endif
      </div>
      <div class="order-1 lg:order-2">
        <p class="eyebrow">{{ __('Игровые виды спорта', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ __('Спортивный зал', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Волейбольная и баскетбольная площадки для групповых игр и тренировок. Зал доступен для аренды сторонним группам.', 'qazaqstan') }}
        </p>
        <p class="mt-4 p-4 bg-off-white rounded-xl text-[15px] text-charcoal">
          {{ __('Аренда зала (10–12 чел.)', 'qazaqstan') }}: <strong>15 000 ₸</strong> / {{ __('час', 'qazaqstan') }}
        </p>
      </div>
    </div>
  </div>
</section>

{{-- Кедровая бочка --}}
<section class="section" id="cedar-barrel">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div>
        <p class="eyebrow eyebrow--cerulean">{{ __('Дополнительная процедура', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ __('Кедровая бочка', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Фитобочка из кедра с паровым прогревом — глубокое расслабление мышц, улучшение кровообращения и лёгкий детокс-эффект. Оплачивается отдельно от путёвки.', 'qazaqstan') }}
        </p>
        <p class="mt-4 p-4 bg-off-white rounded-xl text-[15px] text-charcoal inline-block">
          {{ __('Сеанс 5 минут', 'qazaqstan') }}: <strong>4 000 ₸</strong>
        </p>
      </div>
      <div class="rounded-xl overflow-hidden aspect-[4/3]">
        @php $cedarImg = get_theme_mod('sport_cedar_image'); @endphp
        @if($cedarImg)
          <img src="{{ esc_url($cedarImg) }}" alt="{{ __('Кедровая бочка — QAZAQSTAN Resort', 'qazaqstan') }}" loading="lazy" width="800" height="600" class="w-full h-full object-cover">
        @else
          @include('partials.media-placeholder', ['variant' => 'water', 'label' => __('Кедровая бочка', 'qazaqstan')])
        @endif
      </div>
    </div>
  </div>
</section>

{{-- Абонементы --}}
@php
  $memberships = [
    ['Бассейн + сауна + тренажёрный зал', 'Безлимитное посещение, 6:00–22:30', ['1 месяц' => 60000, '3 месяца' => 110000, '6 месяцев' => 190000, '12 месяцев' => 240000]],
    ['Бассейн + сауна', '12 посещений в месяц, 6:00–22:30', ['1 месяц' => 45000, '3 месяца' => 95000, '6 месяцев' => 170000, '12 месяцев' => 190000]],
    ['Тренажёрный зал', '10 посещений в месяц, 6:00–22:30', ['1 месяц' => 20000, '3 месяца' => 50000, '6 месяцев' => 80000, '12 месяцев' => 100000]],
  ];
@endphp
<section class="section bg-off-white" id="memberships" aria-labelledby="memberships-heading">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Для посетителей', 'qazaqstan') }}</p>
      <h2 id="memberships-heading" class="h2 mt-4">{{ __('Абонементы и разовые посещения', 'qazaqstan') }}</h2>
      <p class="section-lead mt-4">{{ __('Индивидуальная членская карточка — без необходимости бронировать путёвку', 'qazaqstan') }}</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      @foreach($memberships as [$title, $note, $tiers])
        <div class="p-6 bg-white border border-warm-grey rounded-xl">
          <h3 class="font-display font-bold text-charcoal text-[17px]">{{ __($title, 'qazaqstan') }}</h3>
          <p class="text-soft-grey text-[13px] mt-1 mb-5">{{ __($note, 'qazaqstan') }}</p>
          <ul class="space-y-2">
            @foreach($tiers as $period => $price)
              <li class="flex items-center justify-between text-[14px] border-b border-warm-grey pb-2">
                <span class="text-soft-grey">{{ __($period, 'qazaqstan') }}</span>
                <strong class="text-charcoal">{{ number_format($price, 0, '.', ' ') }} ₸</strong>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>
    <div class="flex flex-wrap justify-center gap-x-8 gap-y-2 mt-10 text-[14px] text-soft-grey">
      <span>{{ __('Разовое посещение бассейна (взрослые)', 'qazaqstan') }}: <strong class="text-charcoal">5 500 ₸</strong></span>
      <span>{{ __('Разовое посещение бассейна (дети 4–12 лет)', 'qazaqstan') }}: <strong class="text-charcoal">4 500 ₸</strong></span>
      <span>{{ __('Разовое посещение тренажёрного зала', 'qazaqstan') }}: <strong class="text-charcoal">3 000 ₸</strong></span>
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
        <a href="{{ qazaqstan_url('/booking/') }}" class="btn btn--primary w-full justify-center">{{ __('Забронировать путёвку', 'qazaqstan') }}</a>
        <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--secondary w-full justify-center mt-3">{{ esc_html($phone) }}</a>
      </div>
    </div>
  </div>
</section>

@include('partials.cta-band')

@endsection

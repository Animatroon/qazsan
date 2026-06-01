@extends('layouts.app')

@section('content')

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('О санатории', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('О санатории', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Многопрофильный лечебный комплекс с 40-летней историей', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65" style="font-size:17px;line-height:1.6;">
      {{ __('АО «Санаторий Казахстан» — одно из старейших здравниц Алматы. Принимаем гостей круглый год в предгорьях Алатау с 1985 года.', 'qazaqstan') }}
    </p>
  </div>
</div>

{{-- История --}}
<section class="section" id="history" aria-labelledby="history-heading">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div>
        <p class="eyebrow">{{ __('История', 'qazaqstan') }}</p>
        <h2 id="history-heading" class="h2 mt-4">{{ __('С 1985 года — на страже здоровья', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Санаторий «Казахстан» открылся в 1985 году как ведомственная здравница для сотрудников МВД Казахской ССР. С момента основания учреждение специализируется на санаторно-курортном лечении, реабилитации и профилактике заболеваний.', 'qazaqstan') }}
        </p>
        <p class="mt-4 text-soft-grey text-[17px] leading-relaxed">
          {{ __('В 1990-е годы санаторий прошёл реструктуризацию и стал акционерным обществом, открыв двери для широкой публики. Сегодня принимаем гостей из всех регионов Казахстана и стран ближнего зарубежья.', 'qazaqstan') }}
        </p>
        <p class="mt-4 text-soft-grey text-[17px] leading-relaxed">
          {{ __('За четыре десятилетия через санаторий прошли сотни тысяч пациентов. Постоянное обновление медицинского оборудования, обучение персонала и расширение программ лечения позволяют нам оставаться одной из ведущих здравниц Алматы.', 'qazaqstan') }}
        </p>
      </div>
      <div class="rounded-xl overflow-hidden aspect-[4/3]">
        @php $aboutImg = get_theme_mod('about_history_image'); @endphp
        <img
          src="{{ $aboutImg ?: 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?w=800&auto=format&fit=crop&q=80' }}"
          alt="{{ __('Санаторий QAZAQSTAN Resort — главный корпус', 'qazaqstan') }}"
          loading="lazy" width="800" height="600" class="w-full h-full object-cover">
      </div>
    </div>
  </div>
</section>

{{-- Цифры --}}
@php
  $stats = [
    ['1985', __('год основания', 'qazaqstan')],
    ['40+',  __('лет работы', 'qazaqstan')],
    ['20+',  __('специалистов', 'qazaqstan')],
    ['5',    __('профилей лечения', 'qazaqstan')],
  ];
@endphp
<section class="section bg-off-white" aria-labelledby="stats-heading">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Цифры', 'qazaqstan') }}</p>
      <h2 id="stats-heading" class="h2 mt-4">{{ __('QAZAQSTAN Resort в цифрах', 'qazaqstan') }}</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
      @foreach($stats as [$num, $label])
        <div class="about-stat text-center">
          <span class="about-stat__number block text-center">{{ $num }}</span>
          <span class="about-stat__label text-center block">{{ $label }}</span>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Ценности --}}
@php
  $values = [
    ['blue',  'dashicons-heart',     'Здоровье прежде всего',  'Каждое решение принимается с одной целью — реальная польза для здоровья и самочувствия наших гостей. Никакой косметики, только доказательная медицина.'],
    ['green', 'dashicons-location',  'Природа как лечение',    'Расположение в предгорьях Алатау — не просто красивый вид. Чистый горный воздух, минеральная вода и особый климат усиливают эффект любой процедуры.'],
    ['cyan',  'dashicons-groups',    'Внимание к каждому',     'Индивидуальный подход к каждому гостю. Программа лечения формируется после консультации с врачом, а не по шаблону.'],
  ];
@endphp
<section class="section" id="values" aria-labelledby="values-heading">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Миссия', 'qazaqstan') }}</p>
      <h2 id="values-heading" class="h2 mt-4">{{ __('Наши ценности', 'qazaqstan') }}</h2>
      <p class="section-lead mt-4">{{ __('Три принципа, которые определяют всё, что мы делаем', 'qazaqstan') }}</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($values as [$color, $icon, $title, $text])
        <div class="value-card">
          <div class="value-card__icon value-card__icon--{{ $color }}">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
          </div>
          <h3 class="value-card__title">{{ __($title, 'qazaqstan') }}</h3>
          <p class="value-card__text">{{ __($text, 'qazaqstan') }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Инфраструктура --}}
<section class="section bg-off-white" aria-labelledby="infra-heading">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div class="order-2 lg:order-1">
        <div class="grid grid-cols-2 gap-4">
          @foreach([
            ['https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=500&auto=format&fit=crop&q=80', 'Бассейн'],
            ['https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=500&auto=format&fit=crop&q=80', 'Номер'],
            ['https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=80', 'Тренажёрный зал'],
            ['https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=500&auto=format&fit=crop&q=80', 'Конференц-зал'],
          ] as [$src, $alt])
            <div class="rounded-xl overflow-hidden aspect-[4/3]">
              <img src="{{ $src }}" alt="{{ __($alt, 'qazaqstan') }}" loading="lazy" width="500" height="375" class="w-full h-full object-cover">
            </div>
          @endforeach
        </div>
      </div>
      <div class="order-1 lg:order-2">
        <p class="eyebrow">{{ __('Инфраструктура', 'qazaqstan') }}</p>
        <h2 id="infra-heading" class="h2 mt-4">{{ __('Всё на одной территории', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Единый комплекс на проспекте Достык, 308: лечебный корпус, жилые корпуса, спортивный комплекс, столовая и конференц-залы — всё в шаговой доступности.', 'qazaqstan') }}
        </p>
        <ul class="mt-8 space-y-4">
          @foreach([
            ['Жилые корпуса',       'Три корпуса с номерами категорий Стандарт, Люкс и Президентский Люкс'],
            ['Лечебный корпус',     'Кабинеты физиотерапии, водолечения, массажа, ЛФК и диагностики'],
            ['Спортивный комплекс', 'Бассейн с минеральной водой, тренажёрный зал, сауна'],
            ['Конференц-залы',      'Три зала вместимостью до 150 человек с современным оборудованием'],
          ] as [$title, $desc])
            <li class="flex items-start gap-4">
              <div class="sport-feature__icon flex-shrink-0">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
              </div>
              <div>
                <strong class="font-display font-bold text-charcoal text-[15px]">{{ __($title, 'qazaqstan') }}</strong>
                <p class="text-soft-grey text-[14px] mt-1">{{ __($desc, 'qazaqstan') }}</p>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>

{{-- Награды --}}
@php
  $awards = [
    ['blue',  'Лучший санаторий Алматы',          'По версии рейтинга медицинских учреждений Казахстана, 2023'],
    ['green', 'Благодарственное письмо МВД РК',    'За многолетнее содействие в реабилитации сотрудников органов внутренних дел'],
    ['cyan',  'Сертификат качества СТ РК',         'Соответствие государственному стандарту санаторно-курортных услуг Республики Казахстан'],
    ['blue',  'Рейтинг «5 звёзд» на 2GIS',         'Средняя оценка 4.8 на основе более 600 отзывов пациентов на картах Алматы'],
  ];
@endphp
<section class="section bg-off-white" id="awards" aria-labelledby="awards-heading">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Признание', 'qazaqstan') }}</p>
      <h2 id="awards-heading" class="h2 mt-4">{{ __('Награды и достижения', 'qazaqstan') }}</h2>
      <p class="section-lead mt-4">{{ __('40 лет работы — 40 лет доверия пациентов и профессионального признания', 'qazaqstan') }}</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      @foreach($awards as [$color, $title, $desc])
        <div class="text-center p-6 bg-white border border-warm-grey rounded-xl">
          <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-4" style="background:rgba(56,114,184,0.07);color:var(--klein-blue);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
          </div>
          <p class="font-display font-bold text-charcoal text-[15px]">{{ __($title, 'qazaqstan') }}</p>
          <p class="text-soft-grey text-[13px] mt-1">{{ __($desc, 'qazaqstan') }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Лицензии из CPT document --}}
@php
  $licenses = get_posts([
    'post_type'   => 'document',
    'posts_per_page' => 6,
    'post_status' => 'publish',
    'tax_query'   => [[
      'taxonomy' => 'doc_type',
      'field'    => 'slug',
      'terms'    => 'licenses',
    ]],
  ]);
@endphp
@if(count($licenses))
<section class="section" id="licenses" aria-labelledby="licenses-heading">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Документы', 'qazaqstan') }}</p>
      <h2 id="licenses-heading" class="h2 mt-4">{{ __('Лицензии и сертификаты', 'qazaqstan') }}</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach($licenses as $doc)
        @php $file = qazaqstan_field('document_file', $doc->ID); @endphp
        <div class="flex gap-4 p-5 border border-warm-grey rounded-xl bg-white">
          <div class="w-11 h-11 rounded-[10px] flex items-center justify-center flex-shrink-0" style="background:rgba(56,114,184,0.08);color:var(--klein-blue);">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          </div>
          <div>
            <p class="font-display font-bold text-charcoal text-[14px]">{{ esc_html($doc->post_title) }}</p>
            @if($doc->post_excerpt)
              <p class="text-soft-grey text-[13px] mt-1">{{ esc_html($doc->post_excerpt) }}</p>
            @endif
            @if(!empty($file['url']))
              <a href="{{ esc_url($file['url']) }}" target="_blank" rel="noopener noreferrer" class="text-klein-blue text-[13px] font-bold mt-2 inline-flex items-center gap-1 hover:underline">
                {{ __('Просмотреть', 'qazaqstan') }}
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              </a>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@include('partials.cta-band', [
  'heading' => __('Приезжайте и убедитесь сами', 'qazaqstan'),
  'text'    => __('40 лет опыта, команда врачей и горный воздух Алатау — всё это ждёт вас.', 'qazaqstan'),
])

@endsection

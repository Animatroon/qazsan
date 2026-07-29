@extends('layouts.app')

@section('content')
@php
  $halls = get_posts(['post_type' => 'conference_hall', 'posts_per_page' => -1, 'post_status' => 'publish']);
  $phone = qazaqstan_option('phone_primary') ?: '+7 (727) 264-64-54';
  $email = qazaqstan_option('email') ?: 'info@kazakhstansan.kz';
@endphp

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Конференц-залы', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Корпоративным клиентам', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Конференц-центр в Алматы', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65 text-[17px] leading-[1.6]">
      {{ __('Три современно оснащённых зала для деловых мероприятий, конференций и корпоративного отдыха.', 'qazaqstan') }}
    </p>
    <div class="flex flex-wrap gap-3 mt-8">
      <a href="#halls" class="btn btn--primary btn--lg">{{ __('Выбрать зал', 'qazaqstan') }}</a>
      <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--ghost-white btn--lg">{{ esc_html($phone) }}</a>
    </div>
  </div>
</div>

{{-- Преимущества --}}
<section class="py-16 bg-white">
  <div class="container">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
      @foreach(['до 150 участников' => 'вместимость', '3' => 'зала', 'Wi-Fi' => 'бесплатный', 'кейтеринг' => 'организуем'] as $num => $label)
        <div class="about-stat text-center"><span class="about-stat__number block text-center">{{ $num }}</span><span class="about-stat__label text-center block">{{ __($label, 'qazaqstan') }}</span></div>
      @endforeach
    </div>
  </div>
</section>

{{-- Залы из CPT --}}
<section id="halls" class="section">
  <div class="container">
    <div class="section-header section-header--center mb-14">
      <p class="eyebrow">{{ __('Залы', 'qazaqstan') }}</p>
      <h2 class="h2 mt-4">{{ __('Выберите зал для вашего мероприятия', 'qazaqstan') }}</h2>
    </div>

    @if(count($halls))
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @foreach($halls as $hall)
          @php
            $thumb    = get_the_post_thumbnail_url($hall, 'large');
            $gallery  = qazaqstan_field('hall_gallery', $hall->ID);
            $gallery  = is_array($gallery) ? $gallery : [];
            $img      = $thumb ?: ($gallery[0]['sizes']['large'] ?? $gallery[0]['url'] ?? '');
            $area     = qazaqstan_field('hall_area', $hall->ID);
            $capacity = qazaqstan_field('hall_capacity', $hall->ID);
            $priceH   = (int) qazaqstan_field('hall_price_hour', $hall->ID);
            $priceD   = (int) qazaqstan_field('hall_price_day', $hall->ID);
            $equip    = qazaqstan_field('hall_equipment', $hall->ID);
            $equip    = is_array($equip) ? $equip : [];
          @endphp
          <article class="card">
            @if($img)
              <div class="card__media">
                <img src="{{ esc_url($img) }}" alt="{{ esc_attr($hall->post_title) }}" loading="lazy" width="600" height="400">
              </div>
            @endif
            <div class="card__body">
              <h3 class="card__title">{{ esc_html($hall->post_title) }}</h3>
              @if($hall->post_excerpt)
                <p class="card__text">{{ esc_html($hall->post_excerpt) }}</p>
              @endif
              <div class="flex gap-4 mt-4 text-[14px] text-soft-grey">
                @if($area)<span>{{ $area }} м²</span>@endif
                @if($capacity)<span>· {{ $capacity }} {{ __('чел.', 'qazaqstan') }}</span>@endif
              </div>
              @if($priceH || $priceD)
                <div class="mt-4 p-3 bg-off-white rounded-lg">
                  @if($priceH && $priceH > 0)
                    <p class="text-[13px] text-soft-grey">{{ __('4 часа:', 'qazaqstan') }} <strong class="text-charcoal">{{ number_format($priceH, 0, '.', ' ') }} ₸</strong></p>
                  @endif
                  @if($priceD && $priceD > 0)
                    <p class="text-[13px] text-soft-grey mt-1">{{ __('8 часов:', 'qazaqstan') }} <strong class="text-charcoal">{{ number_format($priceD, 0, '.', ' ') }} ₸</strong></p>
                  @endif
                  @if((!$priceH || $priceH == 0) && (!$priceD || $priceD == 0))
                    <p class="text-[13px] text-soft-grey">{{ __('Цена по запросу', 'qazaqstan') }}</p>
                  @endif
                </div>
              @endif
              @if(count($equip) > 0)
                <div class="mt-4 flex flex-wrap gap-1.5">
                  @foreach(array_slice($equip, 0, 5) as $e)
                    <span class="text-[11px] font-bold uppercase tracking-wider bg-off-white text-soft-grey px-2 py-1 rounded-md">{{ esc_html($e['item']) }}</span>
                  @endforeach
                </div>
              @endif
              <div class="card__actions">
                <a href="{{ qazaqstan_url('/contacts/') }}" class="btn btn--primary">{{ __('Забронировать', 'qazaqstan') }}</a>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    @else
      {{-- Заглушка без данных в БД --}}
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @foreach([
          ['Малый зал', '45 м²', '30 чел.', 'Переговоры, тренинги, семинары'],
          ['Средний зал', '80 м²', '60 чел.', 'Конференции, презентации, мастер-классы'],
          ['Большой зал', '200 м²', '150 чел.', 'Корпоративы, форумы, торжественные мероприятия'],
        ] as [$name, $area, $capacity, $desc])
          <article class="card">
            <div class="card__media bg-warm-grey flex items-center justify-center text-soft-grey text-sm">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            </div>
            <div class="card__body">
              <h3 class="card__title">{{ __($name, 'qazaqstan') }}</h3>
              <p class="card__text">{{ __($desc, 'qazaqstan') }}</p>
              <div class="flex gap-4 mt-3 text-[14px] text-soft-grey">
                <span>{{ $area }}</span><span>·</span><span>{{ $capacity }}</span>
              </div>
              <div class="mt-4 p-3 bg-off-white rounded-lg">
                <p class="text-[13px] text-soft-grey">{{ __('Цена по запросу', 'qazaqstan') }}</p>
              </div>
              <div class="card__actions">
                <a href="{{ qazaqstan_url('/contacts/') }}" class="btn btn--primary">{{ __('Запросить цену', 'qazaqstan') }}</a>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    @endif
  </div>
</section>

{{-- Оснащение --}}
<section class="section bg-white">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div>
        <p class="eyebrow">{{ __('Технологии', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ __('Всё для продуктивной работы', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Современные залы оснащены всем необходимым для проведения деловых мероприятий любого формата.', 'qazaqstan') }}
        </p>
        <div class="mt-8 grid grid-cols-2 gap-3">
          @foreach(['Проектор и экран', 'Флипчарт', 'Скоростной Wi-Fi', 'Звуковое оборудование', 'Видеоконференцсвязь', 'Кейтеринг', 'Трансфер для участников', 'Парковка'] as $feat)
            <div class="flex gap-2 items-center text-[15px] text-charcoal">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--klein-blue)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
              {{ __($feat, 'qazaqstan') }}
            </div>
          @endforeach
        </div>
      </div>
      <div class="p-8 bg-off-white rounded-xl">
        <p class="eyebrow mb-3">{{ __('Запросить предложение', 'qazaqstan') }}</p>
        <h3 class="h3">{{ __('Расскажите о вашем мероприятии', 'qazaqstan') }}</h3>
        <p class="text-soft-grey text-[15px] mt-3 mb-6">{{ __('Позвоните или напишите — подготовим коммерческое предложение в течение часа.', 'qazaqstan') }}</p>
        <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--primary w-full justify-center">{{ esc_html($phone) }}</a>
        @if($email)
          <a href="mailto:{{ esc_attr($email) }}" class="btn btn--secondary w-full justify-center mt-3">{{ esc_html($email) }}</a>
        @endif
        <a href="{{ qazaqstan_url('/contacts/') }}" class="btn btn--ghost w-full justify-center mt-3">{{ __('Написать через форму', 'qazaqstan') }}</a>
      </div>
    </div>
  </div>
</section>

@include('partials.cta-band', [
  'heading' => __('Проведите мероприятие у нас', 'qazaqstan'),
  'text'    => __('Бронирование залов, кейтеринг, размещение участников — организуем всё под ключ.', 'qazaqstan'),
])

@endsection

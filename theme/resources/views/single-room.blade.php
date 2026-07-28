@extends('layouts.app')

@section('content')
@php
  $post        = get_queried_object();
  $priceSingle = (int) qazaqstan_field('room_price_single', $post->ID);
  $priceDouble = (int) qazaqstan_field('room_price_double', $post->ID);
  $area        = qazaqstan_field('room_area', $post->ID);
  $capacity    = qazaqstan_field('room_capacity', $post->ID);
  $floor       = qazaqstan_field('room_floor', $post->ID);
  $gallery     = qazaqstan_field('room_gallery', $post->ID);
  $gallery     = is_array($gallery) ? $gallery : [];
  $includes    = qazaqstan_field('room_includes', $post->ID);
  $includes    = is_array($includes) ? $includes : [];
  $typeTerms   = wp_get_post_terms($post->ID, 'room_type');
  $typeName    = (!is_wp_error($typeTerms) && count($typeTerms)) ? $typeTerms[0]->name : '';
  $amenities   = wp_get_post_terms($post->ID, 'amenity');
  $pkgItems    = qazaqstan_option('package_includes') ?: [
    ['item' => '5-разовое питание'], ['item' => 'Бассейн с минеральной водой'], ['item' => 'Сауна'],
    ['item' => 'Консультации 6 врачей'], ['item' => 'Лечебные процедуры'], ['item' => 'Массаж и ЛФК'],
    ['item' => 'Фитобар'], ['item' => 'Кислородный коктейль'], ['item' => 'Озокеритовые аппликации'], ['item' => 'Диетотерапия'],
  ];
  $otherRooms = get_posts([
    'post_type' => 'room', 'posts_per_page' => 3, 'post_status' => 'publish',
    'post__not_in' => [$post->ID], 'orderby' => 'rand',
  ]);
  $discounts = qazaqstan_option('discounts') ?: [
    ['label' => 'семьи погибших сотрудников МВД', 'percent' => 50],
    ['label' => 'пенсионеры МВД', 'percent' => 30],
    ['label' => 'сотрудники МВД', 'percent' => 30],
    ['label' => 'пенсионеры',     'percent' => 10],
  ];
  $phone = qazaqstan_option('phone_primary') ?: '+7 (727) 264-64-54';
@endphp

<div class="pt-[136px] pb-2 bg-off-white border-b border-warm-grey">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [
      ['label' => __('Проживание', 'qazaqstan'), 'url' => home_url('/accommodation/')],
      ['label' => $post->post_title],
    ]])
  </div>
</div>

<section class="section" aria-labelledby="room-heading">
  <div class="container">
    <div class="room-detail-layout">

      {{-- Левая: галерея + описание --}}
      <div>
        <div class="mb-8">
          <div class="flex items-center gap-3 mb-3">
            @if($typeName)
              <span class="inline-block px-3 py-1 bg-klein-blue text-white rounded-full font-display font-bold text-[11px] tracking-widest uppercase">{{ esc_html($typeName) }}</span>
            @endif
            @if($floor)
              <span class="inline-flex items-center gap-1 text-soft-grey text-[13px]">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                {{ sprintf(__('Этаж %s', 'qazaqstan'), $floor) }}
              </span>
            @endif
          </div>
          <h1 id="room-heading" class="h2">{{ esc_html($post->post_title) }}</h1>
          @if($post->post_excerpt)
            <p class="mt-3 text-soft-grey text-[17px] leading-[1.65]">{{ esc_html($post->post_excerpt) }}</p>
          @endif
        </div>

        {{-- Галерея --}}
        @if(count($gallery))
          <div class="room-gallery mb-10" id="roomGallery">
            <div class="room-gallery__main" id="galleryMain">
              <img id="galleryMainImg"
                src="{{ esc_url($gallery[0]['sizes']['large'] ?? $gallery[0]['url']) }}"
                alt="{{ esc_attr($post->post_title) }}" width="900" height="506">
              @if(count($gallery) > 1)
                <div class="room-gallery__nav">
                  <button class="room-gallery__btn" id="galleryPrev" aria-label="{{ __('Предыдущее фото', 'qazaqstan') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                  </button>
                  <button class="room-gallery__btn" id="galleryNext" aria-label="{{ __('Следующее фото', 'qazaqstan') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
                  </button>
                </div>
              @endif
            </div>
            @if(count($gallery) > 1)
              <div class="room-gallery__thumbs" id="galleryThumbs">
                @foreach($gallery as $i => $img)
                  <div class="room-gallery__thumb {{ $i === 0 ? 'room-gallery__thumb--active' : '' }}"
                    data-img="{{ esc_url($img['sizes']['large'] ?? $img['url']) }}"
                    data-alt="{{ esc_attr($img['alt'] ?? $post->post_title) }}">
                    <img src="{{ esc_url($img['sizes']['medium'] ?? $img['url']) }}" alt="{{ esc_attr($img['alt'] ?? '') }}" loading="lazy" width="300" height="225">
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        @else
          {{-- нет фото --}}
          <div class="room-gallery mb-10 bg-warm-grey rounded-xl h-64 flex items-center justify-center text-soft-grey">
            {{ __('Фотографии добавляются', 'qazaqstan') }}
          </div>
        @endif

        {{-- Характеристики --}}
        @if($area || $capacity)
          <div class="mb-10">
            <h2 class="h3 mb-6">{{ __('Характеристики номера', 'qazaqstan') }}</h2>
            <div class="room-specs-grid">
              @if($area)
                <div class="room-spec-box">
                  <div class="room-spec-box__value">{{ $area }}</div>
                  <div class="room-spec-box__label">{{ __('м² площадь', 'qazaqstan') }}</div>
                </div>
              @endif
              @if($capacity)
                <div class="room-spec-box">
                  <div class="room-spec-box__value">{{ $capacity }}</div>
                  <div class="room-spec-box__label">{{ __('гостей', 'qazaqstan') }}</div>
                </div>
              @endif
              @if($floor)
                <div class="room-spec-box">
                  <div class="room-spec-box__value">{{ $floor }}</div>
                  <div class="room-spec-box__label">{{ __('этаж', 'qazaqstan') }}</div>
                </div>
              @endif
            </div>
          </div>
        @endif

        {{-- Удобства (таксономия) --}}
        @if(!is_wp_error($amenities) && count($amenities))
          <div class="mb-10">
            <h2 class="h3 mb-6">{{ __('Удобства в номере', 'qazaqstan') }}</h2>
            <div class="room-amenity-grid">
              @foreach($amenities as $am)
                <div class="room-amenity-item">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                  {{ esc_html($am->name) }}
                </div>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Включено в путёвку --}}
        <div class="mb-10">
          <h2 class="h3 mb-2">{{ __('Включено в стоимость путёвки', 'qazaqstan') }}</h2>
          <p class="text-soft-grey mb-6 text-[15px]">{{ __('Все эти услуги входят без дополнительной оплаты', 'qazaqstan') }}</p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            @foreach($pkgItems as $pkg)
              <div class="flex items-center gap-2.5 p-3.5 border border-warm-grey rounded-xl text-charcoal text-[14px]">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--may-green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                {{ esc_html($pkg['item']) }}
              </div>
            @endforeach
          </div>
        </div>

        {{-- Описание из редактора --}}
        @if($post->post_content)
          <div class="prose prose-lg max-w-none mb-10">
            {!! apply_filters('the_content', $post->post_content) !!}
          </div>
        @endif

        {{-- Другие номера --}}
        @if(count($otherRooms))
          <div class="mt-12">
            <h2 class="h3 mb-6">{{ __('Другие категории номеров', 'qazaqstan') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              @foreach($otherRooms as $other)
                @php
                  $otherImg   = get_the_post_thumbnail_url($other, 'thumbnail') ?: '';
                  $otherGal   = qazaqstan_field('room_gallery', $other->ID);
                  $otherThumb = $otherImg ?: (is_array($otherGal) ? ($otherGal[0]['sizes']['thumbnail'] ?? $otherGal[0]['url'] ?? '') : '');
                  $otherPrice = (int) qazaqstan_field('room_price_single', $other->ID);
                  $otherArea  = qazaqstan_field('room_area', $other->ID);
                @endphp
                <a href="{{ get_permalink($other) }}" class="flex gap-4 items-center p-4 border border-warm-grey rounded-2xl hover:border-klein-blue transition-colors no-underline">
                  <div class="w-20 h-16 rounded-[10px] overflow-hidden flex-shrink-0 bg-warm-grey">
                    @if($otherThumb)
                      <img src="{{ esc_url($otherThumb) }}" alt="{{ esc_attr($other->post_title) }}" width="160" height="128" loading="lazy" class="w-full h-full object-cover">
                    @endif
                  </div>
                  <div>
                    <p class="font-display font-bold text-charcoal text-[15px]">{{ esc_html($other->post_title) }}</p>
                    <p class="text-soft-grey text-[13px]">{{ $otherArea ? $otherArea . ' м² · ' : '' }}{{ $otherPrice ? __('от', 'qazaqstan') . ' ' . number_format($otherPrice, 0, '.', ' ') . ' ₸/сут.' : '' }}</p>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        @endif
      </div>

      {{-- Правая: прайс-карточка --}}
      <div>
        <div class="room-price-card">
          <div class="room-price-card__head">
            <p class="room-price-card__type">{{ esc_html($post->post_title) }}</p>
            @if($priceSingle)
              <p class="room-price-card__price">{{ number_format($priceSingle, 0, '.', ' ') }} ₸</p>
              <p class="room-price-card__unit">{{ __('за сутки с человека', 'qazaqstan') }}</p>
            @endif
          </div>
          <div class="room-price-card__body">
            @if($priceSingle)
              <div>
                <p class="font-display font-bold text-[13px] text-charcoal mb-2.5">{{ __('Выберите срок путёвки', 'qazaqstan') }}</p>
                <div class="room-duration-grid" id="durationGrid">
                  @foreach([7, 10, 14, 21] as $days)
                    <button class="room-duration-btn {{ $days === 10 ? 'room-duration-btn--active' : '' }}"
                      data-days="{{ $days }}" data-price="{{ $priceSingle * $days }}" type="button">
                      {{ $days }} {{ __('дней', 'qazaqstan') }}
                    </button>
                  @endforeach
                </div>
              </div>
              <div class="room-total-row">
                <div>
                  <p class="room-total-label">{{ __('Итого за путёвку', 'qazaqstan') }}</p>
                  <p class="text-[12px] text-soft-grey">{{ __('питание + процедуры включены', 'qazaqstan') }}</p>
                </div>
                <p class="room-total-value" id="totalPrice">{{ number_format($priceSingle * 10, 0, '.', ' ') }} ₸</p>
              </div>
            @endif

            @php $discountText = collect($discounts)->map(fn($d) => esc_html($d['label']) . ' —' . $d['percent'] . '%')->implode(', '); @endphp
            @if($discountText)
              <div class="p-3.5 bg-may-green/10 border border-may-green/20 rounded-[10px]">
                <p class="text-charcoal text-[13px] leading-relaxed">
                  <strong>{{ __('Скидки:', 'qazaqstan') }}</strong> {{ $discountText }}
                </p>
              </div>
            @endif

            <a href="{{ home_url('/booking/?room=' . $post->ID) }}" class="btn btn--primary w-full justify-center">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              {{ __('Забронировать', 'qazaqstan') }}
            </a>
            <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--outline w-full justify-center">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.43a2 2 0 0 1 1.99-2.18h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.91A16 16 0 0 0 14.09 16l1.04-.95a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              {{ esc_html($phone) }}
            </a>

            @if($priceSingle)
              <div class="border border-warm-grey rounded-xl overflow-hidden">
                <div class="px-4 py-3 bg-off-white border-b border-warm-grey">
                  <p class="font-display font-bold text-[12px] text-charcoal uppercase tracking-[0.05em]">{{ __('Прайс-лист на 2026 год', 'qazaqstan') }}</p>
                </div>
                <table class="w-full text-[13px] border-collapse">
                  <thead>
                    <tr class="bg-off-white">
                      <th class="px-4 py-2 text-left text-soft-grey font-bold text-[11px] uppercase tracking-[0.05em] border-b border-warm-grey">{{ __('Срок', 'qazaqstan') }}</th>
                      <th class="px-4 py-2 text-right text-soft-grey font-bold text-[11px] uppercase tracking-[0.05em] border-b border-warm-grey">{{ __('Сумма', 'qazaqstan') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach([7, 10, 14, 21] as $i => $days)
                      <tr class="{{ $i < 3 ? 'border-b border-warm-grey' : '' }} {{ $days === 10 ? 'bg-klein-blue/5' : '' }}">
                        <td class="px-4 py-2.5 text-charcoal">{{ $days }} {{ __('дней', 'qazaqstan') }}</td>
                        <td class="px-4 py-2.5 text-right font-bold text-klein-blue">{{ number_format($priceSingle * $days, 0, '.', ' ') }} ₸</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
(function () {
  const grid = document.getElementById('durationGrid');
  const total = document.getElementById('totalPrice');
  if (!grid || !total) return;
  grid.addEventListener('click', function (e) {
    const btn = e.target.closest('.room-duration-btn');
    if (!btn) return;
    grid.querySelectorAll('.room-duration-btn').forEach(b => b.classList.remove('room-duration-btn--active'));
    btn.classList.add('room-duration-btn--active');
    const price = parseInt(btn.dataset.price, 10);
    total.textContent = price.toLocaleString('ru-RU') + ' ₸';
  });

  const mainImg = document.getElementById('galleryMainImg');
  const thumbs = document.querySelectorAll('.room-gallery__thumb');
  const prev = document.getElementById('galleryPrev');
  const next = document.getElementById('galleryNext');
  if (!mainImg || !thumbs.length) return;

  const photos = Array.from(thumbs).map(t => ({ src: t.dataset.img, alt: t.dataset.alt }));
  let current = 0;

  function show(idx) {
    current = (idx + photos.length) % photos.length;
    mainImg.src = photos[current].src;
    mainImg.alt = photos[current].alt;
    thumbs.forEach((t, i) => t.classList.toggle('room-gallery__thumb--active', i === current));
  }

  thumbs.forEach((t, i) => t.addEventListener('click', () => show(i)));
  prev?.addEventListener('click', () => show(current - 1));
  next?.addEventListener('click', () => show(current + 1));
})();
</script>

@endsection

@php
  $thumb        = get_the_post_thumbnail_url($room, 'large') ?: '';
  $gallery      = qazaqstan_field('room_gallery', $room->ID);
  $img          = $thumb ?: (is_array($gallery) ? ($gallery[0]['sizes']['large'] ?? $gallery[0]['url'] ?? '') : '');
  $priceSingle  = (int) qazaqstan_field('room_price_single', $room->ID);
  $priceDouble  = (int) qazaqstan_field('room_price_double', $room->ID);
  $area         = qazaqstan_field('room_area', $room->ID);
  $capacity     = qazaqstan_field('room_capacity', $room->ID);
  $typeTerms    = wp_get_post_terms($room->ID, 'room_type');
  $typeName     = (!is_wp_error($typeTerms) && count($typeTerms)) ? $typeTerms[0]->name : '';
  $amenities    = wp_get_post_terms($room->ID, 'amenity');
@endphp
<article class="card">
  <a href="{{ get_permalink($room) }}" class="card__media block" aria-label="{{ esc_attr($room->post_title) }}">
    @if($img)
      <img src="{{ esc_url($img) }}" alt="{{ esc_attr($room->post_title) }} — QAZAQSTAN Resort" loading="lazy" width="600" height="400" class="w-full h-full object-cover">
    @else
      <div class="w-full h-full bg-warm-grey flex items-center justify-center text-soft-grey text-sm">{{ __('Фото скоро', 'qazaqstan') }}</div>
    @endif
  </a>
  <div class="card__body">
    @if($typeName)<span class="card__eyebrow">{{ esc_html($typeName) }}</span>@endif
    <h3 class="card__title"><a href="{{ get_permalink($room) }}" class="hover:text-klein-blue transition-colors">{{ esc_html($room->post_title) }}</a></h3>

    @php
      $specs = [];
      if ($area)     $specs[] = $area . ' м²';
      if ($capacity) $specs[] = $capacity . ' ' . __('гост.', 'qazaqstan');
    @endphp
    @if(count($specs))
      <p class="text-soft-grey text-[13px] mt-2">{{ implode(' · ', $specs) }}</p>
    @endif

    @if($priceSingle || $priceDouble)
      <div class="mt-4 flex items-baseline gap-2 flex-wrap">
        @if($priceSingle)
          <div class="pricing-card__price">
            <span class="pricing-card__from">{{ __('от', 'qazaqstan') }}</span>
            <span class="pricing-card__amount">{{ number_format($priceSingle, 0, '.', ' ') }}</span>
            <span class="pricing-card__unit">₸&nbsp;/&nbsp;{{ __('сут.', 'qazaqstan') }}</span>
          </div>
        @endif
      </div>
    @endif

    @if(!is_wp_error($amenities) && count($amenities))
      <div class="mt-3 flex flex-wrap gap-1.5">
        @foreach(array_slice($amenities, 0, 4) as $am)
          <span class="text-[11px] font-bold uppercase tracking-wider bg-off-white text-soft-grey px-2 py-1 rounded-md">{{ esc_html($am->name) }}</span>
        @endforeach
      </div>
    @endif

    <div class="card__actions">
      <a href="{{ get_permalink($room) }}" class="btn btn--primary">{{ __('Подробнее', 'qazaqstan') }}</a>
      <a href="{{ home_url('/booking/') }}" class="btn btn--secondary">{{ __('Забронировать', 'qazaqstan') }}</a>
    </div>
  </div>
</article>

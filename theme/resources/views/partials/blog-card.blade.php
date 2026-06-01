@php
  $thumb = get_the_post_thumbnail_url($post, 'medium_large');
  $cats  = get_the_category($post->ID);
@endphp
<article class="card">
  @if($thumb)
    <a href="{{ get_permalink($post) }}" class="card__media block" tabindex="-1" aria-hidden="true">
      <img src="{{ esc_url($thumb) }}" alt="{{ esc_attr($post->post_title) }}" loading="lazy" width="600" height="360">
    </a>
  @endif
  <div class="card__body">
    @if(count($cats))
      <span class="card__eyebrow">{{ esc_html($cats[0]->name) }}</span>
    @endif
    <h3 class="card__title mt-2">
      <a href="{{ get_permalink($post) }}" class="hover:text-klein-blue transition-colors">{{ esc_html($post->post_title) }}</a>
    </h3>
    @if($post->post_excerpt)
      <p class="card__text line-clamp-3">{{ esc_html($post->post_excerpt) }}</p>
    @endif
    <div class="flex items-center justify-between mt-5 text-soft-grey text-[13px]">
      <span>{{ get_the_date('d.m.Y', $post) }}</span>
      <a href="{{ get_permalink($post) }}" class="text-klein-blue font-bold hover:underline">{{ __('Читать →', 'qazaqstan') }}</a>
    </div>
  </div>
</article>

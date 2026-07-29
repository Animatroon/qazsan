@php
  $thumb    = get_the_post_thumbnail_url($post, 'medium_large');
  $cats     = get_the_category($post->ID);
  $category = count($cats) ? $cats[0] : null;
  $variant  = $category && str_contains($category->slug, 'news') ? 'nature' : 'water';
@endphp
<article class="blog-card">
  <a href="{{ get_permalink($post) }}" class="blog-card__media" tabindex="-1" aria-hidden="true">
    @if($thumb)
      <img src="{{ esc_url($thumb) }}" alt="{{ esc_attr($post->post_title) }}" loading="lazy" width="600" height="360">
    @else
      <span class="blog-card__placeholder blog-card__placeholder--{{ $variant }}">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
        </svg>
      </span>
    @endif
    @if($category)
      <span class="blog-card__badge blog-card__badge--{{ $variant }}">{{ esc_html($category->name) }}</span>
    @endif
  </a>
  <div class="blog-card__body">
    <time class="blog-card__date" datetime="{{ get_the_date('c', $post) }}">{{ get_the_date('j F Y', $post) }}</time>
    <h3 class="blog-card__title">
      <a href="{{ get_permalink($post) }}">{{ esc_html($post->post_title) }}</a>
    </h3>
    @if($post->post_excerpt)
      <p class="blog-card__text">{{ esc_html($post->post_excerpt) }}</p>
    @endif
    <a href="{{ get_permalink($post) }}" class="blog-card__link">
      {{ __('Читать', 'qazaqstan') }}
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
  </div>
</article>

@extends('layouts.app')

@section('content')
@php
  $galleryCategories = ['Территория', 'Номера', 'Бассейн и спорт', 'Процедуры', 'Конференц-залы', 'Мероприятия'];
  $galleryItems = qazaqstan_field('gallery_items');
  $galleryItems = is_array($galleryItems) ? $galleryItems : [];
@endphp

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Галерея', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Фотогалерея', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Галерея', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65 text-[17px] leading-[1.6]">
      {{ __('Территория, номера, процедурные кабинеты и жизнь санатория.', 'qazaqstan') }}
    </p>
  </div>
</div>

<section class="section" id="photos">
  <div class="container">
    @if(count($galleryItems))
      {{-- Фильтр по категориям --}}
      <div class="flex flex-wrap gap-2 mb-10" id="galleryFilter" role="tablist">
        <button class="badge badge--active" data-filter="all" role="tab" aria-selected="true" type="button">{{ __('Все', 'qazaqstan') }}</button>
        @foreach($galleryCategories as $cat)
          <button class="badge badge--outline" data-filter="{{ Str::slug($cat) }}" role="tab" aria-selected="false" type="button">{{ __($cat, 'qazaqstan') }}</button>
        @endforeach
      </div>

      {{-- Сетка --}}
      <div class="gallery-masonry" id="galleryGrid">
        @foreach($galleryItems as $item)
          @php
            $photo    = $item['photo'] ?? [];
            $imgUrl   = $photo['sizes']['large'] ?? $photo['url'] ?? '';
            $caption  = $item['caption'] ?? '';
            $category = $item['category'] ?? '';
            $catSlug  = $category ? Str::slug($category) : 'all';
          @endphp
          @if($imgUrl)
            <div class="gallery-item" data-category="{{ $catSlug }}">
              <a href="{{ esc_url($imgUrl) }}" class="gallery-item__link" data-lightbox="gallery" data-alt="{{ esc_attr($caption) }}">
                <img src="{{ esc_url($imgUrl) }}" alt="{{ esc_attr($caption ?: $category) }}" loading="lazy" width="600" height="450" class="gallery-item__img">
                <div class="gallery-item__overlay">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                </div>
              </a>
            </div>
          @endif
        @endforeach
      </div>
    @else
      <div class="gallery-empty">
        <div class="gallery-empty__icon" aria-hidden="true">
          <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
        </div>
        <h2 class="h3 mt-6">{{ __('Галерея пока пуста', 'qazaqstan') }}</h2>
        <p class="text-soft-grey text-[16px] mt-3 max-w-md mx-auto">
          {{ __('Реальные фотографии территории, номеров и процедур появятся здесь в ближайшее время.', 'qazaqstan') }}
        </p>
      </div>
    @endif
  </div>
</section>

@include('partials.cta-band', [
  'heading' => __('Почувствуйте это сами', 'qazaqstan'),
  'text'    => __('Фотографии передают лишь малую часть. Приезжайте — ощутите атмосферу вживую.', 'qazaqstan'),
])

<script>
(function () {
  const filter = document.getElementById('galleryFilter');
  const items  = document.querySelectorAll('.gallery-item');
  if (!filter) return;
  filter.addEventListener('click', e => {
    const btn = e.target.closest('button[data-filter]');
    if (!btn) return;
    filter.querySelectorAll('button').forEach(b => {
      b.classList.remove('badge--active');
      b.classList.add('badge--outline');
      b.setAttribute('aria-selected', 'false');
    });
    btn.classList.add('badge--active');
    btn.classList.remove('badge--outline');
    btn.setAttribute('aria-selected', 'true');
    const f = btn.dataset.filter;
    items.forEach(item => {
      item.style.display = (f === 'all' || item.dataset.category === f) ? '' : 'none';
    });
  });
})();
</script>

@endsection

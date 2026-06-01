@extends('layouts.app')

@section('content')
@php
  $galleryCategories = ['Территория', 'Номера', 'Бассейн и спорт', 'Процедуры', 'Конференц-залы', 'Мероприятия'];
  $acfGallery = qazaqstan_field('gallery_items', get_option('page_on_front'));
@endphp

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Галерея', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Фотогалерея', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Галерея', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65" style="font-size:17px;line-height:1.6;">
      {{ __('Территория, номера, процедурные кабинеты и жизнь санатория.', 'qazaqstan') }}
    </p>
  </div>
</div>

<section class="section" id="photos">
  <div class="container">
    {{-- Фильтр по категориям --}}
    <div class="flex flex-wrap gap-2 mb-10" id="galleryFilter" role="tablist">
      <button class="badge badge--active" data-filter="all" role="tab" aria-selected="true" type="button">{{ __('Все', 'qazaqstan') }}</button>
      @foreach($galleryCategories as $cat)
        <button class="badge badge--outline" data-filter="{{ Str::slug($cat) }}" role="tab" aria-selected="false" type="button">{{ __($cat, 'qazaqstan') }}</button>
      @endforeach
    </div>

    {{-- Сетка --}}
    <div class="gallery-masonry" id="galleryGrid">
      @php
        $placeholders = [
          ['https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&auto=format&fit=crop&q=80',  'Территория',    'Предгорья Алатау — вид из санатория'],
          ['https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=800&auto=format&fit=crop&q=80',  'Бассейн и спорт','Бассейн с минеральной водой'],
          ['https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&auto=format&fit=crop&q=80',  'Номера',        'Стандартный номер'],
          ['https://images.unsplash.com/photo-1584132967334-10e028bd69f7?w=800&auto=format&fit=crop&q=80',  'Процедуры',     'Лечебные процедуры'],
          ['https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&auto=format&fit=crop&q=80',  'Конференц-залы','Конференц-зал'],
          ['https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&auto=format&fit=crop&q=80',  'Процедуры',     'СПА-процедуры'],
          ['https://images.unsplash.com/photo-1631049552240-59c37f38802b?w=800&auto=format&fit=crop&q=80',  'Номера',        'Номер Люкс'],
          ['https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&auto=format&fit=crop&q=80',  'Бассейн и спорт','Тренажёрный зал'],
          ['https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&auto=format&fit=crop&q=80',     'Бассейн и спорт','Сауна'],
          ['https://images.unsplash.com/photo-1561501878-aabd62634533?w=800&auto=format&fit=crop&q=80',     'Территория',    'Интерьер санатория'],
          ['https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800&auto=format&fit=crop&q=80',  'Номера',        'Президентский люкс'],
          ['https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&auto=format&fit=crop&q=80',  'Территория',    'Природа Алатау'],
        ];
      @endphp
      @foreach($placeholders as $ph)
        @php $catSlug = \Illuminate\Support\Str::slug($ph[1]); @endphp
        <div class="gallery-item" data-category="{{ $catSlug }}">
          <a href="{{ $ph[0] }}" class="gallery-item__link" data-lightbox="gallery" data-alt="{{ esc_attr($ph[2]) }}">
            <img src="{{ $ph[0] }}" alt="{{ esc_attr($ph[2]) }}" loading="lazy" width="600" height="450" class="gallery-item__img">
            <div class="gallery-item__overlay">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
            </div>
          </a>
        </div>
      @endforeach
    </div>
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

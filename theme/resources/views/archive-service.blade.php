@extends('layouts.app')

@section('content')
@php
  $services = get_posts(['post_type' => 'service', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC']);
  $pkgItems = qazaqstan_option('package_includes') ?: [
    ['item' => 'Проживание'], ['item' => '5-разовое питание'], ['item' => 'Консультации 6 специалистов'],
    ['item' => 'Бассейн с минеральной водой'], ['item' => 'Сауна'], ['item' => 'Массаж'], ['item' => 'ЛФК'],
    ['item' => 'Фитобар'], ['item' => 'Кислородный коктейль'], ['item' => 'Озокеритовые аппликации'],
    ['item' => 'Диетотерапия'], ['item' => 'УЗТ, СМТ, УВЧ, ингаляции'], ['item' => 'Душ Шарко, Виши'],
    ['item' => 'Электромагнитотерапия'], ['item' => 'УФО'], ['item' => 'Минеральные ванны'],
  ];
@endphp

<div class="page-hero page-hero--light">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Услуги', 'qazaqstan')]]])
    <p class="eyebrow">{{ __('Что мы предлагаем', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3">{{ __('Дополнительные услуги', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-soft-grey" style="font-size:17px;line-height:1.6;">
      {{ __('Широкий спектр медицинских и оздоровительных услуг. Часть из них включена в путёвку.', 'qazaqstan') }}
    </p>
  </div>
</div>

{{-- Каталог услуг --}}
<section class="section" id="catalog">
  <div class="container">
    @if(count($services))
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($services as $svc)
          @php
            $thumb = get_the_post_thumbnail_url($svc, 'medium_large');
            $price = qazaqstan_field('service_price', $svc->ID);
          @endphp
          <article class="card">
            @if($thumb)
              <div class="card__media">
                <img src="{{ esc_url($thumb) }}" alt="{{ esc_attr($svc->post_title) }}" loading="lazy" width="600" height="380">
              </div>
            @endif
            <div class="card__body">
              <h3 class="card__title">{{ esc_html($svc->post_title) }}</h3>
              @if($svc->post_excerpt)
                <p class="card__text">{{ esc_html($svc->post_excerpt) }}</p>
              @endif
              @if($price)
                <p class="mt-3 font-display font-bold text-[18px] text-klein-blue">{{ esc_html($price) }}</p>
              @else
                <p class="mt-3 text-[14px] text-soft-grey">{{ __('Включено в путёвку', 'qazaqstan') }}</p>
              @endif
            </div>
          </article>
        @endforeach
      </div>
    @else
      {{-- Заглушка из прототипа --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach([
          ['Массаж', 'Классический, лечебный, рефлекторно-сегментарный. Назначается врачом.', true],
          ['Физиотерапия', 'УЗТ, СМТ, УВЧ, магнитотерапия, лазеротерапия, электрофорез.', true],
          ['Бальнеотерапия', 'Минеральные ванны, радоновые ванны, жемчужные ванны.', true],
          ['Водолечение', 'Душ Шарко, душ Виши, циркулярный, восходящий душ.', true],
          ['Озокеритовые аппликации', 'Тепловые аппликации на суставы и позвоночник.', true],
          ['Ингаляции', 'Медикаментозные, щелочные, масляные, с минеральной водой.', true],
          ['Диетотерапия', 'Индивидуальное лечебное питание под руководством диетолога.', true],
          ['Фитотерапия', 'Фитобар с лечебными травяными сборами, кислородный коктейль.', true],
          ['ЛФК', 'Лечебная физкультура — групповые и индивидуальные занятия.', true],
        ] as [$title, $desc, $included])
          <article class="card p-6">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background:rgba(56,114,184,0.08);color:var(--klein-blue);">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h3 class="card__title">{{ __($title, 'qazaqstan') }}</h3>
            <p class="card__text">{{ __($desc, 'qazaqstan') }}</p>
            @if($included)
              <p class="mt-3 text-[13px] font-bold text-may-green">{{ __('✓ Включено в путёвку', 'qazaqstan') }}</p>
            @endif
          </article>
        @endforeach
      </div>
    @endif
  </div>
</section>

{{-- Что включено --}}
<section class="section bg-white">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div>
        <p class="eyebrow">{{ __('Путёвка', 'qazaqstan') }}</p>
        <h2 class="h2 mt-4">{{ count($pkgItems) }}+ {{ __('процедур каждый день', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Всё это входит в стоимость путёвки без доплат. Назначение конкретных процедур — по итогам консультации с врачом.', 'qazaqstan') }}
        </p>
      </div>
      <div class="grid grid-cols-2 gap-2.5">
        @foreach($pkgItems as $item)
          <div class="flex gap-2 items-center text-charcoal text-[14px]">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--may-green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            {{ esc_html($item['item']) }}
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

@include('partials.cta-band', ['heading' => __('Начните курс лечения', 'qazaqstan')])

@endsection

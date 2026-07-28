@extends('layouts.app')

@section('content')

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Лечение', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Лечение', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Санаторно-курортное лечение и оздоровление', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65 text-[17px] leading-[1.6]">
      {{ __('5 профилей лечения, более 15 видов процедур. Программа составляется врачом после первичной консультации.', 'qazaqstan') }}
    </p>
  </div>
</div>

{{-- Навигация по профилям --}}
@php
  $profiles = get_terms(['taxonomy' => 'medical_profile', 'hide_empty' => false]);
  $profileFallback = [
    ['musculoskeletal', 'Опорно-двигательный аппарат', 'Артриты, остеохондроз, реабилитация после травм и операций на суставах.', [
      'Массаж (ручной и аппаратный)', 'Озокеритовые аппликации', 'Электромагнитотерапия',
      'СМТ-терапия', 'УЗТ (ультразвуковая терапия)', 'Грязевые аппликации',
      'Минеральные ванны', 'ЛФК индивидуальные', 'ЛФК групповые', 'Тракционная терапия',
    ]],
    ['respiratory', 'Органы дыхания', 'Бронхиты, астма, ХОБЛ, хронические ларингиты и синуситы.', [
      'Ингаляции (медикаментозные, щелочные)', 'УФО (ультрафиолетовое облучение)', 'Электрофорез',
      'Галотерапия', 'Климатолечение', 'ЛФК дыхательная', 'Массаж грудной клетки',
    ]],
    ['cardiovascular', 'Сердечно-сосудистая система', 'Гипертония, ИБС, атеросклероз, нарушения кровообращения.', [
      'Минеральные ванны', 'Радоновые ванны', 'Электромагнитотерапия',
      'Лазеротерапия', 'Климатолечение', 'ЛФК кардиологическая', 'Диетотерапия',
    ]],
    ['nervous-system', 'Нервная система', 'Неврозы, нарушения сна, стрессовые состояния, остеохондроз с неврологическими проявлениями.', [
      'Массаж (общий, рефлекторно-сегментарный)', 'Иглорефлексотерапия', 'Дарсонвализация',
      'Электросон', 'Водолечение', 'ЛФК', 'Ароматерапия',
    ]],
    ['urology-gynecology', 'Урология и гинекология', 'Хронические воспалительные заболевания, нарушения обмена веществ.', [
      'Радоновые ванны', 'Минеральные ванны', 'Физиотерапия (магнит, лазер)',
      'Подводный душ-массаж', 'Восходящий душ', 'Диетотерапия',
    ]],
  ];
@endphp

@if(!is_wp_error($profiles) && count($profiles))
  <div class="sticky top-20 z-sticky profile-nav-wrap" id="profile-tabs-nav">
    <div class="container">
      <div class="profile-nav" role="tablist" aria-label="{{ __('Профили лечения', 'qazaqstan') }}">
        @foreach($profiles as $i => $profile)
          <button class="profile-tab {{ $i === 0 ? 'is-active' : '' }}" role="tab"
            aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
            aria-controls="panel-{{ $profile->slug }}"
            data-tab="{{ $profile->slug }}" type="button">
            <div class="profile-tab__icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <span>{{ esc_html($profile->name) }}</span>
          </button>
        @endforeach
      </div>
    </div>
  </div>

  <div class="section">
    @foreach($profiles as $i => $profile)
      @php
        $procedures = get_posts([
          'post_type' => 'procedure', 'posts_per_page' => -1, 'post_status' => 'publish',
          'tax_query' => [['taxonomy' => 'medical_profile', 'field' => 'term_id', 'terms' => $profile->term_id]],
        ]);
      @endphp
      <div id="panel-{{ $profile->slug }}" role="tabpanel" class="profile-panel {{ $i > 0 ? 'hidden' : '' }}">
        <div class="container">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">
            <div>
              <h2 class="h2">{{ esc_html($profile->name) }}</h2>
              @if($profile->description)
                <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">{{ esc_html($profile->description) }}</p>
              @endif
              @if(count($procedures))
                <div class="mt-8">
                  <h3 class="h3 mb-6">{{ __('Процедуры', 'qazaqstan') }}</h3>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($procedures as $proc)
                      @php $procThumb = get_the_post_thumbnail_url($proc, 'medium'); @endphp
                      <article class="procedure-card">
                        @if($procThumb)<div class="procedure-card__img"><img src="{{ esc_url($procThumb) }}" alt="{{ esc_attr($proc->post_title) }}" loading="lazy" width="400" height="260"></div>@endif
                        <div class="procedure-card__body">
                          <h4 class="procedure-card__title">{{ esc_html($proc->post_title) }}</h4>
                          @if($proc->post_excerpt)<p class="procedure-card__text">{{ esc_html($proc->post_excerpt) }}</p>@endif
                        </div>
                      </article>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>
            <div class="bg-off-white rounded-xl p-8">
              <h3 class="h3 mb-6">{{ __('Показания к лечению', 'qazaqstan') }}</h3>
              @if($profile->description)
                <p class="text-soft-grey text-[16px] leading-relaxed mb-6">{{ esc_html($profile->description) }}</p>
              @endif
              <a href="{{ home_url('/booking/') }}" class="btn btn--primary w-full justify-center">{{ __('Записаться на лечение', 'qazaqstan') }}</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@else
  {{-- Фолбэк без БД данных --}}
  <div class="sticky top-20 z-sticky profile-nav-wrap" id="profile-tabs-nav">
    <div class="container">
      <div class="profile-nav" role="tablist" aria-label="{{ __('Профили лечения', 'qazaqstan') }}">
        @foreach($profileFallback as $i => [$slug, $name])
          <button class="profile-tab {{ $i === 0 ? 'is-active' : '' }}" role="tab"
            aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
            aria-controls="panel-{{ $slug }}" data-tab="{{ $slug }}" type="button">
            <div class="profile-tab__icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <span>{{ __($name, 'qazaqstan') }}</span>
          </button>
        @endforeach
      </div>
    </div>
  </div>

  <div class="section">
    @foreach($profileFallback as $i => [$slug, $name, $desc, $procedures])
      <div id="panel-{{ $slug }}" role="tabpanel" class="profile-panel {{ $i > 0 ? 'hidden' : '' }}">
        <div class="container">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">
            <div>
              <h2 class="h2">{{ __($name, 'qazaqstan') }}</h2>
              <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">{{ __($desc, 'qazaqstan') }}</p>
              <div class="mt-8">
                <h3 class="h3 mb-6">{{ __('Применяемые процедуры', 'qazaqstan') }}</h3>
                <ul class="space-y-2">
                  @foreach($procedures as $proc)
                    <li class="flex items-center gap-3 text-charcoal text-[16px]">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--may-green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                      {{ __($proc, 'qazaqstan') }}
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
            <div class="bg-off-white rounded-xl p-8">
              <h3 class="h3 mb-4">{{ __('Хотите пройти лечение?', 'qazaqstan') }}</h3>
              <p class="text-soft-grey text-[16px] leading-relaxed mb-6">{{ __('Программа составляется индивидуально после консультации с врачом.', 'qazaqstan') }}</p>
              <a href="{{ home_url('/booking/') }}" class="btn btn--primary w-full justify-center">{{ __('Записаться на лечение', 'qazaqstan') }}</a>
              @php $phone = qazaqstan_option('phone_primary') ?: '+7 (727) 264-64-54'; @endphp
              <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--secondary w-full justify-center mt-3">{{ esc_html($phone) }}</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endif

{{-- Что включено --}}
@php
  $pkgItems = qazaqstan_option('package_includes') ?: [
    ['item' => 'Проживание'], ['item' => '5-разовое питание'], ['item' => 'Консультации 6 специалистов'],
    ['item' => 'Бассейн с минеральной водой'], ['item' => 'Сауна'], ['item' => 'Озокеритовые аппликации'],
    ['item' => 'Фитобар и кислородный коктейль'], ['item' => 'ЛФК'], ['item' => 'Массаж'],
    ['item' => 'Диетотерапия'], ['item' => 'УЗТ, СМТ, УВЧ, ингаляции'], ['item' => 'Душ Шарко, Виши'],
  ];
@endphp
<section class="section bg-off-white" aria-labelledby="included-heading">
  <div class="container">
    <div class="section-header section-header--center mb-10">
      <p class="eyebrow">{{ __('Путёвка', 'qazaqstan') }}</p>
      <h2 id="included-heading" class="h2 mt-4">{{ __('Что входит в каждую путёвку', 'qazaqstan') }}</h2>
      <p class="section-lead mt-4">{{ __('Независимо от профиля — все эти услуги включены в стоимость', 'qazaqstan') }}</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 max-w-4xl mx-auto">
      @foreach($pkgItems as $item)
        <div class="included-item">
          <div class="included-item__icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <span class="included-item__text">{{ esc_html($item['item']) }}</span>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Путёвки для детей --}}
@php
  $childPackage = ['Проживание', '5-разовое питание', 'Посещение бассейна с минеральной водой', 'ЛФК', 'УФО', 'Ингаляции', 'Фитобар', 'Кислородный коктейль', 'Соляная шахта'];
@endphp
<section class="section" aria-labelledby="children-heading">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div>
        <p class="eyebrow eyebrow--cerulean">{{ __('Для семей с детьми', 'qazaqstan') }}</p>
        <h2 id="children-heading" class="h2 mt-4">{{ __('Путёвки для детей', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Для посещения бассейна ребёнком нужна справка об отсутствии противопоказаний и эпидемиологическом окружении, закрытый купальный костюм и нескользящие сланцы.', 'qazaqstan') }}
        </p>
        <ul class="mt-6 grid grid-cols-2 gap-2.5">
          @foreach($childPackage as $item)
            <li class="flex gap-2 items-center text-charcoal text-[14px]">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--may-green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
              {{ __($item, 'qazaqstan') }}
            </li>
          @endforeach
        </ul>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="p-6 bg-off-white rounded-xl">
          <p class="font-display font-bold text-charcoal text-[15px]">{{ __('От 3 до 7 лет включительно', 'qazaqstan') }}</p>
          <p class="mt-3 font-display font-bold text-[28px] text-klein-blue">10 000 ₸</p>
          <p class="text-soft-grey text-[13px] mt-1">{{ __('за сутки', 'qazaqstan') }}</p>
        </div>
        <div class="p-6 bg-off-white rounded-xl">
          <p class="font-display font-bold text-charcoal text-[15px]">{{ __('От 8 до 13 лет включительно', 'qazaqstan') }}</p>
          <p class="mt-3 font-display font-bold text-[28px] text-klein-blue">15 000 ₸</p>
          <p class="text-soft-grey text-[13px] mt-1">{{ __('за сутки', 'qazaqstan') }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
(function () {
  const tabs = document.querySelectorAll('.profile-tab');
  const panels = document.querySelectorAll('.profile-panel');
  if (!tabs.length) return;
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => { t.classList.remove('is-active'); t.setAttribute('aria-selected', 'false'); });
      panels.forEach(p => p.classList.add('hidden'));
      tab.classList.add('is-active');
      tab.setAttribute('aria-selected', 'true');
      const panel = document.getElementById('panel-' + tab.dataset.tab);
      panel?.classList.remove('hidden');
      panel?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
})();
</script>

@include('partials.cta-band', [
  'heading' => __('Подберём программу под ваш диагноз', 'qazaqstan'),
  'text'    => __('Оставьте заявку — наш врач свяжется и составит индивидуальный план лечения.', 'qazaqstan'),
])

@endsection

@extends('layouts.app')

@section('content')

{{-- Hero --}}
@php
  $heroPoster = get_theme_mod('hero_poster') ?: get_theme_mod('hero_image');
  $discounts  = qazaqstan_option('discounts') ?: [];
  $mvdPct     = '30%';
  foreach ($discounts as $d) {
    if (isset($d['percent']) && (int)$d['percent'] === 30) { $mvdPct = '30%'; break; }
    if (isset($d['percent']) && (int)$d['percent'] === 20) { $mvdPct = '20%'; }
  }
@endphp
<section data-hero class="hero" aria-label="{{ __('Главный баннер', 'qazaqstan') }}">
  @if($heroPoster)
    <img class="hero__bg" src="{{ esc_url($heroPoster) }}" alt="" aria-hidden="true">
  @else
    <div class="hero__bg hero__bg--fallback" aria-hidden="true"></div>
  @endif
  <div class="hero__overlay"></div>

  <div class="hero__content">
    <div class="container">
      <div class="max-w-xl mb-20">
        <p class="eyebrow text-white/55 mb-4 tracking-widest">{{ __('Алматы · Пр. Достык, 308', 'qazaqstan') }}</p>
        <h1 class="h1 text-white leading-none tracking-tight !text-[34px] md:!text-[62px]">
          {{ __('Здоровье.', 'qazaqstan') }}<br>{{ __('Природа. Покой.', 'qazaqstan') }}
        </h1>
        <p class="text-[20px] md:text-[26px] text-white/60 mt-3 leading-snug">
          {{ __('Отдых в', 'qazaqstan') }} <span class="font-accent">QAZAQSTAN Resort</span>
        </p>
        <p class="mt-4 text-white/65 text-[14px] md:text-[16px] max-w-sm leading-relaxed">
          {{ __('Санаторно-курортное лечение, бассейн с минеральной водой и полный пансион в предгорьях Алатау.', 'qazaqstan') }}
        </p>
        <div class="flex flex-wrap gap-3 mt-6">
          <a href="#booking" class="btn btn--white btn--lg">{{ __('Забронировать', 'qazaqstan') }}</a>
          <a href="{{ home_url('/treatment/') }}" class="btn btn--ghost-white btn--lg">{{ __('Программы лечения', 'qazaqstan') }}</a>
        </div>
      </div>
    </div>
  </div>

  <div class="hero__stats" aria-label="{{ __('Ключевые показатели', 'qazaqstan') }}">
    <div class="container">
      <div class="hero__stats-grid">
        <div class="hero__stat"><span class="hero__stat-number">40+</span><span class="hero__stat-label">{{ __('лет опыта', 'qazaqstan') }}</span></div>
        <div class="hero__stat"><span class="hero__stat-number">5</span><span class="hero__stat-label">{{ __('профилей лечения', 'qazaqstan') }}</span></div>
        <div class="hero__stat">
          <span class="hero__stat-number">{{ $mvdPct }}</span>
          <span class="hero__stat-label">{{ __('скидки МВД РК', 'qazaqstan') }}</span>
        </div>
        <div class="hero__stat"><span class="hero__stat-number">365</span><span class="hero__stat-label">{{ __('дней в году', 'qazaqstan') }}</span></div>
      </div>
    </div>
  </div>
</section>

{{-- О санатории --}}
<section class="section" id="about" aria-labelledby="about-heading">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
      <div>
        <p class="eyebrow">{{ __('О санатории', 'qazaqstan') }}</p>
        <h2 id="about-heading" class="h2 mt-4">{{ __('Многопрофильный лечебный комплекс с 40-летней историей', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Санаторий «Казахстан» работает с 1985 года и принимает гостей круглый год. Расположен в предгорьях Алатау, на проспекте Достык — в 25 минутах от центра Алматы.', 'qazaqstan') }}
        </p>
        <p class="mt-4 text-soft-grey text-[17px] leading-relaxed">
          {{ __('В стоимость путёвки входит всё необходимое: проживание, пятиразовое питание, консультации шести специалистов, бассейн с минеральной водой и назначенные врачом лечебные процедуры.', 'qazaqstan') }}
        </p>
        <a href="{{ home_url('/about/') }}" class="btn btn--secondary mt-8">{{ __('Об учреждении', 'qazaqstan') }}</a>
      </div>
      <div class="grid grid-cols-2 gap-4 md:gap-6">
        <div class="about-stat"><span class="about-stat__number">40+</span><span class="about-stat__label">{{ __('лет работы', 'qazaqstan') }}</span></div>
        <div class="about-stat"><span class="about-stat__number">5</span><span class="about-stat__label">{{ __('профилей лечения', 'qazaqstan') }}</span></div>
        <div class="about-stat"><span class="about-stat__number">20+</span><span class="about-stat__label">{{ __('врачей-специалистов', 'qazaqstan') }}</span></div>
        <div class="about-stat"><span class="about-stat__number">15+</span><span class="about-stat__label">{{ __('лечебных процедур', 'qazaqstan') }}</span></div>
      </div>
    </div>
  </div>
</section>

{{-- 5 профилей лечения --}}
@php
  $profiles     = get_terms(['taxonomy' => 'medical_profile', 'hide_empty' => false, 'number' => 5]);
  $profileColors = ['blue', 'cerulean', 'red', 'purple', 'green'];
  $profileFallback = [
    ['blue',     'Опорно-двигательный аппарат', 'Артриты, остеохондроз, реабилитация после травм'],
    ['cerulean', 'Органы дыхания',              'Бронхиты, астма, ХОБЛ, ингаляционная терапия'],
    ['red',      'Сердечно-сосудистая система', 'Гипертония, ИБС, нарушения кровообращения'],
    ['purple',   'Нервная система',             'Неврозы, нарушения сна, стрессовые состояния'],
    ['green',    'Урология и гинекология',      'Радоновые и минеральные ванны, физиотерапия'],
  ];
@endphp
<section class="section bg-off-white" id="treatment" aria-labelledby="treatment-heading">
  <div class="container">
    <div class="section-header section-header--center">
      <p class="eyebrow">{{ __('Лечение', 'qazaqstan') }}</p>
      <h2 id="treatment-heading" class="h2 mt-4">{{ __('5 профилей лечения', 'qazaqstan') }}</h2>
      <p class="section-lead mt-4">{{ __('Комплексный подход к оздоровлению под наблюдением врачей', 'qazaqstan') }}</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-12">
      @if(!is_wp_error($profiles) && count($profiles))
        @foreach($profiles as $i => $profile)
        <article class="treatment-card">
          <div class="treatment-card__icon treatment-card__icon--{{ $profileColors[$i % 5] }}">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
          </div>
          <h3 class="treatment-card__title">{{ esc_html($profile->name) }}</h3>
          @if($profile->description)
            <p class="treatment-card__text">{{ esc_html($profile->description) }}</p>
          @endif
          <a href="{{ get_term_link($profile) }}" class="treatment-card__link">
            {{ __('Подробнее', 'qazaqstan') }}
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
          </a>
        </article>
        @endforeach
      @else
        @foreach($profileFallback as [$color, $title, $desc])
        <article class="treatment-card">
          <div class="treatment-card__icon treatment-card__icon--{{ $color }}">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
          </div>
          <h3 class="treatment-card__title">{{ __($title, 'qazaqstan') }}</h3>
          <p class="treatment-card__text">{{ __($desc, 'qazaqstan') }}</p>
          <a href="{{ home_url('/treatment/') }}" class="treatment-card__link">
            {{ __('Подробнее', 'qazaqstan') }}
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
          </a>
        </article>
        @endforeach
      @endif
    </div>
    <div class="text-center mt-10">
      <a href="{{ home_url('/treatment/') }}" class="btn btn--primary">{{ __('Все программы лечения', 'qazaqstan') }}</a>
    </div>
  </div>
</section>

{{-- Номера и цены --}}
@php
  $rooms = get_posts([
    'post_type'    => 'room',
    'posts_per_page' => 3,
    'post_status'  => 'publish',
    'meta_key'     => 'room_price_single',
    'orderby'      => 'meta_value_num',
    'order'        => 'ASC',
  ]);
@endphp
<section class="section" id="accommodation" aria-labelledby="accommodation-heading">
  <div class="container">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
      <div>
        <p class="eyebrow">{{ __('Проживание', 'qazaqstan') }}</p>
        <h2 id="accommodation-heading" class="h2 mt-4">{{ __('Номера и цены', 'qazaqstan') }}</h2>
      </div>
      <a href="{{ home_url('/accommodation/') }}" class="btn btn--secondary self-start md:self-auto">{{ __('Все номера', 'qazaqstan') }}</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($rooms as $i => $room)
        @php
          $thumb       = get_the_post_thumbnail_url($room, 'large') ?: '';
          $gallery     = qazaqstan_field('room_gallery', $room->ID);
          $img         = $thumb ?: (is_array($gallery) ? ($gallery[0]['sizes']['large'] ?? $gallery[0]['url'] ?? '') : '');
          $priceSingle = (int) qazaqstan_field('room_price_single', $room->ID);
          $featured    = ($i === 1);
          $typeTerms   = wp_get_post_terms($room->ID, 'room_type');
          $typeName    = (!is_wp_error($typeTerms) && count($typeTerms)) ? $typeTerms[0]->name : '';
          $includes    = qazaqstan_field('room_includes', $room->ID);
        @endphp
        <article class="pricing-card {{ $featured ? 'pricing-card--featured' : '' }}">
          @if($featured)<div class="pricing-card__badge">{{ __('Популярный', 'qazaqstan') }}</div>@endif
          <div class="pricing-card__image">
            @if($img)
              <img src="{{ esc_url($img) }}" alt="{{ esc_attr($room->post_title) }} — QAZAQSTAN Resort" loading="lazy" width="600" height="400">
            @else
              <div class="w-full h-48 bg-warm-grey flex items-center justify-center text-soft-grey text-sm">{{ __('Фото скоро', 'qazaqstan') }}</div>
            @endif
          </div>
          <div class="pricing-card__body">
            @if($typeName)<span class="pricing-card__category">{{ esc_html($typeName) }}</span>@endif
            <h3 class="pricing-card__title">{{ esc_html($room->post_title) }}</h3>
            @if($priceSingle)
              <div class="pricing-card__price">
                <span class="pricing-card__from">{{ __('от', 'qazaqstan') }}</span>
                <span class="pricing-card__amount">{{ number_format($priceSingle, 0, '.', ' ') }}</span>
                <span class="pricing-card__unit">₸&nbsp;/&nbsp;{{ __('сут.', 'qazaqstan') }}</span>
              </div>
            @endif
            <ul class="pricing-card__features" aria-label="{{ __('Что включено', 'qazaqstan') }}">
              @php $checkIcon = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>'; @endphp
              @if(is_array($includes) && count($includes))
                @foreach(array_slice($includes, 0, 3) as $inc)
                  <li>{!! $checkIcon !!}{{ esc_html($inc['item']) }}</li>
                @endforeach
              @else
                <li>{!! $checkIcon !!}{{ __('5-разовое питание', 'qazaqstan') }}</li>
                <li>{!! $checkIcon !!}{{ __('Все лечебные процедуры', 'qazaqstan') }}</li>
                <li>{!! $checkIcon !!}{{ __('Бассейн с минеральной водой', 'qazaqstan') }}</li>
              @endif
            </ul>
            <a href="#booking" class="btn btn--primary btn--block mt-6">{{ __('Забронировать', 'qazaqstan') }}</a>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>

{{-- Что входит в путёвку --}}
@php
  $packageItems   = qazaqstan_option('package_includes');
  $defaultPackage = [
    ['item' => 'Проживание'], ['item' => '5-разовое питание'], ['item' => 'Консультации 6 специалистов'],
    ['item' => 'Бассейн с минеральной водой'], ['item' => 'Сауна'], ['item' => 'Озокеритовые аппликации'],
    ['item' => 'Фитобар и кислородный коктейль'], ['item' => 'ЛФК — лечебная физкультура'],
    ['item' => 'Массаж'], ['item' => 'Диетотерапия'], ['item' => 'УЗТ, СМТ, УВЧ, ингаляции'],
    ['item' => 'Душ Шарко, Виши, циркулярный'],
  ];
  $pkgList = is_array($packageItems) && count($packageItems) ? $packageItems : $defaultPackage;
@endphp
<section class="section bg-off-white" id="included" aria-labelledby="included-heading">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Путёвка всё включено', 'qazaqstan') }}</p>
      <h2 id="included-heading" class="h2 mt-4">{{ __('Что входит в стоимость', 'qazaqstan') }}</h2>
      <p class="section-lead mt-4">{{ __('Никаких скрытых платежей — все основные услуги включены в цену путёвки', 'qazaqstan') }}</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-w-4xl mx-auto">
      @foreach($pkgList as $item)
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

{{-- Скидки --}}
@php
  $discountList = is_array($discounts) && count($discounts) ? $discounts : [
    ['label' => 'Пенсионеры по возрасту',  'percent' => 10, 'note' => 'Требуется пенсионное удостоверение'],
    ['label' => 'Сотрудники МВД РК',        'percent' => 20, 'note' => 'Действующие сотрудники и члены семей. Служебное удостоверение'],
    ['label' => 'Пенсионеры МВД РК',        'percent' => 30, 'note' => 'Ветераны МВД и члены семей. Ветеранское удостоверение МВД'],
  ];
@endphp
<section class="section discounts-section" id="discounts" aria-labelledby="discounts-heading">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow eyebrow--cerulean">{{ __('Льготы', 'qazaqstan') }}</p>
      <h2 id="discounts-heading" class="h2 text-white mt-4">{{ __('Скидки для отдельных категорий', 'qazaqstan') }}</h2>
      <p class="section-lead section-lead--light mt-4">{{ __('При предъявлении подтверждающих документов на ресепшн', 'qazaqstan') }}</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      @foreach($discountList as $i => $d)
        <article class="discount-card {{ $i === 1 ? 'discount-card--featured' : '' }}">
          <div class="discount-card__percent">{{ esc_html($d['percent']) }}%</div>
          <h3 class="discount-card__title">{{ esc_html($d['label']) }}</h3>
          @if(!empty($d['note']))
            <p class="discount-card__text">{{ esc_html($d['note']) }}</p>
          @endif
        </article>
      @endforeach
    </div>
  </div>
</section>

{{-- Спортивный комплекс --}}
@php
  $sportImgMain  = get_theme_mod('sport_image_main');
  $sportImgGym   = get_theme_mod('sport_image_gym');
  $sportImgSauna = get_theme_mod('sport_image_sauna');
  $sportFeatures = [
    ['Бассейн с минеральной водой', 'Бальнеологическая вода, температура 28–32°C, круглогодично'],
    ['Тренажёрный зал',             'Современное оборудование, работает ежедневно с 7:00 до 22:00'],
    ['ЛФК — лечебная физкультура',  'Групповые и индивидуальные занятия с инструктором'],
    ['Сауна',                        'Финская сауна для глубокого расслабления и очищения'],
  ];
@endphp
<section class="section" id="sport" aria-labelledby="sport-heading">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
      <div>
        <p class="eyebrow">{{ __('Спорт и оздоровление', 'qazaqstan') }}</p>
        <h2 id="sport-heading" class="h2 mt-4">{{ __('Спортивный комплекс', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Полноценный оздоровительный комплекс для восстановления и поддержания физической формы. Все объекты доступны гостям санатория в рамках путёвки.', 'qazaqstan') }}
        </p>
        <ul class="sport-features mt-8" role="list">
          @foreach($sportFeatures as [$name, $desc])
            <li class="sport-feature">
              <div class="sport-feature__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
              </div>
              <div class="sport-feature__content">
                <strong class="sport-feature__name">{{ __($name, 'qazaqstan') }}</strong>
                <span class="sport-feature__desc">{{ __($desc, 'qazaqstan') }}</span>
              </div>
            </li>
          @endforeach
        </ul>
        <a href="{{ home_url('/sport/') }}" class="btn btn--primary mt-8">{{ __('Спортивный комплекс', 'qazaqstan') }}</a>
      </div>
      <div class="sport-images">
        <div class="sport-images__grid">
          <div class="sport-images__main">
            @if($sportImgMain)
              <img src="{{ esc_url($sportImgMain) }}" alt="{{ __('Бассейн с минеральной водой — QAZAQSTAN Resort', 'qazaqstan') }}" loading="lazy" width="700" height="480">
            @else
              @include('partials.media-placeholder', ['variant' => 'water', 'label' => __('Бассейн', 'qazaqstan')])
            @endif
          </div>
          <div class="sport-images__secondary">
            @if($sportImgGym)
              <img src="{{ esc_url($sportImgGym) }}" alt="{{ __('Тренажёрный зал — QAZAQSTAN Resort', 'qazaqstan') }}" loading="lazy" width="400" height="240">
            @else
              @include('partials.media-placeholder', ['variant' => 'nature', 'label' => __('Тренажёрный зал', 'qazaqstan')])
            @endif
            @if($sportImgSauna)
              <img src="{{ esc_url($sportImgSauna) }}" alt="{{ __('Сауна — QAZAQSTAN Resort', 'qazaqstan') }}" loading="lazy" width="400" height="240">
            @else
              @include('partials.media-placeholder', ['variant' => 'water', 'label' => __('Сауна', 'qazaqstan')])
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Отзывы --}}
@php
  $testimonials = get_posts(['post_type' => 'testimonial', 'posts_per_page' => 6, 'post_status' => 'publish']);
  $reviewFallback = [
    ['Галина Н.',  'Лечение опорно-двигательного аппарата · 2025', 'Провела здесь 14 дней на реабилитации после операции на позвоночнике. Персонал внимательный, процедуры действительно помогли.'],
    ['Алибек М.',  'Оздоровительный отдых · 2025',                 'Ездим сюда с женой третий год подряд. Бассейн с минеральной водой — это просто отдельная история. Питание отличное, врачи профессиональные.'],
    ['Малика Т.',  'Лечение органов дыхания · 2025',               'Приехала по направлению с проблемами с дыханием. За 10 дней курс ингаляций и физиотерапии дал заметный результат.'],
    ['Болат К.',   'Сердечно-сосудистый профиль · 2024',           'Каждый год приезжаю на профилактику. Благодаря минеральным ваннам и массажу давление пришло в норму.'],
    ['Нурия С.',   'Пенсионер МВД · Нервная система · 2025',        'Взяла путёвку со скидкой для пенсионеров МВД. Цены очень разумные, условия отличные.'],
    ['Дархан Ж.',  'Корпоративный отдых · 2025',                    'Проводили корпоратив — 30 человек. Конференц-зал отлично оснащён, питание вкусное, бассейн все оценили.'],
  ];
@endphp
<section class="section" id="reviews" aria-labelledby="reviews-heading">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Отзывы', 'qazaqstan') }}</p>
      <h2 id="reviews-heading" class="h2 mt-4">{{ __('Что говорят наши гости', 'qazaqstan') }}</h2>
    </div>
    <div class="reviews-carousel-wrap" id="reviewsCarousel">
      <div class="reviews-track" id="reviewsTrack" aria-live="polite">
        @if(count($testimonials))
          @foreach($testimonials as $t)
            @php
              $author  = qazaqstan_field('testimonial_author', $t->ID) ?: $t->post_title;
              $meta    = qazaqstan_field('testimonial_meta', $t->ID);
              $initial = mb_strtoupper(mb_substr($author, 0, 1));
            @endphp
            <article class="review-card">
              <div class="review-card__stars" aria-label="{{ __('5 из 5 звёзд', 'qazaqstan') }}">
                @for($s = 0; $s < 5; $s++)<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endfor
              </div>
              <blockquote class="review-card__text">"{{ esc_html($t->post_content) }}"</blockquote>
              <footer class="review-card__footer">
                <div class="review-card__avatar" aria-hidden="true">{{ $initial }}</div>
                <div>
                  <p class="review-card__author">{{ esc_html($author) }}</p>
                  @if($meta)<p class="review-card__meta">{{ esc_html($meta) }}</p>@endif
                </div>
              </footer>
            </article>
          @endforeach
        @else
          @foreach($reviewFallback as [$author, $meta, $text])
            <article class="review-card">
              <div class="review-card__stars" aria-label="{{ __('5 из 5 звёзд', 'qazaqstan') }}">
                @for($s = 0; $s < 5; $s++)<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endfor
              </div>
              <blockquote class="review-card__text">"{{ $text }}"</blockquote>
              <footer class="review-card__footer">
                <div class="review-card__avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($author, 0, 1)) }}</div>
                <div>
                  <p class="review-card__author">{{ $author }}</p>
                  <p class="review-card__meta">{{ $meta }}</p>
                </div>
              </footer>
            </article>
          @endforeach
        @endif
      </div>
    </div>
    <div class="reviews-controls">
      <button class="reviews-nav-btn" id="reviewsPrev" aria-label="{{ __('Предыдущие отзывы', 'qazaqstan') }}" disabled>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <div class="reviews-dots" id="reviewsDots" aria-hidden="true">
        @for($d = 0; $d < 4; $d++)
          <button class="reviews-dot {{ $d === 0 ? 'is-active' : '' }}" data-index="{{ $d }}"></button>
        @endfor
      </div>
      <button class="reviews-nav-btn" id="reviewsNext" aria-label="{{ __('Следующие отзывы', 'qazaqstan') }}">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div>
  </div>
</section>

{{-- Конференц-залы --}}
@php
  $confHalls = get_posts(['post_type' => 'conference_hall', 'posts_per_page' => 1, 'post_status' => 'publish']);
  $confImg   = count($confHalls) ? get_the_post_thumbnail_url($confHalls[0], 'large') : '';
  $confFeatures = ['Конференции, семинары, тренинги', 'Корпоративный отдых и тимбилдинг', 'Зал до 150 участников', 'Кейтеринг и размещение участников'];
@endphp
<section class="section bg-off-white" id="conferences" aria-labelledby="conferences-heading">
  <div class="container">
    <div class="conferences-block">
      <div class="conferences-block__image">
        @if($confImg)
          <img src="{{ esc_url($confImg) }}" alt="{{ __('Конференц-зал — QAZAQSTAN Resort', 'qazaqstan') }}" loading="lazy" width="700" height="500">
        @else
          @include('partials.media-placeholder', ['variant' => 'water', 'label' => __('Конференц-зал', 'qazaqstan'), 'class' => 'w-full h-full'])
        @endif
      </div>
      <div class="conferences-block__content">
        <p class="eyebrow">{{ __('Корпоративным клиентам', 'qazaqstan') }}</p>
        <h2 id="conferences-heading" class="h2 mt-4">{{ __('Конференц-залы и тимбилдинг', 'qazaqstan') }}</h2>
        <p class="mt-5 text-soft-grey text-[17px] leading-relaxed">
          {{ __('Три современно оснащённых зала для деловых мероприятий. Проектор, экран, флипчарт, Wi-Fi, кейтеринг — всё организуем под ваши задачи.', 'qazaqstan') }}
        </p>
        <ul class="conferences-features mt-6" role="list">
          @foreach($confFeatures as $f)
            <li class="conferences-feature">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
              {{ __($f, 'qazaqstan') }}
            </li>
          @endforeach
        </ul>
        <div class="flex flex-wrap gap-3 mt-8">
          <a href="{{ home_url('/conferences/') }}" class="btn btn--primary">{{ __('Подробнее о залах', 'qazaqstan') }}</a>
          <a href="{{ home_url('/contacts/') }}" class="btn btn--secondary">{{ __('Запросить предложение', 'qazaqstan') }}</a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Мини-форма бронирования --}}
@php
  $bookingRooms = get_posts([
    'post_type'      => 'room',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => [['key' => 'room_bookable', 'value' => '1']],
  ]);
  $pkgShort = is_array($packageItems) && count($packageItems)
    ? array_slice($packageItems, 0, 4)
    : [['item' => 'Проживание и 5-разовое питание'], ['item' => 'Бассейн, сауна, тренажёрный зал'], ['item' => 'Все назначенные лечебные процедуры'], ['item' => 'Консультации шести специалистов']];
@endphp
<section class="section booking-section" id="booking" aria-labelledby="booking-heading">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
      <div>
        <p class="eyebrow eyebrow--cerulean">{{ __('Онлайн-бронирование', 'qazaqstan') }}</p>
        <h2 id="booking-heading" class="h2 text-white mt-4">{{ __('Забронируйте путёвку', 'qazaqstan') }}</h2>
        <p class="mt-4 text-white/70 text-[17px] leading-relaxed">
          {{ __('Заполните форму, и наш менеджер свяжется с вами в течение 30 минут для подтверждения бронирования.', 'qazaqstan') }}
        </p>
        <div class="booking-included mt-8">
          <p class="text-white/50 text-[13px] uppercase tracking-widest font-bold mb-4">{{ __('В путёвку входит', 'qazaqstan') }}</p>
          <ul class="space-y-2">
            @foreach($pkgShort as $pkg)
              <li class="flex items-center gap-3 text-white/75 text-[15px]">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                {{ esc_html($pkg['item']) }}
              </li>
            @endforeach
          </ul>
        </div>
      </div>

      <form class="booking-form" id="bookingForm" novalidate aria-label="{{ __('Форма бронирования', 'qazaqstan') }}" data-booking-form>
        {!! wp_nonce_field('qazaqstan_booking', '_wpnonce', true, false) !!}
        <input type="text" name="website" class="booking-form__honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">

        <div class="booking-form__group">
          <label for="booking-name" class="booking-form__label">{{ __('Ваше имя', 'qazaqstan') }} <span aria-hidden="true">*</span></label>
          <input type="text" id="booking-name" name="name" class="booking-form__input" placeholder="{{ __('Имя Фамилия', 'qazaqstan') }}" required autocomplete="name">
        </div>
        <div class="booking-form__group">
          <label for="booking-phone" class="booking-form__label">{{ __('Телефон', 'qazaqstan') }} <span aria-hidden="true">*</span></label>
          <input type="tel" id="booking-phone" name="phone" class="booking-form__input" placeholder="+7 (___) ___-__-__" required autocomplete="tel">
        </div>
        <div class="booking-form__row">
          <div class="booking-form__group">
            <label for="booking-checkin" class="booking-form__label">{{ __('Заезд', 'qazaqstan') }}</label>
            <input type="date" id="booking-checkin" name="checkin" class="booking-form__input">
          </div>
          <div class="booking-form__group">
            <label for="booking-checkout" class="booking-form__label">{{ __('Выезд', 'qazaqstan') }}</label>
            <input type="date" id="booking-checkout" name="checkout" class="booking-form__input">
          </div>
        </div>
        <div class="booking-form__group">
          <label for="booking-room" class="booking-form__label">{{ __('Тип номера', 'qazaqstan') }}</label>
          <select id="booking-room" name="room_type" class="booking-form__input">
            <option value="">{{ __('Выбрать тип номера', 'qazaqstan') }}</option>
            @if(count($bookingRooms))
              @foreach($bookingRooms as $br)
                @php $brPrice = (int) qazaqstan_field('room_price_single', $br->ID); @endphp
                <option value="{{ $br->ID }}">{{ esc_html($br->post_title) }}{{ $brPrice ? ' — ' . number_format($brPrice, 0, '.', ' ') . ' ₸/сут.' : '' }}</option>
              @endforeach
            @else
              <option value="standard-1">Стандарт 1-местный — 32 000 ₸/сут.</option>
              <option value="standard-2">Стандарт 2-местный — 56 000 ₸/сут.</option>
              <option value="lux-1">Люкс 1-местный — 45 000 ₸/сут.</option>
              <option value="lux-2">Люкс 2-местный — 70 000 ₸/сут.</option>
              <option value="president-1">Президентский 1-местный — 80 000 ₸/сут.</option>
              <option value="president-2">Президентский 2-местный — 140 000 ₸/сут.</option>
            @endif
          </select>
        </div>
        <div class="booking-form__group">
          <label for="booking-comment" class="booking-form__label">{{ __('Комментарий', 'qazaqstan') }}</label>
          <textarea id="booking-comment" name="comment" class="booking-form__input booking-form__textarea" placeholder="{{ __('Особые пожелания, вопросы по лечению...', 'qazaqstan') }}" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn--white btn--block btn--lg mt-2">{{ __('Отправить заявку', 'qazaqstan') }}</button>
        <p class="booking-form__disclaimer mt-3">
          {{ __('Нажимая кнопку, вы соглашаетесь с', 'qazaqstan') }}
          <a href="{{ home_url('/privacy/') }}" class="underline underline-offset-2 hover:no-underline">{{ __('политикой конфиденциальности', 'qazaqstan') }}</a>
        </p>
      </form>
    </div>
  </div>
</section>

{{-- Контакты-превью --}}
@php
  $contactAddress   = qazaqstan_option('address')        ?: 'г. Алматы, пр. Достык, 308';
  $contactPhone1    = qazaqstan_option('phone_primary')   ?: '+7 (727) 264-64-54';
  $contactPhone2    = qazaqstan_option('phone_secondary') ?: '+7 707 691 5008';
  $contactWorkHours = qazaqstan_option('work_hours')      ?: 'Круглосуточно, 365 дней в году';
  $contactLat       = qazaqstan_option('map_lat')         ?: '43.2567';
  $contactLng       = qazaqstan_option('map_lng')         ?: '76.9286';
@endphp
<section class="section" id="contacts-preview" aria-labelledby="contacts-heading">
  <div class="container">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
      <div>
        <p class="eyebrow">{{ __('Контакты', 'qazaqstan') }}</p>
        <h2 id="contacts-heading" class="h2 mt-4">{{ __('Как нас найти', 'qazaqstan') }}</h2>
      </div>
      <a href="{{ home_url('/contacts/') }}" class="btn btn--secondary self-start md:self-auto">{{ __('Открыть страницу контактов', 'qazaqstan') }}</a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
      <div class="contact-card">
        <div class="contact-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div>
          <p class="contact-card__label">{{ __('Адрес', 'qazaqstan') }}</p>
          <p class="contact-card__value">{{ esc_html($contactAddress) }}</p>
        </div>
      </div>
      <div class="contact-card">
        <div class="contact-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6 6l.94-.94a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </div>
        <div>
          <p class="contact-card__label">{{ __('Телефоны', 'qazaqstan') }}</p>
          <a href="{{ esc_url(qazaqstan_phone_link($contactPhone1)) }}" class="contact-card__value contact-card__value--link">{{ esc_html($contactPhone1) }}</a>
          @if($contactPhone2)
            <a href="{{ esc_url(qazaqstan_phone_link($contactPhone2)) }}" class="contact-card__value contact-card__value--link mt-1">{{ esc_html($contactPhone2) }}</a>
          @endif
        </div>
      </div>
      <div class="contact-card">
        <div class="contact-card__icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
          <p class="contact-card__label">{{ __('Режим работы', 'qazaqstan') }}</p>
          <p class="contact-card__value">{{ esc_html($contactWorkHours) }}</p>
        </div>
      </div>
    </div>
    <div class="map-embed" aria-label="{{ __('Карта проезда', 'qazaqstan') }}">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2907.2!2d{{ esc_attr($contactLng) }}!3d{{ esc_attr($contactLat) }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zQVpBUVNUQU4!5e0!3m2!1sru!2skz!4v1"
        width="100%" height="360" class="border-0" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="{{ __('Карта расположения QAZAQSTAN Resort', 'qazaqstan') }}"></iframe>
    </div>
  </div>
</section>

@endsection

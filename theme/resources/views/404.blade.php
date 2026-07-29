@extends('layouts.app')

@section('content')
<section class="page-hero page-hero--dark">
  <div class="container">
    <p class="eyebrow text-white/60">{{ __('Ошибка 404', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Страница не найдена', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65 text-[17px] leading-relaxed">
      {{ __('Возможно, страница была перемещена или удалена. Проверьте адрес или воспользуйтесь навигацией.', 'qazaqstan') }}
    </p>
    <div class="flex flex-wrap gap-4 mt-8">
      <a href="{{ qazaqstan_url('/') }}" class="btn btn--white">{{ __('На главную', 'qazaqstan') }}</a>
      <a href="{{ qazaqstan_url('/contacts/') }}" class="btn btn--ghost-white">{{ __('Контакты', 'qazaqstan') }}</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2 class="h3 mb-6">{{ __('Популярные разделы', 'qazaqstan') }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach([
        ['url' => '/accommodation/', 'label' => __('Номера и цены', 'qazaqstan')],
        ['url' => '/treatment/', 'label' => __('Лечение', 'qazaqstan')],
        ['url' => '/booking/', 'label' => __('Бронирование', 'qazaqstan')],
        ['url' => '/about/', 'label' => __('О санатории', 'qazaqstan')],
      ] as $link)
        <a href="{{ qazaqstan_url($link['url']) }}" class="p-6 border border-warm-grey rounded-xl bg-white font-display font-bold text-charcoal hover:border-klein-blue transition-colors">
          {{ $link['label'] }}
        </a>
      @endforeach
    </div>
  </div>
</section>
@endsection

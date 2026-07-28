@extends('layouts.app')

@section('content')
<section class="page-hero page-hero--dark">
  <div class="container">
    <p class="eyebrow text-white/60">{{ __('Поиск', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Результаты поиска', 'qazaqstan') }}</h1>
    @if(get_search_query())
      <p class="mt-4 max-w-xl text-white/65 text-[17px] leading-relaxed">
        {{ sprintf(__('По запросу «%s»', 'qazaqstan'), get_search_query()) }}
      </p>
    @endif
  </div>
</section>

<section class="section">
  <div class="container">
    @if (! have_posts())
      <p class="text-soft-grey text-[17px] mb-8">{{ __('Ничего не найдено. Попробуйте изменить запрос.', 'qazaqstan') }}</p>
      {!! get_search_form(false) !!}
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @while(have_posts()) @php(the_post())
        @include('partials.content-search')
      @endwhile
    </div>

    <div class="mt-12">
      {!! get_the_posts_navigation(['prev_text' => __('Назад', 'qazaqstan'), 'next_text' => __('Вперёд', 'qazaqstan')]) !!}
    </div>
  </div>
</section>
@endsection

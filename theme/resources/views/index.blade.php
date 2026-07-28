@extends('layouts.app')

@section('content')
<section class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [
      ['label' => __('Блог', 'qazaqstan')],
    ]])
    <p class="eyebrow text-white/60">{{ __('Новости и статьи', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{!! $title ?? __('Блог', 'qazaqstan') !!}</h1>
  </div>
</section>

<section class="section">
  <div class="container">
    @if (! have_posts())
      <p class="text-soft-grey text-[17px] mb-8">{{ __('Записей пока нет.', 'qazaqstan') }}</p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @while(have_posts()) @php(the_post())
        @include('partials.blog-card', ['post' => get_post()])
      @endwhile
    </div>

    <div class="mt-12">
      {!! get_the_posts_navigation(['prev_text' => __('Назад', 'qazaqstan'), 'next_text' => __('Вперёд', 'qazaqstan')]) !!}
    </div>
  </div>
</section>
@endsection

@extends('layouts.app')

@section('content')
@php
  $post    = get_queried_object();
  $cats    = get_the_category($post->ID);
  $thumb   = get_the_post_thumbnail_url($post, 'large');
  $related = get_posts([
    'post_type'     => 'post',
    'posts_per_page' => 3,
    'post__not_in'  => [$post->ID],
    'category__in'  => wp_list_pluck($cats, 'term_id'),
    'post_status'   => 'publish',
  ]);
@endphp

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [
      ['label' => __('Блог', 'qazaqstan'), 'url' => home_url('/blog/')],
      ['label' => $post->post_title],
    ]])
    @if(count($cats))
      <p class="eyebrow eyebrow--cerulean">{{ esc_html($cats[0]->name) }}</p>
    @endif
    <h1 class="h1 mt-3 text-white max-w-[800px]">{{ esc_html($post->post_title) }}</h1>
    <div class="flex items-center gap-4 mt-5 text-white/55 text-[14px]">
      <span>{{ get_the_date('d F Y', $post) }}</span>
      @php $author = get_the_author_meta('display_name', $post->post_author); @endphp
      @if($author)<span>·</span><span>{{ esc_html($author) }}</span>@endif
    </div>
  </div>
</div>

<section class="section" id="article-content">
  <div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-12 items-start">

      <article class="article-body">
        @if($thumb)
          <figure class="mb-10 rounded-xl overflow-hidden">
            <img src="{{ esc_url($thumb) }}" alt="{{ esc_attr($post->post_title) }}" width="900" height="500" class="w-full object-cover">
          </figure>
        @endif
        @if($post->post_excerpt)
          <p class="article-lead">{{ esc_html($post->post_excerpt) }}</p>
        @endif
        <div class="article-content prose prose-lg max-w-none">
          {!! apply_filters('the_content', $post->post_content) !!}
        </div>
        @if(count($cats))
          <div class="flex flex-wrap gap-2 mt-10 pt-8 border-t border-warm-grey">
            @foreach($cats as $cat)
              <a href="{{ get_category_link($cat) }}" class="badge badge--outline">{{ esc_html($cat->name) }}</a>
            @endforeach
          </div>
        @endif
      </article>

      <aside class="sticky top-28">
        <div class="p-6 bg-off-white border border-warm-grey rounded-xl">
          <p class="eyebrow mb-4">{{ __('Недавние записи', 'qazaqstan') }}</p>
          @php $recent = get_posts(['posts_per_page' => 5, 'post__not_in' => [$post->ID], 'post_status' => 'publish']); @endphp
          <ul class="space-y-4">
            @foreach($recent as $r)
              @php $rThumb = get_the_post_thumbnail_url($r, 'thumbnail'); @endphp
              <li class="flex gap-3">
                @if($rThumb)
                  <img src="{{ esc_url($rThumb) }}" alt="" width="60" height="60" loading="lazy" class="w-[60px] h-[60px] object-cover rounded-lg flex-shrink-0">
                @endif
                <div>
                  <a href="{{ get_permalink($r) }}" class="text-charcoal text-[14px] font-bold leading-snug hover:text-klein-blue transition-colors line-clamp-2">{{ esc_html($r->post_title) }}</a>
                  <p class="text-soft-grey text-[12px] mt-1">{{ get_the_date('d.m.Y', $r) }}</p>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
        <div class="mt-6 p-6 bg-klein-blue rounded-xl text-white text-center">
          <p class="font-display font-bold text-[17px]">{{ __('Хотите поправить здоровье?', 'qazaqstan') }}</p>
          <p class="text-white/75 text-[14px] mt-2">{{ __('Оставьте заявку — подберём программу.', 'qazaqstan') }}</p>
          <a href="{{ home_url('/booking/') }}" class="btn btn--white w-full justify-center mt-4">{{ __('Забронировать', 'qazaqstan') }}</a>
        </div>
      </aside>
    </div>
  </div>
</section>

@if(count($related))
  <section class="py-16 bg-off-white border-t border-warm-grey">
    <div class="container">
      <h2 class="h3 mb-8">{{ __('Читайте также', 'qazaqstan') }}</h2>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        @foreach($related as $r)
          @include('partials.blog-card', ['post' => $r])
        @endforeach
      </div>
    </div>
  </section>
@endif

@endsection

@php
  $crumbs = $breadcrumbs ?? [];
@endphp
@if(count($crumbs))
<div class="bg-off-white border-b border-warm-grey py-4">
  <div class="container">
    <nav class="breadcrumbs" aria-label="{{ __('Хлебные крошки', 'qazaqstan') }}">
      <ol itemscope itemtype="https://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
          <a href="{{ home_url('/') }}" itemprop="item"><span itemprop="name">{{ __('Главная', 'qazaqstan') }}</span></a>
          <meta itemprop="position" content="1">
        </li>
        @foreach($crumbs as $i => $crumb)
          <li aria-hidden="true"><span class="breadcrumbs__sep">/</span></li>
          <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            @if(!empty($crumb['url']) && $i < count($crumbs) - 1)
              <a href="{{ esc_url($crumb['url']) }}" itemprop="item"><span itemprop="name">{{ esc_html($crumb['label']) }}</span></a>
            @else
              <span itemprop="name">{{ esc_html($crumb['label']) }}</span>
            @endif
            <meta itemprop="position" content="{{ $i + 2 }}">
          </li>
        @endforeach
      </ol>
    </nav>
  </div>
</div>
@endif

@php
  $heroVariant = $variant ?? 'dark';
  $heroBg      = $bg ?? '';
@endphp
<div class="page-hero {{ $heroVariant === 'light' ? 'page-hero--light' : 'page-hero--dark' }}"
  @if($heroBg) style="--page-hero-bg:url('{{ esc_url($heroBg) }}')" @endif>
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => $crumbs ?? []])
    <p class="eyebrow {{ $heroVariant === 'dark' ? 'eyebrow--cerulean' : '' }}">{{ $eyebrow ?? '' }}</p>
    <h1 class="h1 mt-3 {{ $heroVariant === 'dark' ? 'text-white' : '' }}">{!! $heading ?? '' !!}</h1>
    @if(!empty($lead))
      <p class="mt-4 max-w-xl {{ $heroVariant === 'dark' ? 'text-white/65' : 'text-soft-grey' }} text-[17px] leading-[1.6]">{{ $lead }}</p>
    @endif
    @if(!empty($actions))
      <div class="flex flex-wrap gap-3 mt-8">{!! $actions !!}</div>
    @endif
  </div>
</div>

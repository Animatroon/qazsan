@php
  $mpVariant = $variant ?? 'water';
  $mpLabel   = $label ?? null;
  $mpClass   = $class ?? '';
@endphp
<div class="media-placeholder media-placeholder--{{ $mpVariant }} {{ $mpClass }}">
  <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>
  </svg>
  @if($mpLabel)
    <span class="media-placeholder__label">{{ $mpLabel }}</span>
  @endif
</div>

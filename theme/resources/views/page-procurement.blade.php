@extends('layouts.app')

@section('content')
@php
  $docs = get_posts([
    'post_type'      => 'document',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'tax_query'      => [['taxonomy' => 'doc_type', 'field' => 'slug', 'terms' => 'procurement']],
    'meta_key'       => 'document_year',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
  ]);
  $byYear = [];
  foreach ($docs as $doc) {
    $year = qazaqstan_field('document_year', $doc->ID) ?: date('Y');
    $byYear[$year][] = $doc;
  }
  krsort($byYear);
  $address = qazaqstan_option('address') ?: 'г. Алматы, пр. Достык, 308';
  $phone   = qazaqstan_option('phone_primary') ?: '+7 (727) 264-64-54';
  $email   = qazaqstan_option('email') ?: 'info@kazakhstansan.kz';
@endphp

<div class="page-hero page-hero--dark">
  <div class="container">
    @include('partials.breadcrumbs', ['breadcrumbs' => [['label' => __('Госзакупки', 'qazaqstan')]]])
    <p class="eyebrow eyebrow--cerulean">{{ __('Прозрачность', 'qazaqstan') }}</p>
    <h1 class="h1 mt-3 text-white">{{ __('Государственные закупки', 'qazaqstan') }}</h1>
    <p class="mt-4 max-w-xl text-white/65 text-[17px] leading-[1.6]">
      {{ __('АО «Санаторий Казахстан» осуществляет закупки товаров, работ и услуг в соответствии с законодательством Республики Казахстан.', 'qazaqstan') }}
    </p>
  </div>
</div>

{{-- Реквизиты организатора --}}
<section class="py-12 bg-white">
  <div class="container">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
      @foreach([
        ['Организатор', 'АО «Санаторий Казахстан»'],
        ['Адрес', $address],
        ['Контакты закупок', $phone . ($email ? ' · ' . $email : '')],
      ] as [$label, $value])
        <div class="p-5 border border-warm-grey rounded-xl bg-off-white">
          <p class="text-[12px] font-bold uppercase tracking-widest text-soft-grey mb-2">{{ __($label, 'qazaqstan') }}</p>
          <p class="text-charcoal text-[15px] font-body">{{ esc_html($value) }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Документы по годам --}}
<section class="section">
  <div class="container">
    <div class="section-header section-header--center mb-12">
      <p class="eyebrow">{{ __('Документы', 'qazaqstan') }}</p>
      <h2 class="h2 mt-4">{{ __('Документы и планы закупок', 'qazaqstan') }}</h2>
    </div>

    @if(count($byYear))
      @foreach($byYear as $year => $yearDocs)
        <div class="mb-12">
          <h3 class="h3 mb-6 pb-4 border-b border-warm-grey">{{ $year }} {{ __('год', 'qazaqstan') }}</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($yearDocs as $doc)
              @php $file = qazaqstan_field('document_file', $doc->ID); @endphp
              <div class="flex gap-4 p-5 border border-warm-grey rounded-xl bg-white hover:border-klein-blue transition-colors">
                <div class="w-11 h-11 rounded-[10px] flex items-center justify-center flex-shrink-0 bg-klein-blue/8 text-klein-blue">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-display font-bold text-charcoal text-[14px] leading-snug">{{ esc_html($doc->post_title) }}</p>
                  @if($doc->post_excerpt)
                    <p class="text-soft-grey text-[12px] mt-1">{{ esc_html($doc->post_excerpt) }}</p>
                  @endif
                  @if(!empty($file['url']))
                    <a href="{{ esc_url($file['url']) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-klein-blue text-[13px] font-bold mt-2 hover:underline">
                      PDF
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    </a>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    @else
      <div class="text-center py-16 bg-off-white rounded-2xl">
        <p class="text-soft-grey text-[17px]">{{ __('Документы добавляются. Зайдите позже.', 'qazaqstan') }}</p>
      </div>
    @endif
  </div>
</section>

{{-- Контакт по закупкам --}}
<section class="section bg-off-white">
  <div class="container max-w-3xl">
    <p class="eyebrow text-center">{{ __('Вопросы', 'qazaqstan') }}</p>
    <h2 class="h2 mt-4 text-center">{{ __('Вопросы по закупкам', 'qazaqstan') }}</h2>
    <p class="text-center text-soft-grey mt-4 text-[17px]">{{ __('По всем вопросам, связанным с государственными закупками, обращайтесь в отдел снабжения.', 'qazaqstan') }}</p>
    <div class="flex flex-wrap justify-center gap-4 mt-8">
      <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--primary btn--lg">{{ esc_html($phone) }}</a>
      @if($email)
        <a href="mailto:{{ esc_attr($email) }}" class="btn btn--secondary btn--lg">{{ esc_html($email) }}</a>
      @endif
    </div>
  </div>
</section>

@endsection

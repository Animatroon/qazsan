<section class="cta-band text-center">
  <div class="container">
    <h2 class="h2">{{ $heading ?? __('Готовы к оздоровлению?', 'qazaqstan') }}</h2>
    <p class="mt-4 text-white/75 max-w-lg mx-auto text-[17px]">{{ $text ?? __('Оставьте заявку — подберём программу и подтвердим бронирование в течение 30 минут.', 'qazaqstan') }}</p>
    <div class="flex flex-wrap gap-3 mt-8 justify-center">
      <a href="{{ qazaqstan_url('/booking/') }}" class="btn btn--white btn--lg">{{ __('Забронировать путёвку', 'qazaqstan') }}</a>
      @php $phone = qazaqstan_option('phone_primary') ?: '+7 (727) 264-64-54'; @endphp
      <a href="{{ esc_url(qazaqstan_phone_link($phone)) }}" class="btn btn--ghost-white btn--lg">{{ esc_html($phone) }}</a>
    </div>
  </div>
</section>

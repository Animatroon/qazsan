@php
  $address = qazaqstan_option('address') ?: __('г. Алматы, пр. Достык, 308', 'qazaqstan');
  $phone1  = qazaqstan_option('phone_primary')   ?: '+7 (727) 264-64-54';
  $phone2  = qazaqstan_option('phone_secondary') ?: '+7 707 691 5008';
  $email   = qazaqstan_option('email') ?: 'info@kazakhstansan.kz';
  $year    = date('Y');
@endphp

<footer class="bg-footer-navy text-white">
  <div class="container py-16 lg:py-20">
    <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-5">

      <div class="lg:col-span-2">
        @include('partials.logo', ['white' => true])
        <p class="mt-3 text-white/70 max-w-xs text-[15px] leading-relaxed">
          {{ __('Многопрофильный санаторий в Алматы. Лечение, оздоровление и отдых у подножия Алатау с 1985 года.', 'qazaqstan') }}
        </p>
        <div class="mt-5 flex flex-col gap-2 text-[14px] text-white/75">
          <span>{{ esc_html($address) }}</span>
          <a href="{{ esc_url(qazaqstan_phone_link($phone1)) }}" class="hover:text-bright-cerulean transition-colors">{{ esc_html($phone1) }}</a>
          @if($phone2)
          <a href="{{ esc_url(qazaqstan_phone_link($phone2)) }}" class="hover:text-bright-cerulean transition-colors">{{ esc_html($phone2) }}</a>
          @endif
          @if($email)
          <a href="mailto:{{ esc_attr($email) }}" class="hover:text-bright-cerulean transition-colors">{{ esc_html($email) }}</a>
          @endif
        </div>

        @php($socials = qazaqstan_option('socials'))
        @if($socials)
        <div class="mt-5 flex gap-3">
          @foreach($socials as $s)
            @if(!empty($s['url']))
            <a href="{{ esc_url($s['url']) }}" class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center text-white/60 hover:text-white hover:border-white/50 transition-colors" target="_blank" rel="noopener noreferrer" aria-label="{{ esc_attr($s['type']) }}">
              @include('partials.social-icon', ['type' => $s['type']])
            </a>
            @endif
          @endforeach
        </div>
        @endif
      </div>

      <div>
        <p class="eyebrow text-white/50 text-[11px]">{{ __('Санаторий', 'qazaqstan') }}</p>
        <ul class="mt-4 space-y-2.5 text-[14px] text-white/80">
          <li><a href="{{ home_url('/about/') }}"         class="hover:text-bright-cerulean transition-colors">{{ __('О санатории', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/treatment/') }}"     class="hover:text-bright-cerulean transition-colors">{{ __('Услуги', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/accommodation/') }}" class="hover:text-bright-cerulean transition-colors">{{ __('Проживание', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/gallery/') }}"       class="hover:text-bright-cerulean transition-colors">{{ __('Галерея', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/blog/') }}"          class="hover:text-bright-cerulean transition-colors">{{ __('Блог и новости', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/contacts/') }}"      class="hover:text-bright-cerulean transition-colors">{{ __('Контакты', 'qazaqstan') }}</a></li>
        </ul>
      </div>

      <div>
        <p class="eyebrow text-white/50 text-[11px]">{{ __('Услуги', 'qazaqstan') }}</p>
        <ul class="mt-4 space-y-2.5 text-[14px] text-white/80">
          <li><a href="{{ home_url('/sport/') }}"          class="hover:text-bright-cerulean transition-colors">{{ __('Спорт и бассейн', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/conferences/') }}"    class="hover:text-bright-cerulean transition-colors">{{ __('Конференц-залы', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/services/') }}"       class="hover:text-bright-cerulean transition-colors">{{ __('Доп. услуги', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/booking/') }}"        class="hover:text-bright-cerulean transition-colors">{{ __('Бронирование', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/vacancies/') }}"      class="hover:text-bright-cerulean transition-colors">{{ __('Вакансии', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/procurement/') }}"    class="hover:text-bright-cerulean transition-colors">{{ __('Госзакупки', 'qazaqstan') }}</a></li>
          <li><a href="{{ home_url('/anti-corruption/') }}" class="hover:text-bright-cerulean transition-colors">{{ __('Антикоррупция', 'qazaqstan') }}</a></li>
        </ul>
      </div>

      <div>
        <p class="eyebrow text-white/50 text-[11px]">{{ __('Забронировать', 'qazaqstan') }}</p>
        <p class="mt-4 text-white/75 text-[14px] leading-relaxed">
          {{ __('Оставьте заявку — подберём программу и подтвердим в течение 30 минут.', 'qazaqstan') }}
        </p>
        <a href="{{ home_url('/booking/') }}" class="btn btn--white mt-5 w-full justify-center">{{ __('Забронировать онлайн', 'qazaqstan') }}</a>
        <a href="{{ esc_url(qazaqstan_phone_link($phone1)) }}" class="btn btn--ghost-white mt-3 w-full justify-center text-[13px]">{{ __('Позвонить', 'qazaqstan') }}</a>
      </div>

    </div>

    <div class="mt-12 pt-8 border-t border-white/10 text-sm text-white/50 flex flex-wrap justify-between gap-4">
      <p>© {{ $year }} {{ __('АО «Санаторий Казахстан». Все права защищены.', 'qazaqstan') }}</p>
      <div class="flex gap-4">
        <a href="{{ home_url('/privacy/') }}" class="hover:text-white/80 transition-colors">{{ __('Политика конфиденциальности', 'qazaqstan') }}</a>
        <span>kazakhstansan.kz</span>
      </div>
    </div>
  </div>
</footer>

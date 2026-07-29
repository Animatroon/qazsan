<form role="search" method="get" class="search-form flex gap-3 max-w-lg" action="{{ qazaqstan_url('/') }}">
  <label class="flex-1">
    <span class="sr-only">{{ __('Поиск по сайту', 'qazaqstan') }}</span>
    <input
      type="search"
      class="contact-form__input"
      placeholder="{{ esc_attr__('Поиск…', 'qazaqstan') }}"
      value="{{ get_search_query() }}"
      name="s"
    >
  </label>
  <button type="submit" class="btn btn--primary">{{ __('Найти', 'qazaqstan') }}</button>
</form>

<section class="section">
  <div class="container">
    <div class="prose prose-lg max-w-3xl">
      @php(the_content())
    </div>

    @if ($pagination())
      <nav class="page-nav mt-8" aria-label="{{ esc_attr__('Навигация по страницам', 'qazaqstan') }}">
        {!! $pagination !!}
      </nav>
    @endif
  </div>
</section>

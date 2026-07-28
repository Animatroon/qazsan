<!doctype html>
<html @php(language_attributes())>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#3872B8">
  @php(do_action('get_header'))
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@700;800&family=PT+Sans:ital,wght@0,400;0,700;1,400&display=swap">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @php(wp_head())
</head>
<body @php(body_class())>
  @php(wp_body_open())
  <div id="app">
    <a class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-klein-blue focus:text-white focus:rounded-md" href="#main">
      {{ __('Перейти к контенту', 'qazaqstan') }}
    </a>
    @include('partials.dev-notice')
    @include('sections.header')
    <main id="main">
      @yield('content')
    </main>
    @include('sections.footer')
  </div>
  @php(do_action('get_footer'))
  @php(wp_footer())
</body>
</html>

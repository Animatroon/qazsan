@php
  $post = get_post();
@endphp
@include('partials.blog-card', ['post' => $post])

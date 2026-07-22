<div class="auth-header">
  @if(isset($title))
    <h1>{{ $title }}</h1>
    @isset($subtitle)
      <p>{{ $subtitle }}</p>
    @endisset
  @endif
</div>
{{ $slot }}

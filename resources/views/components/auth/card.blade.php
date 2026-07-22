<div class="auth-card">
  @if(isset($title))
    <div class="auth-card-head">
      <h2>{{ $title }}</h2>
      @isset($subtitle)
        <p>{{ $subtitle }}</p>
      @endisset
    </div>
  @endif
  {{ $slot }}
</div>
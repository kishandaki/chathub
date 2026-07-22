<!DOCTYPE html>
<html lang="en" data-theme="{{ session('theme', 'light') }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'Chat HUB' }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}" />
  @stack('styles')
</head>
<body>
  <div class="auth-page">
    <div class="auth-container">
      @include('components.auth.logo')
      <main class="auth-main">
        @yield('content')
      </main>
      <div class="auth-footer">
        <p>&copy; {{ date('Y') }} Chat HUB. All rights reserved.</p>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/js/auth.js') }}"></script>
  @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en" data-theme="{{ session('theme', 'light') }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'Chat HUB' }}</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  @stack('styles')
</head>
<body>
  @yield('content')

  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>
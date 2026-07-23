@extends('layouts.auth')

@section('content')
<div class="auth-card fade-up">
  <h1 class="text-2xl font-semibold mb-4">Welcome back</h1>

  @if (session('status'))
    <div class="mb-4 rounded-md border border-green-300 bg-green-50 p-3 text-green-800">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    <div>
      <label class="mb-1 block text-sm font-medium">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-md border px-3 py-2" />
      @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="mb-1 block text-sm font-medium">Password</label>
      <input type="password" name="password" required class="w-full rounded-md border px-3 py-2" />
      @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center justify-between">
      <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="remember" />
        <span>Remember me</span>
      </label>

      <a class="text-sm underline" href="{{ route('password.request') }}">Forgot password?</a>
    </div>

    <button type="submit" class="w-full rounded-md bg-gray-900 px-4 py-2 text-white hover:bg-gray-800">Sign in</button>
  </form>
</div>
@endsection
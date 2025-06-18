<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
      <style>
      </style>
    @endif
  </head>
  <body>
  <nav class=" flex justify-center h-[100px] ">
    <div class="w-full flex items-center justify-between px-8   ">
      <div class="flex items-center w-[577px] justify-between">
        <a href="{{ route('main') }}" class="font-bold tracking-wide text-lg">SVTB CRISBAR</a>
        <div class="flex w-[340px] justify-between">
          <p class="text-purple-700">Program</p>
          <p>Mentor</p>
          <p>Pricing</p>
          <p>Business</p>
        </div>
      </div>
      <div class="w-[279px] flex justify-between">
        <a href="{{ route('auth.login') }}" class="bg-purple-200 px-[36px] py-[10px] rounded-[47px]">
          <p class="text-purple-700">Sign in</p>
        </a>
        <a href="{{ route('auth.register') }}" class="bg-purple-600 px-[36px] py-[10px] rounded-[47px]">
          <p class="text-white">Sign Up</p>
        </a>
      </div>
    </div>
  </nav>
  </body>
</html>

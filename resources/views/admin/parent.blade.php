<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Ruang Cerita by Farid Ahmad Fadhilah">
  <meta name="author" content="Farid Ahmad Fadhilah">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SVTB CRISBAR | @yield('title')</title>
  <!-- Favicon -->

  <!-- Fonts -->
  <link rel="stylesheet" href="{{ asset('vendors/@fortawesome/fontawesome-free/css/all.min.css') }}">
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('vendors/noty/noty.css') }}">

  <!-- Styles / Scripts -->
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else
    <style>
    </style>
  @endif

  @yield('styles')
  <script>
    var base_url = "{{ url('').'/' }}"
  </script>
</head>

<body class="bg-slate-50 h-screen">
  @include('admin.sidebar')
    <!-- Main content -->
  <div class="main-content h-full" id="panel">
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-100 to-orange-100 h-1/3">
     <div class="flex">
       <div class="w-xs">

       </div>
       <div class="">
        @include('admin.navbar')
        @php
        $auth = @\App\Helpers\AuthCommon::user();
        @endphp
        <!-- Header -->
        <div class="header pb-6 text-white" style="background: transparent;">
          <div class="container-fluid">
            <div class="header-body">
              <div class="row align-items-center py-4">
                @yield('breadcrum')
              </div>
            </div>
          </div>
        </div>
       </div>
     </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      @yield('page')
      <!-- Footer -->
      {{-- @include('admin.footer') --}}
    </div>
  </div>
</body>

  <script src="{{ asset('vendors/noty/noty.js') }}" type="text/javascript"></script>
  <script src="{{ asset('vendors/jquery/jquery-3.7.1.min.js') }}" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/global.js') }}"></script>
  @yield('scripts')
</html>

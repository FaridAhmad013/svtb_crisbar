<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="SVTB CRISBAR by Farid Ahmad Fadhilah">
  <meta name="author" content="Farid Ahmad Fadhilah">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SVTB CRISBAR | @yield('title')</title>

  <!-- Fonts -->
  <link href="{{ asset('fonts/lexend_deca.css') }}" rel="stylesheet">

  <!--  -->
  <link rel="stylesheet" href="{{ asset('vendors/@fortawesome/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/noty/noty.css') }}">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
  <link rel="stylesheet" href="{{ asset('vendors/sweetalert2/dist/sweetalert2.min.css') }}">

  {{-- Date CSS --}}
  <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/flatpickr/material_blue.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/flatpickr/monthSelect.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}" >
  <!-- Styles / Scripts -->
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif

  @yield('styles')
  <script>
    var base_url = "{{ url('').'/' }}"
  </script>
</head>

<body class="bg-slate-50 h-screen w-full antialiased">
  <div class="h-full">
    <div class="flex h-screen">
      <div class="min-w-3xs shrink-0 sidebar-container transition-all duration-300 ease-in-out">
        @include('admin.sidebar')
      </div>
      <div class="flex-1 overflow-auto">
        @include('admin.navbar')
        @php
        $auth = @\App\Helpers\AuthCommon::user();
        @endphp
        <!-- Header -->
        <div class="header px-5 py-10 text-white bg-gradient-to-r from-red-300 to-orange-300 w-full">
          <div class="container">
            <div class="header-body">
              <div class="row align-items-center py-4">
                @yield('breadcrum')
              </div>
            </div>
          </div>
        </div>

        <div class="container -mt-12 p-5">
          @yield('page')
        </div>
      </div>
    </div>
  </div>

  <div id="myModal" class="fixed inset-0 z-50 flex items-baseline justify-center bg-black/50 hidden">
    <div id="modal_dialog" class="bg-white rounded-lg shadow-lg w-2xl max-w-4xl mt-10 relative">
      <div class="flex items-center justify-between p-4 border-b border-gray-300 max-h-full">
        <h5 id="modal_title" class="text-lg"></h5>
        <button type="button" class="text-gray-500 hover:text-gray-700 text-lg cursor-pointer" data-dismiss="modal">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div id="modal_body" class="p-4 modal-content overflow-auto max-h-[600px]"></div>
      <div id="modal_footer" class="flex justify-end gap-2 p-4 border-t border-gray-300"></div>
    </div>
  </div>
</body>

<script src="{{ asset('js/autoNumeric.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/noty/noty.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/jquery/jquery-3.7.1.min.js') }}" crossorigin="anonymous"></script>
<script src="{{ asset('vendors/wizard/jquery.steps.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons CSS -->

<!-- DataTables Buttons JS + Ekstensi -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- JSZip & PDFMake untuk export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
<script src="{{ asset('vendors/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>

{{-- Date CSS --}}
<script src="{{ asset('vendors/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/flatpickr/monthSelect.js') }}"></script>

<script>
  $('#navbar-button-dropdown').click(function(){
    const navbar_dropdown = $('#navbar-dropdown')

    if(navbar_dropdown.css('display') == 'none'){
      navbar_dropdown.css('display', 'block')
    } else {
      navbar_dropdown.css('display', 'none')
    }
  })

  $(document).on('click', '[data-dismiss="modal"]', function () {
    Ryuna.close_modal();
  });

  $(document).ready(function () {
    $('#toggle-menu').on('click', function () {
      $('.menu-text').toggleClass('hidden');
      $('.sidebar-container').toggleClass('min-w-3xs w-22');
    });
  });
</script>
@yield('scripts')
</html>

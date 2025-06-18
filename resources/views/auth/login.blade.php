<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Ruang Cerita by Farid Ahmad Fadhilah">
  <meta name="author" content="Farid Ahmad Fadhilah">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SVTB CRISBAR</title>
  <!-- Favicon -->

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
  <script>
    var base_url = "{{ url('').'/' }}"
  </script>
</head>

<body class=" h-screen" style="background-image: url('{{ asset('img/wallpaper-1.png') }}'); background-position: center bottom; background-size: cover; background-repeat: no-repeat;">

  <div class="flex flex-wrap justify-end items-center h-screen">
    <div class="w-md p-3 mr-10">
      <div class="border border-gray-200 rounded-lg shadow-sm" style="background: rgba(255, 255, 255, 0.31)">
        <div class="p-6">
          <h1 class="text-center text-2xl font-extrabold my-3 tracking-widest">SVTB CRISBAR</h1>
          <hr class="border border-gray-300">
          <div class="my-5">
            <div class="text-gray-900 font-bold">Sign in to account</div>
            <p class="text-gray-900  mt-2">Enter your username & password to login</p>
          </div>

          <div id="response_container"></div>
          <form action="{{ route('auth.login_process') }}" method="post" id="myForm">
            @csrf

            <div class="mb-4">
              <label for="username" class="text-gray-900 block text-sm mb-1 font-medium">Username</label>
              <input type="text" name="username" id="username" class="border border-gray-600 text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5" autocomplete="off">
            </div>
            <div class="mb-4">
              <label for="username" class="text-gray-900 block text-sm mb-1 font-medium">Password</label>
              <input type="password" name="password" id="password" class="border border-gray-600 text-gray-900 text-sm rounded-lg  focus:outline-none block w-full p-2.5" autocomplete="off">
            </div>
            <div class="mt-5">
              <button type="button" class="bg-gray-800 text-white font-bold p-3 w-full block rounded-lg hover:bg-gray-900" id="btn-submit" onclick="save()">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  </body>


  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/global.js') }}"></script>
  <script>
    function save(){
      $('#response_container').empty();
      $('#btn-submit').prop('disabled', true)
      Ryuna.blockElement('.modal-content');
      let el_form = $('#myForm')
      let target = el_form.attr('action')
      let formData = new FormData(el_form[0])

      $.ajax({
        url: target,
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
      }).done((res) => {
        if(res?.status == true){
          let html = '<div class="p-3 bg-green-400 text-green-50 rounded-lg leading-[1.5] tracking-wide w-full">'
          html += `${res?.message}`
          html += '</div>'
          Ryuna.noty('success', '', res?.message)
          $('#response_container').html(html)
          Ryuna.unblockElement('.modal-content')

          if($('[name="_method"]').val() == undefined) el_form[0].reset()

          setTimeout(() => {
            $('#btn-submit').prop('disabled', false)
            window.location.href = `{{ route('dashboard.index') }}`
          }, 1000);
        }
      }).fail((xhr) => {
        $('#btn-submit').prop('disabled', false)
        if(xhr?.status == 422){
          let errors = xhr.responseJSON.errors
          let html = '<div class="mb-3 p-3 bg-rose-400 text-rose-50 text-sm rounded-lg leading-[1.5] tracking-wide w-full">'
          html += '<ul class="list-disc px-3">';
          for(let key in errors){
            html += `<li>${errors[key]}</li>`;
          }
          html += '</ul>'
          html += '</div>'
          $('#response_container').html(html)
          Ryuna.unblockElement('.modal-content')
        }else{
          let html = '<div class="mb-3 p-3 bg-rose-400 text-rose-50 text-sm rounded-lg leading-[1.5] tracking-wide w-full">'
          html += `${xhr?.responseJSON?.message}`
          html += '</div>'
          Ryuna.noty('error', '', xhr?.responseJSON?.message)
          $('#response_container').html(html)
          Ryuna.unblockElement('.modal-content')
        }
      })
    }
  </script>

</html>

<style>
  .step-header {
    padding-bottom: 10px;
    margin-bottom: 10px;
  }
  .step-list {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
  }
  .step-header-number{
    display: -ms-inline-flexbox;
    display: inline-flex;
    -ms-flex-line-pack: center;
    align-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 2em;
    height: 2em;
    padding: 0.5em 0;
    margin: 0.25rem;
    line-height: 1em;
    color: #fff;
    font-weight: 500;
    background-color: #6c757d;
    border-radius: 1em;
  }

  .step-button{
    text-align: center;
    padding: 0px 50px;
  }

  .step-header-number.active{
    color: #fff;
    background-color: var(--color-red-400);
  }

  .step-header-title{
    text-align: center;
  }

  .flatpickr-wrapper{
    width: 100% !important
  }

  .logo_image_picker{
    border-radius: 0.4rem !important;
    border: 1.5px dotted #dee2e6;
  }

  .image-hover-handler{
    transition: 0.5s;
  }
  .logo_image_picker:hover{
    .wrap_logo_image_picker{
      transform: scale(0.95)
    }

    .image-hover-handler{
      transform: scale(0.95)
    }
  }

  .wrap_logo_image_picker{
    transition: 0.5s;
  }
</style>

<div class="step-box">
  <div class="step-header">
    <div class="step-list">
      <div class="step-button" data-tab="1">
        <div class="step-header-number active">1</div>
        <div class="step-header-title">Karyawan</div>
      </div>
      <div class="step-button" data-tab="2">
        <div class="step-header-number">2</div>
        <div class="step-header-title">Pengguna</div>
      </div>
    </div>
  </div>

  <div class="step-body container" data-tab="1">
    <div class="flex flex-wrap mb-3">
      <div class="w-full md:w-1/2 pr-3">
        <label for="nama_depan" class="mb-1 block text-sm text-gray-700">Nama Depan</label>
        <input type="text" name="karyawan[nama_depan]" id="nama_depan" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm" placeholder="Masukan Nama Depan">
      </div>
      <div class="w-full md:w-1/2">
        <label for="nama_belakang" class="mb-1 block text-sm text-gray-700">Nama Belakang</label>
        <input type="text" name="karyawan[nama_belakang]" id="nama_belakang" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm" placeholder="Masukan Nama Belakang">
      </div>
    </div>
  </div>
  <div class="step-body" data-tab="2" style="display: none">
    <div class="mb-3">
      <label for="email" class="mb-1 block text-sm text-gray-700">Email</label>
      <input type="text" name="user[email]" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm" id="email" placeholder="contoh: karyawan@example.com">
    </div>
    <div class="mb-3">
      <label for="username" class="mb-1 block text-sm text-gray-700">Username</label>
      <input type="text" name="user[username]" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm" id="username" placeholder="contoh: farid_ahmad">
    </div>
    <div class="mb-3">
      <label for="password" class="mb-1 block text-sm font-medium text-gray-700">Password</label>
      <div class="relative">
        <input type="password" name="user[password]" id="password" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm pr-10" placeholder="Masukkan password Anda">
        <span class="absolute inset-y-0 right-0 flex items-center pr-3"><i class="fas fa-eye text-gray-400 cursor-pointer toggle-password" toggle="#password"></i></span>
      </div>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="mb-1 block text-sm font-medium text-gray-700">Konfirmasi Password</label>
        <div class="relative">
          <input type="password" name="user[password_confirmation]" id="password_confirmation" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm pr-10" placeholder="Ulangi password Anda">
          <span class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="fas fa-eye text-gray-400 cursor-pointer toggle-password" toggle="#password_confirmation"></i>
          </span>
        </div>
    </div>
  </div>
</div>

<script>
  var max_step = 2
  var stepper = new Stepper({
    max_step: max_step
  })

  $(() => {
     $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");

        let input = $($(this).attr("toggle"));

        if (input.attr("type") === "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
  })

  function nextStep() {
    let curr_position = stepper.position;
    let isValid = false;
    switch(curr_position) {
      case 1:
        isValid = validateStep1();
        $('.btn-prev').show()
        break;
      case 2:
        isValid = validateStep2();
        break;
      default:
        break;
    }

    if (!isValid) {
      return;
    }

    stepper.next();

    if (curr_position == max_step) {
        save();
      return;
    }

    $('.step-button[data-tab="'+stepper.position+'"] > .step-header-number').addClass('active')
    $('.step-body[data-tab="'+curr_position+'"]').hide()
    $('.step-body[data-tab="'+stepper.position+'"]').show()

    if(stepper.position == max_step){
      $('.btn-next').text('Simpan')
    }
  }

  function prevStep() {
    let curr_position = stepper.position
    stepper.prev()
    if(stepper.position < max_step){
      $('.btn-next').text('Lanjut')
    }

    console.log(stepper)
    if(stepper.position == 1){
      $('.btn-prev').hide()
    }

    $('.step-button[data-tab="'+curr_position+'"] > .step-header-number').removeClass('active')

    $('.step-body[data-tab="'+curr_position+'"]').hide()
    $('.step-body[data-tab="'+stepper.position+'"]').show()
  }

  function validateStep1() {
    let kosong = ''
    let nama_depan = $('[name="karyawan[nama_depan]"]').val()
    if (!nama_depan) {
      kosong += '<li>Kolom Nama Depan wajib diisi</li>'
    }

    let nama_belakang = $('[name="karyawan[nama_belakang]"]').val()
    if (!nama_belakang) {
      kosong += '<li>Kolom Nama Belakang wajib diisi</li>'
    }

    $('#response_container').empty()
    if(kosong){
      let message = `<div class="my-3 p-3 bg-rose-400 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full">
          <ul class="list-disc px-3">
            Step 1:
            <ul class="list-disc px-3">
              ${kosong}
            </ul>
          </ul>
        </div>`
      $('#response_container').html(message)
      return false;
    }
    return true;
  }

  function validateStep2() {
    let kosong = ''
    let email = $('[name="user[email]"]').val()
    if (!email) {
      kosong += '<li>Kolom Email wajib diisi</li>'
    }

    let username = $('[name="user[username]"]').val()
    if (!username) {
      kosong += '<li>Kolom Nama Belakang wajib diisi</li>'
    } else {
      const usernameRegex = /^(?!.*[_.]{2})(?![_.])[a-zA-Z0-9._]{3,20}(?<![_.])$/;
      if(!usernameRegex.test(username)){
        kosong += '<li>Username hanya boleh berisi huruf, angka, titik, dan underscore tanpa simbol berurutan atau di awal/akhir.</li>'
      }
    }

    let password = $('[name="user[password]"]').val()
    if (!password) {
      kosong += '<li>Kolom Password wajib diisi</li>'
    } else {
      if(!Ryuna.isPasswordValid(password, username)){
        kosong += '<li>Kolom Password harus terdiri dari setidaknya satu angka (0-9), satu huruf kecil (a-z), satu huruf besar (A-Z), satu karakter khusus (@, #, $, %, ^, &, +, =, !), setidaknya berjumlah 8 dan tidak mengandung username</li>';
      }
    }

    let password_confirmation = $('[name="user[password_confirmation]"]').val()
    if (!password_confirmation) {
      kosong += '<li>Kolom Konfirmasi Password wajib diisi</li>'
    } else {
      if(!Ryuna.isPasswordValid(password_confirmation, username)){
        kosong += '<li>Kolom Konfirmasi Password harus terdiri dari setidaknya satu angka (0-9), satu huruf kecil (a-z), satu huruf besar (A-Z), satu karakter khusus (@, #, $, %, ^, &, +, =, !), setidaknya berjumlah 8 dan tidak mengandung username</li>';
      }
    }

    if(password && password_confirmation){
      if(password != password_confirmation){
         kosong += '<li>Kolom Password dan Konfirmasi Password tidak sama</li>'
      }
    }


    $('#response_container').empty()
    if(kosong){
      let message = `<div class="my-3 p-3 bg-rose-400 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full">
          <ul class="list-disc px-3">
            Step 2:
            <ul class="list-disc px-3">
              ${kosong}
            </ul>
          </ul>
        </div>`
      $('#response_container').html(message)
      return false;
    }
    return true;
  }
</script>

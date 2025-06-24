@extends('admin.parent')

@section('title', $module_name)

@section('styles')
<style>
</style>
@endsection

@section('breadcrum')
<div class="flex items-center">
  <div class="text-xl mr-3 font-bold">{{ $group }}</div>
  <nav aria-label="breadcrumb" class="inline-block">
    <ol class="flex items-center space-x-2">
      <li class=""><a href="{{ route($module.'.index') }}"><i class="{{ $icon }}"></i></a></li>
      <li class="active" aria-current="page"><a href="{{ route($module.'.index') }}">{{ $module_name }}</a></li>
    </ol>
  </nav>
</div>
@endsection

@section('page')
<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="bg-white rounded-lg relative shadow-md">
      <div class="px-5 py-7 overflow-auto" id="box-aw">
        @include('admin.alert')
        <div class="my-3 p-3 bg-emerald-300 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full font-bold" id="catat_hasil_produksi_container" style="display: none">
         <i class="fas fa-info-circle"></i> Pencatatan Hasil Produksi untuk hari ini sudah selesai.
        </div>

        <form action="{{ route('catat_hasil_produksi.store') }}" method="post" id="myForm">
          @csrf
          <div id="response_container"></div>

          @if(!($sudah_melakukan_opname_pre_production && $sudah_melakukan_opname_post_production))
            @if(!$sudah_melakukan_opname_pre_production)
              <div class="my-3 p-3 bg-rose-300 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full font-bold">
                <i class="fas fa-exclamation-triangle"></i> Opname Pre-Production Belum Dilakukan
              </div>
            @endif

            @if(!$sudah_melakukan_opname_post_production)
              <div class="my-3 p-3 bg-rose-300 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full font-bold" >
                <i class="fas fa-exclamation-triangle"></i> Opname Post-Production Belum Dilakukan
              </div>
            @endif
          @endif

          <div class="my-3 p-3 bg-emerald-300 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full font-bold" id="catat_hasil_produksi_container" style="display: none">
            <i class="fas fa-info-circle"></i> Pencatatan Hasil Produksi untuk hari ini sudah selesai.
          </div>

          <div class="mb-5">
            <label for="tanggal" class="mb-1 block text-sm text-gray-700">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm disabled:bg-gray-100">
          </div>

          <div class="mb-5">
            <label for="nama_produk" class="mb-1 block text-sm text-gray-700">Nama Produk</label>
            <input type="text" id="nama_produk" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm disabled:bg-gray-100" value="{{ @$nama_produk }}">
          </div>

          <div class="mb-5">
            <label for="qty" class="mb-1 block text-sm text-gray-700">QTY</label>
            <input type="text" id="qty" name="qty" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm disabled:bg-gray-100"  value="{{ @$qty }}">
          </div>


          <div class="mb-3">
            <button type="button" class="focus:outline-none btn-simpan px-4 py-2 bg-red-400 disabled:bg-red-300 rounded-sm text-sm font-bold tracking-wide text-white transform  transition duration-300" onclick="save()">Simpan Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

<script>
  let _url = {
    check_sudah_melakukan_catat_hasil_produksi: `{{ route('catat_hasil_produksi.check_sudah_melakukan_catat_hasil_produksi', ':date') }}`,
  }

  let data_bahan = []
  check_sudah_melakukan_catat_hasil_produksi_bool = false

  $(() => {

    $('#tanggal').flatpickr({
      dateFormat: "d-m-Y",
      maxDate: 'today',
      maxDay: 'today',
      defaultDate: 'today',
      onChange: function(selectedDates, dateStr, instance) {

      }
    })

    @if(!($sudah_melakukan_opname_pre_production && $sudah_melakukan_opname_post_production))
      $('#tanggal').attr('disabled', true);
      $('#nama_produk').attr('disabled', true);
      $('#qty').attr('disabled', true);
      $('.btn-simpan').attr('disabled', true);
    @endif

    @if ($sudah_melakukan_catat_hasil_produksi)
      $('#tanggal').attr('disabled', true);
      $('#nama_produk').attr('disabled', true);
      $('#qty').attr('disabled', true);
      $('.btn-simpan').attr('disabled', true);
    @endif

    new AutoNumeric(document.getElementById('qty'), {
      digitGroupSeparator: '.',
      decimalCharacter: ',',
      decimalCharacterAlternative: '.',
      minimumValue: '0',
      decimalPlaces: 2,
      unformatOnSubmit: true,
    });

    check_sudah_melakukan_catat_hasil_produksi()
  })

  function check_sudah_melakukan_catat_hasil_produksi(){
    const date = $('#tanggal').val()

    $.get(_url.check_sudah_melakukan_catat_hasil_produksi.replace(':date', date)).done((res) => {
      check_sudah_melakukan_catat_hasil_produksi_bool = res.catat_hasil_produksi


      if(check_sudah_melakukan_catat_hasil_produksi_bool){
        $('#catat_hasil_produksi_container').show()
        $('#create').hide()
        $('.group-aksi').hide()
      }
    }).fail((xhr) => {
      console.log('gagal get sudah melakukan opname')
    })
  }

  function save(){
    $('#response_container').empty();
    $('.btn-simpan').attr('disabled', true);
    Ryuna.blockUI()
    let el_form = $('#myForm')
    let target = el_form.attr('action')
    let formData = new FormData(el_form[0])
    formData.append('nama_produk', '{{ @$nama_produk }}')

    $.ajax({
      url: target,
      data: formData,
      processData: false,
      contentType: false,
      type: 'POST',
    }).done((res) => {
      if(res?.status == true){
        let html = '<div class="mb-3 p-3 bg-emerald-300 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full">'
        html += `${res?.message}`
        html += '</div>'
        Ryuna.noty('success', '', res?.message)
        $('#response_container').html(html)

        setTimeout(() => {
          Ryuna.unblockUI()
          $('.btn-simpan').attr('disabled', false);
          window.location.reload()
        //   Ryuna.close_modal()
        }, 3000);
      }
    }).fail((xhr) => {
      $('.btn-simpan').attr('disabled', false);
      Ryuna.unblockUI()
      if(xhr?.status == 422){
        let errors = xhr.responseJSON.errors
        let html = '<div class="my-3 p-3 bg-rose-400 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full">'
        html += '<ul class="list-disc px-3">';
        for(let key in errors){
          html += `<li>${errors[key]}</li>`;
        }
        html += '</ul>'
        html += '</div>'
        $('#response_container').html(html)
      }else{
        let html = '<div class="my-3 p-3 bg-rose-400 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full">'
        html += `${xhr?.responseJSON?.message}`
        html += '</div>'
        Ryuna.noty('error', '', xhr?.responseJSON?.message)
        $('#response_container').html(html)
      }
    })
  }
</script>
@endsection

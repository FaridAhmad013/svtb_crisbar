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

        <div class="my-3 p-3 bg-rose-300 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full font-bold" id="sudah_melakukan_opname_container" style="display: none">

        </div>

        <div class="border-b border-gray-300 mt-3 mb-10">
          <h3 class="font-bold text-md"><i class="fas fa-filter"></i> Filter</h3>
          <div class="mb-5">
            <label for="Tanggal" class="mb-1 block text-sm text-gray-700">Tanggal</label>
            <input type="date" id="tanggal" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm">
          </div>

          <div class="mb-5">
            <label for="nama_produk" class="mb-1 block text-sm text-gray-700">Nama Produk</label>
            <input type="text" id="nama_produk" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm bg-gray-100" disabled>
          </div>
        </div>

        <div class="my-3 p-3 bg-emerald-300 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full font-bold" id="catat_hasil_produksi_container" style="display: none">
         <i class="fas fa-info-circle"></i> Pencatatan Hasil Produksi untuk hari ini sudah selesai.
        </div>
        <div class="relative">
          <table class="text-left w-full dt-wow">
            <thead>
              <tr>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Tanggal</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Nama Bahan</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-20">QTY</th>
                <th class="px-6 py-3 text-gray-400 font-light">Satuan</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Nilai Rupiah</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Nilai Persatuan</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Nama Karyawan</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Created At</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Updated At</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

<script>
  let _url = {
    datatable: `{{ route('datatable.'.$module) }}`,
    sudah_melakukan_opname: `{{ route($module.'.sudah_melakukan_opname', ':date') }}`,
    handle_update_qty: `{{ route($module.'.handle_update_qty', ':id') }}`,
    check_sudah_melakukan_catat_hasil_produksi: `{{ route('catat_hasil_produksi.check_sudah_melakukan_catat_hasil_produksi', ':date') }}`,
  }

  let data_bahan = []
  let check_sudah_melakukan_catat_hasil_produksi_bool = false


  let table;
  let _limit = 10;

  $(() => {

    $('#tanggal').flatpickr({
      dateFormat: "d-m-Y",
      maxDate: 'today',
      defaultDate: 'today',
      onChange: function(selectedDates, dateStr, instance) {
        sudah_melakukan_opname()
        table.draw()
      }
    })

    sudah_melakukan_opname()
    let dt_buttons = [
      {
        extend: 'colvis',
        text: '<i class="fas fa-columns"></i>',
        titleAttr: 'Column',
        tag: "button",
        className: "m-0 border border-gray-300 hover:outline-none transition duration-300"
      }
    ];

    table = $(".dt-wow").DataTable({
      language: {
        search: `<i class="fas fa-search"></i>`,
        infoFiltered: ``
      },
      order: [[0, 'asc']],
      dom: "<'flex flex-wrap justify-between'<'w-5/12'B><f><l>> <'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: dt_buttons,
      processing: true,
      serverSide: true,
      lengthMenu: [
        [50, 100, 250, 500, -1],
        [50, 100, 250, 500, 'All'],
      ],
      ajax: {
        url: _url.datatable,
        type: 'POST',
        beforeSend: function (request) {
          request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        data: d => {
          d.search['tanggal'] = $('#tanggal').val()
        }
      },
      columns: [
        {
          data: 'tanggal',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'nama_bahan',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'qty',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200',
          render: function (data, type, row) {
            return `<input type="text" name="qty" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm qty-input"  data-id="${row.id}" value="${data}">`;          }
          },
        {
          data: 'satuan',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'nilai_rupiah',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'nilai_persatuan',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'karyawan.nama_karyawan',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'created_at',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'updated_at',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
      ],
      drawCallback: function(settings) {
        const qtyInputs = document.querySelectorAll('.qty-input:not(.autonumeric-initialized)');

        qtyInputs.forEach((input) => {

          const anInput = new AutoNumeric(input, {
              digitGroupSeparator: '.',
              decimalCharacter: ',',
              decimalCharacterAlternative: '.',
              minimumValue: '0',
              decimalPlaces: 2,
              unformatOnSubmit: true,
          });

          // Tambahkan event listener saat user selesai mengedit (keluar dari input)
          input.addEventListener('focusout', function() {
              const id = this.getAttribute('data-id');
              // Panggil fungsi handle_update_qty dengan nilai numerik
              handle_update_qty(id, anInput.getNumericString());
          });

          // Tandai bahwa input ini sudah diinisialisasi untuk mencegah inisialisasi ganda
          input.classList.add('autonumeric-initialized');
        });
      },
      onInitComplete: function (settings, json) {
        check_sudah_melakukan_catat_hasil_produksi()
      },
      scrollY: (Ryuna.heightWindow() <= 660 ? 500 : (Ryuna.heightWindow() - 426)),
      scrollX: true
    });

    check_sudah_melakukan_catat_hasil_produksi()
  })

  function check_sudah_melakukan_catat_hasil_produksi(){
    const date = $('#tanggal').val()

    $.get(_url.check_sudah_melakukan_catat_hasil_produksi.replace(':date', date)).done((res) => {
      check_sudah_melakukan_catat_hasil_produksi_bool = res.catat_hasil_produksi


      if(check_sudah_melakukan_catat_hasil_produksi_bool){
        $('#catat_hasil_produksi_container').show()
        $('.qty-input').attr('disabled', true)
      }
    }).fail((xhr) => {
      console.log('gagal get sudah melakukan opname')
    })
  }

  function handle_update_qty(id, newValue) {

    if(!check_sudah_melakukan_catat_hasil_produksi_bool){
        $.ajax({
            url: _url.handle_update_qty.replace(':id', id),
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                qty: newValue
            },
            success: function(response) {
              Ryuna.noty('success', '', 'Kuantitas berhasil diperbarui!');
              table.draw()
            },
            error: function(xhr) {
              Ryuna.noty('error', '', 'Gagal memperbarui kuantitas.');
            }
        });
    }
  }


  function sudah_melakukan_opname(){
    const date = $('#tanggal').val()
    $('#sudah_melakukan_opname_container').hide()
    $.get(_url.sudah_melakukan_opname.replace(':date', date)).done((res) => {
      $('#sudah_melakukan_opname_container').hide()
      if(!res.sudah_melakukan_opname){
        $('#create').show()
        $('#sudah_melakukan_opname_container').show()
        $('#sudah_melakukan_opname_container').html('<i class="fas fa-exclamation-triangle"></i> Opname Post Production Belum Dilakukan')
      }
    }).fail((xhr) => {
      console.log('gagal get sudah melakukan opname')
    })
  }

  function create(){
    Ryuna.blockUI()
    $.get(_url.create).done((res) => {
      Ryuna.modal({
        title: res?.title,
        body: res?.body,
        footer: res?.footer
      })
      Ryuna.large_modal()
      Ryuna.unblockUI()
    }).fail((xhr) => {
      Ryuna.unblockUI()
      Swal.fire({
        title: 'Whoops!',
        text: xhr?.responseJSON?.message ? xhr.responseJSON.message : 'Internal Server Error',
        type: 'error',
        confirmButtonColor: '#007bff'
      })
    })
  }

  function show(id){
    Ryuna.blockUI()
    $.get(_url.show.replace(':id', id)).done((res) => {
      Ryuna.modal({
        title: res?.title,
        body: res?.body,
        footer: res?.footer
      })
      Ryuna.large_modal()
      Ryuna.unblockUI()
    }).fail((xhr) => {
      Ryuna.unblockUI()
      Swal.fire({
        title: 'Whoops!',
        text: xhr?.responseJSON?.message ? xhr.responseJSON.message : 'Internal Server Error',
        type: 'error',
        confirmButtonColor: '#007bff'
      })
    })
  }

  function edit(id){
    Ryuna.blockUI()
    $.get(_url.edit.replace(':id', id)).done((res) => {
      Ryuna.modal({
        title: res?.title,
        body: res?.body,
        footer: res?.footer
      })
      Ryuna.unblockUI()
    }).fail((xhr) => {
      Ryuna.unblockUI()
      Swal.fire({
        title: 'Whoops!',
        text: xhr?.responseJSON?.message ? xhr.responseJSON.message : 'Internal Server Error',
        type: 'error',
        confirmButtonColor: '#007bff'
      })
    })
  }

  function save(){
    $('#response_container').empty();
    $('.btn-next').attr('disabled', true);
    let el_form = $('#myForm')
    let target = el_form.attr('action')
    let formData = new FormData(el_form[0])
    formData.append('data_bahan', JSON.stringify(data_bahan))

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

        table.draw()

        sudah_melakukan_opname()
        setTimeout(() => {
          $('.btn-next').attr('disabled', false);
        //   Ryuna.close_modal()
        }, 3000);
      }
    }).fail((xhr) => {
      $('.btn-next').attr('disabled', false);
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

  function preview(){
    $('#btn-preview').attr('disabled', true)
    $('#table_preview tbody').empty()
    $('#response_container').empty()
    let formData = new FormData()
    const upload_file = document.getElementById('upload_file').files[0]
    formData.append('upload_file', upload_file)

    $.ajax({
      url: _url.preview,
      data: formData,
      processData: false,
      contentType: false,
      type: 'POST',
      beforeSend: function (request) {
        request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
      }
    }).done((res) => {
      if(res?.status == true){
        Ryuna.noty('success', '', res?.message)
        $('#table_preview').show()
        $('.btn-next').attr('disabled', false)
        $('#btn-submit').show() // Tampilkan tombol submit jika preview berhasil

        data_bahan = res.data
        res.data.map((item) => {
          // Menghitung nilai per satuan dengan aman, mencegah pembagian dengan nol
          const nilai_per_satuan = (item.qty > 0) ? (item.nilai_rupiah / item.qty) : 0;

          $('#table_preview tbody').append(`
            <tr>
              <td class="px-6 text-left py-3 font-medium text-sm text-gray-600 antialiased tracking-wide text-nowrap border-b border-gray-200">${item.nama_bahan}</td>
              <td class="px-6 text-left py-3 font-medium text-sm text-gray-600 antialiased tracking-wide text-nowrap border-b border-gray-200 text-center">${item.qty}</td>
              <td class="px-6 text-left py-3 font-medium text-sm text-gray-600 antialiased tracking-wide text-nowrap border-b border-gray-200 text-center">${item.satuan}</td>
              <td class="px-6 text-left py-3 font-medium text-sm text-gray-600 antialiased tracking-wide text-nowrap border-b border-gray-200 text-right">${Ryuna.format_nominal(item.nilai_rupiah)}</td>
              <td class="px-6 text-left py-3 font-medium text-sm text-gray-600 antialiased tracking-wide text-nowrap border-b border-gray-200 text-right">${Ryuna.format_nominal(nilai_per_satuan)}</td>
            </tr>
          `)
        })
        // Tidak perlu setTimeout, biarkan tombol aktif setelah selesai
        $('#btn-preview').attr('disabled', false)
      }
    }).fail((xhr) => {
      $('#btn-preview').attr('disabled', false);
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

  function destroy(id){
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data yang di hapus secara permanen!",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#007bff',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      console.log(result)
      if (result.value) {
        $.ajax({
          url: _url.delete.replace(':id', id),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'DELETE',
        }).done((res) => {
          Swal.fire({
            title: res.message,
            text: '',
            type: 'success',
            confirmButtonColor: '#007bff'
          })
          table.draw()
        }).fail((xhr) => {
          Swal.fire({
            title: xhr.responseJSON.message,
            text: '',
            type: 'error',
            confirmButtonColor: '#007bff'
          })
        })
      }
    })
  }


  function change_status(id, e){
    const blocked = $(e).prop("checked");

    Ryuna.blockElement('#box-aw');
    $.ajax({
      url: _url.change_status.replace(':id', id),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        blocked
      },
      type: 'POST',
    }).done((res) => {
      Ryuna.noty("success", "", res.message)
      table.draw()
      Ryuna.unblockElement('#box-aw');
    }).fail((xhr) => {
      Ryuna.noty("error", "", xhr.responseJSON.message)
      Ryuna.unblockElement('#box-aw');
    })
  }
</script>
@endsection

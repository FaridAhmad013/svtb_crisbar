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
        <div class="relative">
          <table class="text-left w-full dt-wow" style="width: 100% !important;">
            <thead>
              <tr>
                <th class="px-6 py-3 text-gray-400 font-light min-w-20">Aksi</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Nomor Karyawan</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Nama Lengkap</th>
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
    create: `{{ route($module.'.create') }}`,
    edit: `{{ route($module.'.edit', ':id') }}`,
    show: `{{ route($module.'.show', ':id') }}`,
    delete: `{{ route($module.'.destroy', ':id') }}`,
  }

  let table;
  let _limit = 10;

  $(() => {
    let dt_buttons = [
      {
        extend: 'colvis',
        text: '<i class="fas fa-columns"></i>',
        titleAttr: 'Column',
        tag: "button",
        className: "m-0 border border-gray-300 hover:outline-none transition duration-300"
      }
    ];

    dt_buttons.unshift({
      extend: 'print',
      text: '<i class="fas fa-file-pdf"></i>',
      titleAttr: 'pdf',
      tag: "button",
      className: "m-0 border border-gray-300 hover:outline-none transition duration-300"
    },
    {
      extend: 'csv',
      text: '<i class="fas fa-file-csv"></i>',
      titleAttr: 'csv',
      tag: "button",
      className: "m-0 border border-gray-300 hover:outline-none transition duration-300"
    },
    {
      extend: 'excelHtml5',
      text: '<i class="fas fa-file-excel"></i>',
      titleAttr: 'excel',
      tag: "button",
      className: "m-0 border border-gray-300 hover:outline-none hover:bg-gray-400"
    })


    dt_buttons.unshift( {
      text: '<i class="fas fa-plus"></i> Tambah',
      attr: { id: 'create' },
      action: function(e, dt, node, config ) {
        create()
      }
    })

    table = $(".dt-wow").DataTable({
      language: {
        search: `<i class="fas fa-search"></i>`,
        infoFiltered: ``
      },
      order: [[3, 'asc']],
      dom: "<'flex flex-wrap justify-between'<'w-5/12'B><f><l>> <'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: dt_buttons,
      processing: true,
      serverSide: true,
      lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All'],
      ],
      ajax: {
        url: _url.datatable,
        type: 'POST',
        beforeSend: function (request) {
          request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        }
      },
      columns: [
        {
          data: 'aksi',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200 text-center'
        },
        {
          data: 'nomor_karyawan',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'nama_karyawan',
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
      scrollY: (Ryuna.heightWindow() <= 660 ? 500 : (Ryuna.heightWindow() - 426)),
      scrollX: true
    });
  })

  function unblock(id){
    Swal.fire({
      title: 'Buka Blokir Pengguna?',
      text: "",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#007bff',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.value) {
        Ryuna.blockUI()
        $.ajax({
          url: _url.unblock.replace(':id', id),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
        }).done((res) => {
          Swal.fire({
            title: res.message,
            text: '',
            type: 'success',
            confirmButtonColor: '#007bff'
          })
          Ryuna.unblockUI()
          table.draw()
        }).fail((xhr) => {
          Swal.fire({
            title: xhr.responseJSON.message,
            text: '',
            type: 'error',
            confirmButtonColor: '#007bff'
          })
          Ryuna.unblockUI()
        })
      }
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

    $.ajax({
      url: target,
      data: formData,
      processData: false,
      contentType: false,
      type: 'POST',
    }).done((res) => {
      if(res?.status == true){
        let html = '<div class="mb-3 p-3 bg-green-300 text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full">'
        html += `${res?.message}`
        html += '</div>'
        Ryuna.noty('success', '', res?.message)
        $('#response_container').html(html)

        if($('[name="_method"]').val() == undefined) el_form[0].reset()
        table.draw()

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

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
          <table class="text-left w-full dt-wow">
            <thead>
              <tr>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Tanggal</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Nama Produk</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-20">QTY</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Nilai Bahan</th>
                <th class="px-6 py-3 text-gray-400 font-light min-w-46">Nilai Laporan Per Produksi</th>
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
  }

  let data_bahan = []
  let check_sudah_melakukan_catat_hasil_produksi_bool = false


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

    table = $(".dt-wow").DataTable({
      language: {
        search: `<i class="fas fa-search"></i>`,
        infoFiltered: ``
      },
      order: [[1, 'asc']],
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
          data: 'nama_produk',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'qty',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'nilai_bahan',
          className: 'mx-6 my-4 font-medium text-sm text-gray-600 antialiased  tracking-wide text-nowrap border-b border-gray-200'
        },
        {
          data: 'nilai_laporan_per_produksi',
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
</script>
@endsection

@extends('admin.parent')

@section('title', 'Beranda')


@section('breadcrum')
<div>
  <h1 class="text-3xl font-bold">{{ @$ucapan }}</h1>
  <h3 class="text xl font-bold" id="tanggal_saat_ini"></h3>
</div>
@endsection

@section('page')


@endsection

@section('scripts')
<script>
  $('#tanggal_saat_ini').html('<i class="fas fa-clock"></i> '+ Ryuna.format_tanggal_bahasa(moment()))
</script>
@endsection

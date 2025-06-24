@extends('admin.parent')

@section('title', 'Beranda')


@section('breadcrum')
<div>
  <h1 class="font-lora font-weight-bold tracking-wide" style="font-size: 3rem">{{ @$ucapan }}</h1>
</div>
@endsection

@section('page')

<div class="flex flex-wrap">
  <div class="w-full">
    <div class="flex flex-wrap">
      <div class="w-2/3">

      </div>
      <div class="w-1/3">

      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')
<script>
</script>
@endsection

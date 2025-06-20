@extends('admin.parent')

@section('title', 'Beranda')


@section('breadcrum')
<div>
  <h1 class="font-lora font-weight-bold tracking-wide" style="font-size: 3rem">{{ @$ucapan }}</h1>
</div>
@endsection

@section('page')

<div class="row">
  <div class="col-12">
    <div class="card card-new">
      <div class="card-header">
        <h2><i class="fas fa-book-open"></i> Ringkasan</h2>
      </div>
      <div class="card-body bg-secondary">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-new wrap-total_pengguna">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="col-10">
                    <h3>Total Pengguna</h3>
                    <h1 id="total_pengguna">0</h1>
                  </div>
                  <div class="col-4">
                    <div class="icon icon-shape bg-default shadow-default text-center rounded-circle">
                      <i class="fas fa-users text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-new wrap-total_pertanyaan">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="col-10">
                    <h3>Total Pertanyaan</h3>
                    <h1 id="total_pertanyaan">0</h1>
                  </div>
                  <div class="col-4">
                    <div class="icon icon-shape bg-warning shadow-warning text-center rounded-circle">
                      <i class="fas fa-question text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-new wrap-entry_jurnal_hari_ini">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="col-10">
                    <h3>Entri Jurnal Hari Ini</h3>
                    <h1 id="total_entry_jurnal_hari_ini">0</h1>
                  </div>
                  <div class="col-4">
                    <div class="icon icon-shape bg-info shadow-info text-center rounded-circle">
                      <i class="fas fa-calendar-check text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-new wrap-pengguna_aktif">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="col-10">
                    <h3>Pengguna Aktif (Bulan Ini)</h3>
                    <h1 id="total_pengguna_aktif">0</h1>
                  </div>
                  <div class="col-4">
                    <div class="icon icon-shape bg-success shadow-success text-center rounded-circle">
                      <i class="fas fa-chart-bar text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')
<script>
</script>
@endsection

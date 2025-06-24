@extends('admin.parent')

@section('title', 'Dashboard')


@section('breadcrum')
<div>
  <h1 class="text-3xl font-bold">{{ @$ucapan }}</h1>
  <h3 class="text xl font-bold" id="tanggal_saat_ini"></h3>
</div>
@endsection

@section('page')

<div class="flex flex-wrap">
  <div class="w-full">
    <div class="flex flex-wrap">
      <div class="w-2/3 p-2">
        <div class="bg-white rounded-lg relative shadow py-2">
         <div class="px-5 text-2xl">📌</div>
          <div class="px-5 pb-2 overflow-auto">
            @if (!$sudah_melakukan_opname_pre_production)
              <h1 class="font-bold text-md text-gray-700 leading-[1.5] tracking-wide">Apa yang perlu dilakukan sekarang? 🤔</h1>
              <div class="text-sm text-gray-600 leading-[1.5] tracking-wide mt-3">
                Anda belum melakukan opname stok pagi untuk produksi hari ini. Silakan mulai dengan mencatat stok bahan baku awal.
              </div>
              <a class="rounded-lg block text-center px-4 py-2 bg-rose-50 border-3 border-rose-300 hover:bg-rose-300 disabled:bg-rose-300 hover:text-white text-rose-300 text-sm font-bold mt-3" href="{{ route('opname_pre_production.index') }}"><i class="fas fa-clipboard-list text-xl"></i> Mulai Opname Pre-Production</a>
            @elseif (!$sudah_melakukan_opname_post_production)
              <h1 class="font-bold text-md text-gray-700 leading-[1.5] tracking-wide">Opname Pre-Production Selesai! ✅</h1>
              <div class="text-sm text-gray-600 leading-[1.5] tracking-wide mt-3">
                Stok awal untuk produk **"{{ @$nama_produk }}"** telah tercatat. Jangan lupa mencatat Opname Post-Production.
              </div>
              <a class="rounded-lg block text-center px-4 py-2 bg-rose-50 border-3 border-rose-300 hover:bg-rose-300 disabled:bg-rose-300 hover:text-white text-rose-300 text-sm font-bold mt-3" href="{{ route('opname_post_production.index') }}"><i class="fas fa-clipboard-list text-xl"></i> Mulai Opname Post-Production</a>
            @elseif (!$catat_hasil_produksi)
               <h1 class="font-bold text-md text-gray-700 leading-[1.5] tracking-wide">Opname Pre-Production & Opname Post-Production Selesai! ✅</h1>
              <div class="text-sm text-gray-600 leading-[1.5] tracking-wide mt-3">
                Stok awal untuk produk **"{{ @$nama_produk }}"** telah tercatat. Jangan lupa mencatat total hasil produksi .
              </div>
              <a class="rounded-lg block text-center px-4 py-2 bg-rose-50 border-3 border-rose-300 hover:bg-rose-300 disabled:bg-rose-300 hover:text-white text-rose-300 text-sm font-bold mt-3" href="{{ route('catat_hasil_produksi.index') }}"><i class="fas fa-clipboard-list text-xl"></i> Mulai Catat Hasil Produksi</a>
            @else
              <h1 class="font-bold text-md text-gray-700 leading-[1.5] tracking-wide">Kerja Bagus! Semua Selesai untuk Hari Ini 🎉</h1>
              <div class="text-sm text-gray-600 leading-[1.5] tracking-wide mt-3">
                Semua proses produksi untuk tanggal hari ini telah selesai dicatat. Sampai jumpa besok!
              </div>
            @endif
          </div>
        </div>
      </div>
      <div class="w-1/3 p-2">
        <div class="bg-white rounded-lg relative shadow py-2">
         <div class="px-5 text-2xl">📌</div>
          <div class="px-5 pb-2 overflow-auto">
            <h1 class="font-bold text-md text-gray-700 leading-[1.5] tracking-wide">STATUS PROSES HARI INI</h1>
            <div class="rounded-lg block text-center px-4 py-2 border-3
              @if (!$sudah_melakukan_opname_pre_production)
                bg-rose-50 border-rose-300 hover:bg-rose-300 disabled:bg-rose-300 text-rose-300
              @else
                bg-emerald-50 border-emerald-300 hover:bg-emerald-300 disabled:bg-emerald-300 text-emerald-300
              @endif
              hover:text-white text-xs font-bold mt-3">
              <div class="flex items-center justify-between">
                <div>Opname Pre-Production</div>
                <div class="w-[5%] text-xl">@if (!$sudah_melakukan_opname_pre_production) <i class="fas fa-times text-rose 300"></i> @else <i class="fas fa-checked text-emerald-300"></i> @endif</div>
              </div>
            </div>

            <div class="rounded-lg block text-center px-4 py-2 border-3
              @if (!$sudah_melakukan_opname_post_production)
                bg-rose-50 border-rose-300 hover:bg-rose-300 disabled:bg-rose-300 text-rose-300
              @else
                bg-emerald-50 border-emerald-300 hover:bg-emerald-300 disabled:bg-emerald-300 text-emerald-300
              @endif
              hover:text-white text-xs font-bold mt-3">
              <div class="flex items-center justify-between">
                <div>Opname Post-Production</div>
                <div class="w-[5%] text-xl">@if (!$sudah_melakukan_opname_post_production) <i class="fas fa-times text-rose 300"></i> @else <i class="fas fa-checked text-emerald-300"></i> @endif</div>
              </div>
            </div>

             <div class="rounded-lg block text-center px-4 py-2 border-3
              @if (!$catat_hasil_produksi)
                bg-rose-50 border-rose-300 hover:bg-rose-300 disabled:bg-rose-300 text-rose-300
              @else
                bg-emerald-50 border-emerald-300 hover:bg-emerald-300 disabled:bg-emerald-300 text-emerald-300
              @endif
              hover:text-white text-xs font-bold mt-3">
              <div class="flex items-center justify-between">
                <div>Catat Hasil Produksi</div>
                <div class="w-[5%] text-xl">@if (!$catat_hasil_produksi) <i class="fas fa-times text-rose 300"></i> @else <i class="fas fa-checked text-emerald-300"></i> @endif</div>
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
  $('#tanggal_saat_ini').html('<i class="fas fa-clock"></i> '+ Ryuna.format_tanggal_bahasa(moment()))
</script>
@endsection

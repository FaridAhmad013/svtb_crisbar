<div class="mb-3 p-3 bg-emerald-300 text-white text-sm rounded-sm leading-[1.5] tracking-wide w-full">
  <b class="font-bold">Langkah 1: Isi Formulir Produksi</b>

</div>

<div class="py-1">
  <div class="mb-3">
    <label class="text-gray-700 text-sm mb-1 block">Tanggal</label>
    <input type="date" name="tanggal" id="tanggal_filter" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm" placeholder="DD-MM-YYYY">
  </div>

  <div>
    <label for="nama_produk" class="text-gray-700 text-sm mb-1 block">Nama Produk</label>
    <input type="text" id="nama_produk" name="nama_produk" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm disabled:bg-gray-100" placeholder="Contoh: Bumbu Crisbar Melong 500gr">
  </div>
</div>

<div class="my-4 p-3 bg-emerald-300 text-white text-sm rounded-sm leading-[1.5] tracking-wide w-full">
  <b class="font-bold">Langkah 2: Unduh dan Isi Template</b>
</div>

<div class="py-4">
  <a href="{{ asset('templates/template_opname_pre_production.csv') }}" class="bg-rose-50 border-3 border-rose-300 px-2 py-3 rounded-lg hover:bg-rose-300 disabled:bg-rose-300 hover:text-white text-rose-300 text-sm font-bold" download=""><i class="fas fa-download"></i> Download Template Data Bahan</a>
</div>


<div class="my-4 p-3 bg-emerald-300 text-white text-sm rounded-sm leading-[1.5] tracking-wide w-full">
  <b class="font-bold">Langkah 3: Unggah dan Lihat Preview</b>
</div>

<div class="py-1">
  <div class="mb-3">
    <label for="upload_file" class="text-gray-700 text-sm mb-1 block">Data Bahan</label>
    <div class="flex items-center">
      <div class="w-lg">
        <input type="file" id="upload_file" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm">
      </div>
      <div class="ml-3">
        <button type="button" class="bg-rose-50 border-3 border-rose-300 px-2 py-3 rounded-lg hover:bg-rose-300 disabled:bg-rose-300 hover:text-white text-rose-300 text-sm font-bold" onclick="preview()" id="btn-preview"><i class="fas fa-upload"></i> Preview Unggah Data</button>
      </div>
    </div>
  </div>

  <div class="w-full overflow-auto">
    <table class="text-left w-full table-auto my-3" id="table_preview" style="display: none">
      <thead>
        <tr>
          <th class="px-6 py-3 text-gray-600 bg-gray-100 font-bold min-w-46">Nama Bahan</th>
          <th class="px-6 py-3 text-gray-600 bg-gray-100 font-bold min-w-20">QTY</th>
          <th class="px-6 py-3 text-gray-600 bg-gray-100 font-bold min-w-46">Satuan</th>
          <th class="px-6 py-3 text-gray-600 bg-gray-100 font-bold min-w-46">Nilai (Rp.)</th>
          <th class="px-6 py-3 text-gray-600 bg-gray-100 font-bold min-w-46">Nilai Per Satuan</th>
        </tr>
      </thead>
      <tbody id="tbody_preview">

      </tbody>
    </table>
  </div>
</div>

<div class="my-3 p-3 bg-emerald-300 text-white text-sm rounded-sm leading-[1.5] tracking-wide w-full">
  <b class="font-bold">Langkah 4: Simpan Data</b>
</div>

<script>
  $('#tanggal_filter').flatpickr({
    dateFormat: "d-m-Y",
    minDate: 'today',
    maxDate: 'today'
  })
</script>

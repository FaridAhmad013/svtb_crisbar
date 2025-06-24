<div class="mb-7 p-3 bg-[#90CDF4] text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full">
  Langkah 1: Isi Formulir Produksi
  <ul class="list-disc px-3">
    <li>Pastikan Tanggal Produksi sudah sesuai.</li>
    <li>Isi Nama Produk yang akan dihasilkan hari ini (contoh: "Bumbu Crisbar Melong 500gr").</li>
  </ul>
</div>

<div class="mb-3">
  <label class="text-gray-700 text-sm mb-1 block">Tanggal</label>
  <input type="date" name="tanggal" id="tanggal_filter" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm" placeholder="DD-MM-YYYY">
</div>

<div class="mb-3">
  <label for="nama_produk" class="text-gray-700 text-sm mb-1 block">Nama Produk</label>
  <input type="text" id="nama_produk" name="nama_produk" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm" placeholder="Contoh: Bumbu Crisbar Melong 500gr">
</div>

<div class="my-7 p-3 bg-[#90CDF4] text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full">
  Langkah 2: Unduh dan Isi Template
  <ul class="list-disc px-3">
    <li>Klik tombol [↓ Download Template] untuk mengunduh file CSV</li>
    <li>Buka file tersebut dan isi daftar bahan baku Anda sesuai kolom yang ada: nama_bahan, qty, satuan, dan nilai_rupiah. Simpan file setelah selesai.</li>
  </ul>
</div>

<div class="p-2 mb-3">
  <a href="{{ asset('templates/template_opname_pre_production.csv') }}" class="bg-green-50 border-3 border-green-400 px-4 py-3 rounded-lg hover:bg-green-400 hover:text-white text-green-400" download="">Download Template</a>
</div>


<div class="my-7 p-3 bg-[#90CDF4] text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full">
  Langkah 3: Unggah dan Lihat Preview
  <ul class="list-disc px-3">
    <li>Klik tombol [↑ Upload File] dan pilih file template yang sudah Anda isi.</li>
    <li>Setelah file terunggah, klik tombol [Lihat Preview]. Data bahan baku akan muncul di tabel di bawah untuk Anda periksa kembali.</li>
  </ul>
</div>

<div class="mb-3">
  <label for="upload_file" class="text-gray-700 text-sm mb-1 block">Nama Produk</label>
  <div class="flex items-center">
    <div class="w-lg">
      <input type="file" id="upload_file" class="w-full rounded-md border border-gray-300 text-gray-700 tracking-wide focus:outline-none px-2 py-3 text-sm">
    </div>
    <div class="ml-3">
      <button type="button" class="bg-red-50 border-3 border-red-400 px-2 py-3 rounded-lg hover:bg-red-400 disabled:bg-red-300 hover:text-white text-red-400" onclick="preview()" id="btn-preview">Preview</button>
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

<div class="my-7 p-3 bg-[#90CDF4] text-white text-sm rounded-lg leading-[1.5] tracking-wide w-full">
  Langkah 4: Simpan Data
  <ul class="list-disc px-3">
    <li>Jika data pada tabel preview sudah benar, klik tombol [Simpan Data Opname Pre Production] di bagian paling bawah untuk menyelesaikan proses.</li>
  </ul>
</div>


<script>
  $('#tanggal_filter').flatpickr({
    dateFormat: "d-m-Y",
    minDate: 'today',
    maxDate: 'today'
  })
</script>

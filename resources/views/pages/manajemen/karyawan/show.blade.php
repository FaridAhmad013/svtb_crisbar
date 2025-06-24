<div class="overflow-auto">
  <table class="table-auto border-collapse w-full text-left text-sm">
    <tr>
      <td class="bg-gray-100 text-gray-700 p-3 leading-[1.5] tracking-wide w-1/3">Nomor Karyawan</td>
      <th class="bg-white text-gray-700 p-3 leading-[1.5] tracking-wide">{{ @$data->nomor_karyawan }}</th>
    </tr>
    <tr>
      <td class="bg-gray-100 text-gray-700 p-3 leading-[1.5] tracking-wide w-1/3">Nama Karyawan</td>
      <th class="bg-white text-gray-700 p-3 leading-[1.5] tracking-wide">{{ @$data->username }}</th>
    </tr>
    <tr>
      <td class="bg-gray-100 text-gray-700 p-3 leading-[1.5] tracking-wide w-1/3">Created At</td>
      <th class="bg-white text-gray-700 p-3 leading-[1.5] tracking-wide">{{ @$data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s') : '-' }}</th>
    </tr>
    <tr>
      <td class="bg-gray-100 text-gray-700 p-3 leading-[1.5] tracking-wide w-1/3">Updated At</td>
      <th class="bg-white text-gray-700 p-3 leading-[1.5] tracking-wide">{{ @$data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d-m-Y H:i:s') : '-' }}</th>
    </tr>
  </table>
</div>

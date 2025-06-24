<?php

namespace App\Http\Controllers\ProsesProduksiHarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\OpnamePreProductionDataTable;
use App\Helpers\AuthCommon;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Models\OpnamePostProduction;
use App\Models\OpnamePreProduction;
use App\Models\QtyProduksi;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class OpnamePreProductionController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = 'opname_pre_production';
        $this->module_name = 'Opname (Pre-Production)';
        $this->folder = 'proses_produksi_harian.opname_pre_production';
    }

    public function index()
    {
        $user = AuthCommon::user() ?? null;
        if (!in_Array(@$user->role->role, ['Karyawan'])) abort('403');

        $allow = json_encode($this->allow);

        $group = "Proses Produksi Harian";
        $icon = "fas fa-sun";
        $module = $this->module;
        $module_name = $this->module_name;

        return view('pages.' . $this->folder . '.list', compact('allow', 'group', 'icon', 'module', 'module_name'));
    }
    public function sudah_melakukan_opname($date){
        $sudah_melakukan_opname = false;
        $date = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');

        try {
            $sudah_melakukan_opname = OpnamePreProduction::whereDate('tanggal', $date)->first() ? true : false;
        } catch (\Throwable $th) {
            $sudah_melakukan_opname = false;
        }

        return response([
            'status' => true,
            'sudah_melakukan_opname' => $sudah_melakukan_opname
        ], 200);
    }

    public function create()
    {
        $user = AuthCommon::user();
        if (!in_Array(@$user->role->role, ['Karyawan'])) {
            $body = '<h3>403 | Forbidden</h3>';
            $footer = '<button type="button" class="px-4 py-2 bg-gray-100 rounded-sm text-sm hover:bg-gray-200 border border-gray-300 transform  transition duration-300" data-dismiss="modal">Tutup</button>';
        } else {
            $body = view('pages.' . $this->folder . '.create', [
                'module' => $this->module,
                'module_name' => $this->module_name,
                'folder' => $this->folder,
            ])->render();
            $footer = '<button type="button" class="focus:outline-none px-4 py-2 bg-gray-100 rounded-sm text-sm hover:bg-gray-200 border border-gray-300 transform  transition duration-300" data-dismiss="modal">Tutup</button>
                <button type="button" class="focus:outline-none btn-next px-4 py-2 bg-red-400 disabled:bg-red-300 rounded-sm text-sm font-bold tracking-wide text-white transform  transition duration-300" onclick="save()" disabled>Simpan Data</button>';
        }

        return [
            'title' => 'Tambah '.$this->module_name,
            'body' => $body,
            'footer' => $footer
        ];
    }


    public function store(Request $request)
    {
        $rules = [
            'tanggal' => 'required',
            'nama_produk' => 'required',
            'data_bahan' => 'required'
        ];

        $message = [
            'tanggal.required' => 'Kolom Tanggal tidak boleh kosong',
            'nama_produk.required' => 'Kolom Nama Produk tidak boleh kosong',
            'data_bahan.required' => 'Kolom Data Bahan tidak boleh kosong',

        ];
        $request->validate($rules, $message);



        $formData = $request->only([
            'tanggal',
            'nama_produk',
            'data_bahan'
        ]);

        $formData['data_bahan'] = json_decode($formData['data_bahan']);

        if(count($formData['data_bahan']) <= 0){
            return response([
                'status' => false,
                'message' => 'Data Bahan Wajib Diisi'
            ], 400);
        }

        $formData['data_bahan'] = collect($formData['data_bahan'])->map(function($item) use ($formData){
            $item->karyawan_id = @AuthCommon::user()->karyawan->id;
            $item->tanggal = Carbon::parse($formData['tanggal'])->format('Y-m-d');
            $item->nama_produk = @$formData['nama_produk'];
            $item->nilai_persatuan = @$item->nilai_rupiah/$item->qty;
            return $item;
        });

        $catat_hasil_produksi = QtyProduksi::whereDate('tanggal', Carbon::parse($formData['tanggal'])->format('Y-m-d'))->first();
        if($catat_hasil_produksi){
            return response([
                'status' => false,
                'message' => 'Gagal membuat opname, tanggal '.$catat_hasil_produksi->tanggal.' sudah melakukan catat hasil produksi'
            ], 400);
        }
        DB::beginTransaction();
        try{
            for($i = 0; $i < count($formData['data_bahan']); $i++){
                if(@$formData['data_bahan'][$i]){
                    OpnamePreProduction::create( (array) $formData['data_bahan'][$i]);
                    OpnamePostProduction::create( (array) $formData['data_bahan'][$i]);
                    DB::commit();
                }
            }
            return response([
                'status' => true,
                'message' => ResponseConstant::RM_CREATE_SUCCESS
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_UPDATE_FAILED,
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function preview(Request $request)
    {
        // Validasi awal untuk file upload
        $rules = [ 'upload_file' => 'required|file|mimes:csv,txt' ];
        $message = [
            'upload_file.required' => 'Kolom File tidak boleh kosong',
            'upload_file.file' => 'Kolom File harus berupa file',
            'upload_file.mimes' => 'Kolom File harus berupa file dengan ekstensi .csv atau .txt',
        ];
        // Menggunakan Validator::make agar bisa mengembalikan response JSON kustom
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first(), 'data' => null], 422);
        }

        try {
            $file = $request->file('upload_file');
            $path = $file->getRealPath();
            $file_handle = fopen($path, 'r');

            // 1. Validasi Header
            $header = fgetcsv($file_handle, 1000, ',');
            $requiredHeader = ['nama_bahan', 'qty', 'satuan', 'nilai_rupiah'];

            if ($header !== $requiredHeader) {
                fclose($file_handle);
                return response()->json([
                    'status'  => false,
                    'message' => 'Struktur header CSV tidak sesuai. Pastikan urutannya adalah: nama_bahan,qty,satuan,nilai_rupiah',
                    'data'    => null
                ], 400);
            }

            $data = [];
            $rowNumber = 1; // Untuk melacak baris jika ada error

            // 2. Looping, Validasi per Baris, dan Konversi Data
            while (($row = fgetcsv($file_handle, 1000, ',')) !== FALSE) {
                if (count($row) !== count($header)) {
                     return response()->json([
                        'status'  => false,
                        'message' => "Data tidak valid pada baris ke-{$rowNumber}: Jumlah kolom tidak sesuai dengan header.",
                        'data'    => null
                    ], 400);
                }

                $rowData = array_combine($header, $row);

                // Konversi dan validasi nilai_rupiah
                $nilai_rupiah_str = $rowData['nilai_rupiah'];
                $cleaned_nilai_rupiah = (int) preg_replace('/[^\d]/', '', $nilai_rupiah_str);

                // Konversi dan validasi qty
                $qty_str = str_replace(',', '.', $rowData['qty']); // Ganti koma jadi titik untuk desimal
                if (!is_numeric($qty_str) || (float)$qty_str < 0) {
                    fclose($file_handle);
                    return response()->json([
                        'status'  => false,
                        'message' => "Data tidak valid pada baris ke-{$rowNumber}: QTY '{$rowData['qty']}' harus berupa angka dan tidak boleh kurang dari 0.",
                        'data'    => null
                    ], 400);
                }
                $cleaned_qty = (float) $qty_str;

                // Memasukkan data yang sudah bersih ke array
                $data[] = [
                    'nama_bahan' => trim($rowData['nama_bahan']),
                    'qty' => $cleaned_qty,
                    'satuan' => trim($rowData['satuan']),
                    'nilai_rupiah' => $cleaned_nilai_rupiah,
                ];

                $rowNumber++;
            }

            fclose($file_handle);

            if (empty($data)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'File CSV yang Anda unggah tidak berisi data.',
                    'data'    => []
                ], 400);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Preview data berhasil dimuat.',
                'data'    => $data
            ], 200);

        } catch (Exception $th) {
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat memproses file: ' . $th->getMessage(),
                'data'    => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        $auth = AuthCommon::user() ?? null;
        if (!in_array(@$auth->role->role, ['Karyawan'])) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }

        try {
            $opname = OpnamePreProduction::find($id);

            $catat_hasil_produksi = QtyProduksi::whereDate('tanggal', Carbon::parse($opname->tanggal)->format('Y-m-d'))->first();
            if($catat_hasil_produksi){
                return response([
                    'status' => false,
                    'message' => 'Gagal membuat opname, tanggal '.$catat_hasil_produksi->tanggal.' sudah melakukan catat hasil produksi'
                ], 400);
            }
            OpnamePreProduction::where('id', $id)->delete();

            return response([
                'status' => true,
                'message' => ResponseConstant::RM_DELETE_SUCCESS
            ]);
        } catch (\Throwable $th) {
            return response([
                "status" => false,
                "message" => ResponseConstant::RM_DELETE_FAILED,
                "error" => $th->getMessage()
            ], 400);
        }
    }

    public function datatable(OpnamePreProductionDataTable $dataTable){
        return $dataTable->render('datatable');
    }
}

<?php

namespace App\Http\Controllers\ProsesProduksiHarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\OpnamePreProductionDataTable;
use App\Helpers\AuthCommon;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Models\LaporanProduksi;
use App\Models\OpnamePostProduction;
use App\Models\OpnamePreProduction;
use App\Models\QtyProduksi;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class CatatHasilProduksiController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = 'catat_hasil_produksi';
        $this->module_name = 'Catat Hasil Produksi';
        $this->folder = 'proses_produksi_harian.catat_hasil_produksi';
    }

    public function index()
    {
        $user = AuthCommon::user() ?? null;
        if (!in_Array(@$user->role->role, ['Karyawan'])) abort('403');

        $allow = json_encode($this->allow);

        $group = "Proses Produksi Harian";
        $icon = "fas fa-box";
        $module = $this->module;
        $module_name = $this->module_name;

        $date = Carbon::now()->format('Y-m-d');
        $pre_production = OpnamePreProduction::whereDate('tanggal', $date)->first();
        $sudah_melakukan_opname_pre_production = false;
        try {
            $sudah_melakukan_opname_pre_production = $pre_production ? true : false;
        } catch (\Throwable $th) {
            $sudah_melakukan_opname_pre_production = false;
        }


        $sudah_melakukan_opname_post_production = false;
        try {
            $sudah_melakukan_opname_post_production = OpnamePostProduction::whereDate('tanggal', $date)->first() ? true : false;
        } catch (\Throwable $th) {
            $sudah_melakukan_opname_post_production = false;
        }

        $sudah_melakukan_catat_hasil_produksi = false;
        $catat_hasil_produksi = QtyProduksi::whereDate('tanggal', $date)->first();
        try {
            $sudah_melakukan_catat_hasil_produksi = $catat_hasil_produksi ? true : false;
        } catch (\Throwable $th) {
            $sudah_melakukan_catat_hasil_produksi = false;
        }

        $nama_produk = @$pre_production->nama_produk;
        $qty = $catat_hasil_produksi->qty ?? 0;
        return view('pages.' . $this->folder . '.list', compact('allow', 'group', 'icon', 'module', 'module_name', 'sudah_melakukan_opname_pre_production', 'sudah_melakukan_opname_post_production', 'sudah_melakukan_catat_hasil_produksi', 'nama_produk', 'qty'));
    }

    public function store(Request $request)
    {
               // 1. Validasi Input
        $rules = [
            'tanggal' => 'required|date',
            'qty' => 'required',
            'nama_produk' => 'required|string|max:255'
        ];
        $message = [
            'tanggal.required' => 'Kolom Tanggal tidak boleh kosong',
            'nama_produk.required' => 'Kolom Nama Produk tidak boleh kosong',
            'qty.required' => 'Kolom QTY tidak boleh kosong',
        ];
        $request->validate($rules, $message);

        // Memulai database transaction untuk menjaga integritas data
        DB::beginTransaction();
        try {
            // 2. Persiapkan Data Awal
            $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            $namaProduk = $request->nama_produk;
            $qtyHasilProduksi = (float) Util::removeSeperator($request->qty);

            // 3. Simpan Qty Produksi (Catat Hasil Produksi)
            QtyProduksi::create([
                'tanggal' => $tanggal,
                'nama_produk' => $namaProduk,
                'qty' => $qtyHasilProduksi,
                'karyawan_id' => AuthCommon::user()->karyawan->id
            ]);

            // 4. Ambil Data Opname (dengan filter NAMA PRODUK)
            $opnamePre = OpnamePreProduction::whereDate('tanggal', $tanggal)
                                            ->where('nama_produk', $namaProduk)
                                            ->get();

            $opnamePost = OpnamePostProduction::whereDate('tanggal', $tanggal)
                                              ->where('nama_produk', $namaProduk)
                                              ->get();

            if ($opnamePre->isEmpty()) {
                DB::rollBack();
                return response([
                    'status' => false,
                    'message' => 'Data Opname Pre-Production untuk tanggal dan produk ini tidak ditemukan.'
                ], 404);
            }

            // --- Mulai Logika Kalkulasi Laporan ---

            // 5. Hitung Total Nilai Bahan yang Terpakai
            $totalNilaiBahan = 0;
            foreach ($opnamePre as $pre) {
                // Cari data post-opname yang cocok berdasarkan nama bahan
                $post = $opnamePost->firstWhere('nama_bahan', $pre->nama_bahan);

                // Konversi QTY ke tipe float untuk perhitungan yang akurat
                $qtyAwal = (float) $pre->qty;
                $qtySisa = $post ? (float) $post->qty : 0; // Jika tidak ada sisa, anggap 0

                // Hitung selisih dan biaya sesuai aturan
                $qtyTerpakai = $qtyAwal - $qtySisa;
                $biayaBahan = $qtyTerpakai * $pre->nilai_persatuan; // Gunakan nilai per satuan dari PRE-OPNAME

                $totalNilaiBahan += $biayaBahan;
            }

            // 6. Hitung Nilai Per Produksi
            $nilaiPerProduksi = ($qtyHasilProduksi > 0) ? ($totalNilaiBahan / $qtyHasilProduksi) : 0;


            // 7. Buat atau Update Laporan Produksi untuk menghindari duplikasi
            LaporanProduksi::updateOrCreate(
                [
                    // Kondisi pencarian
                    'tanggal' => $tanggal,
                    'nama_produk' => $namaProduk
                ],
                [
                    // Data yang akan dibuat atau diupdate
                    'qty' => $qtyHasilProduksi,
                    'nilai_bahan' => $totalNilaiBahan,
                    'nilai_laporan_per_produksi' => $nilaiPerProduksi
                ]
            );

            // Jika semua berhasil, commit transaction
            DB::commit();
            return response([
                'status' => true,
                'message' => ResponseConstant::RM_CREATE_SUCCESS ?? 'Data berhasil disimpan.'
            ]);

        } catch (\Throwable $th) {
            // Jika terjadi error, batalkan semua query
            DB::rollBack();
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_UPDATE_FAILED ?? 'Terjadi kesalahan pada server.',
                'error' => $th->getMessage()
            ], 500);
        }
    }


    public function check_sudah_melakukan_catat_hasil_produksi($date){
        $catat_hasil_produksi = false;
        try {

            $catat_hasil_produksi = QtyProduksi::whereDate('tanggal', Carbon::createFromFormat('d-m-Y', $date))->first() ? true : false;
        } catch (\Throwable $th) {
            //throw $th;
        }

        return response([
            'status' => true,
            'catat_hasil_produksi' => $catat_hasil_produksi
        ], 200);

    }

}

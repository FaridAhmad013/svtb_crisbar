<?php

namespace App\Http\Controllers;

use App\DataTables\LaporanProduksiDataTable;
use App\Helpers\AuthCommon;
use App\Models\LaporanProduksi;
use App\Models\OpnamePostProduction;
use App\Models\OpnamePreProduction;
use App\Models\QtyProduksi;

class LaporanProduksiController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = 'laporan_produksi';
        $this->module_name = 'Laporan Produksi';
        $this->folder = 'laporan.laporan_produksi';
    }

    public function index()
    {
        $user = AuthCommon::user() ?? null;
        if (!in_Array(@$user->role->role, ['Pemilik'])) abort('403');

        $allow = json_encode($this->allow);

        $group = "Laporan";
        $icon = "fas fa-file-alt";
        $module = $this->module;
        $module_name = $this->module_name;
        return view('pages.' . $this->folder . '.list', compact('allow', 'group', 'icon', 'module', 'module_name'));
    }

    public function show($id)
    {
        try {
            $auth = AuthCommon::user() ?? null;
            if(!in_array($auth->role->role, ['Pemilik'])) {
                $body = '<h3>403 | Forbidden</h3>';
                $footer = '<button type="button" class="px-4 py-2 bg-gray-100 rounded-sm text-sm hover:bg-gray-200 border border-gray-300 transform  transition duration-300" data-dismiss="modal">Tutup</button>';
            }else{
                $body = view('pages.'.$this->folder.'.show')->render();
                $footer = '<button type="button" class="px-4 py-2 bg-gray-100 rounded-sm text-sm hover:bg-gray-200 border border-gray-300 transform  transition duration-300" data-dismiss="modal">Tutup</button>';
            }

            return [
                'title' => 'Detail '.$this->module_name,
                'body' => $body,
                'footer' => $footer,
                'id' => $id
            ];
        } catch (\Throwable $th) {
            //throw $th;

            return response([
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
                "error" => $th->getMessage()
            ], 400);
        }
    }

    public function get_detail_perhitungan($id)
    {
        try {
            // 1. Cari data QtyProduksi berdasarkan ID yang diberikan
            $laporan_produksi = LaporanProduksi::find($id);

            $qtyProduksi = QtyProduksi::where('nama_produk', $laporan_produksi->nama_produk)->whereDate('tanggal', $laporan_produksi->tanggal)->first();

            if (!$qtyProduksi) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Produksi dengan ID tersebut tidak ditemukan.'
                ], 404);
            }

            // 2. Ambil tanggal dan nama produk sebagai kunci pencarian
            $tanggal = $qtyProduksi->tanggal;
            $namaProduk = $qtyProduksi->nama_produk;

            // 3. Ambil data opname pre dan post yang relevan
            $opnamePre = OpnamePreProduction::whereDate('tanggal', $tanggal)
                ->where('nama_produk', $namaProduk)
                ->get();

            $opnamePost = OpnamePostProduction::whereDate('tanggal', $tanggal)
                ->where('nama_produk', $namaProduk)
                ->get();

            // Pastikan data opname pagi ada
            if ($opnamePre->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Opname Pre-Production untuk produksi ini tidak ditemukan.'
                ], 404);
            }

            $perhitungan = [];
            $totalCost = 0;

            // 4. Lakukan iterasi dan kalkulasi untuk setiap bahan
            foreach ($opnamePre as $pre) {
                $post = $opnamePost->firstWhere('nama_bahan', $pre->nama_bahan);

                $qtyPre = (float) $pre->qty;
                $qtyPost = $post ? (float) $post->qty : 0;
                $nilaiPerSatuan = (float) $pre->nilai_persatuan;

                $selisihQty = $qtyPre - $qtyPost;
                $cost = $selisihQty * $nilaiPerSatuan;

                $perhitungan[] = [
                    'nama_bahan' => $pre->nama_bahan,
                    'qty_pre' => $qtyPre,
                    'qty_post' => $qtyPost,
                    'selisih_qty' => $selisihQty,
                    'nilai_per_satuan' => $nilaiPerSatuan,
                    'cost' => $cost,
                ];

                $totalCost += $cost;
            }

            // 5. Siapkan data response sesuai format gambar
            $responseData = [
                'perhitungan' => $perhitungan,
                'jumlah' => $totalCost
            ];

            return response()->json([
                'status' => true,
                'message' => 'Detail perhitungan berhasil dimuat.',
                'data' => $responseData
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function datatable(LaporanProduksiDataTable $dataTable){
        return $dataTable->render('datatable');
    }
}

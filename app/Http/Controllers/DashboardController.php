<?php

namespace App\Http\Controllers;

use App\Helpers\AuthCommon;
use App\Helpers\ResponseConstant;
use App\Models\OpnamePostProduction;
use App\Models\OpnamePreProduction;
use App\Models\QtyProduksi;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (!in_array(AuthCommon::user()->role->role, ['Pemilik','Karyawan'])) abort('403');

        $user = AuthCommon::user();
        $role = $user->role ?? null;
        $waktu_sekarang = Carbon::now()->format('H:i');

        $nama_lengkap = @$user->nama_depan.' '.@$user->nama_belakang;
        if ($waktu_sekarang >= '05:00' && $waktu_sekarang < '10:00') {
            $ucapan = "Selamat Pagi, $nama_lengkap.";
        } elseif ($waktu_sekarang >= '10:00' && $waktu_sekarang < '15:00') {
            $ucapan = "Bagaimana kabarmu siang ini, $nama_lengkap?";
        } elseif ($waktu_sekarang >= '15:00' && $waktu_sekarang < '18:00') {
            $ucapan = "Semoga harimu berjalan baik, $nama_lengkap.";
        } else {
            $ucapan = "Selamat beristirahat, $nama_lengkap.";
        }

        if($role->role == 'Pemilik'){
            return view('pages.dashboard.pemilik', compact('role', 'ucapan'));
        }


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

        $catat_hasil_produksi = false;
        try {
            $catat_hasil_produksi = QtyProduksi::whereDate('tanggal', $date)->first() ? true : false;
        } catch (\Throwable $th) {
            $catat_hasil_produksi = false;
        }

        $nama_produk = @$pre_production->nama_produk;
        return view('pages.dashboard.karyawan', compact('role', 'ucapan', 'sudah_melakukan_opname_pre_production', 'sudah_melakukan_opname_post_production', 'catat_hasil_produksi', 'nama_produk'));
    }

    public function get_total_pengguna(){
        try {
            $total = 0;

            $total = User::count();
            return response([
                'status' => true,
                'data' => [
                    'total' => @$total ?? 0
                ]
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_INTERNAL_ERROR,
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function get_total_pertanyaan(){
        try {
            $total = 0;

            // $total = Pertanyaan::count();
            return response([
                'status' => true,
                'data' => [
                    'total' => @$total ?? 0
                ]
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_INTERNAL_ERROR,
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function get_total_entry_jurnal_hari_ini(){
        try {
            $total = 0;

            // $total = Pertanyaan::count();
            return response([
                'status' => true,
                'data' => [
                    'total' => @$total ?? 0
                ]
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_INTERNAL_ERROR,
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function get_total_pengguna_aktif(){
        try {
            $total = 0;

            $total = User::whereMonth('last_login', Carbon::now()->month)->whereYear('last_login', Carbon::now()->year)->count();
            return response([
                'status' => true,
                'data' => [
                    'total' => @$total ?? 0
                ]
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_INTERNAL_ERROR,
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function check_menulis_jurnal(){
        $sudah_menulis_jurnal = false;
        try {
            // $sesi_jurnal = SesiJournal::whereDate('tanggal', Carbon::now()->format('Y-m-d'))->where('user_id', AuthCommon::user()->id)->first();

            // $sudah_menulis_jurnal = $sesi_jurnal ? true : false;
        } catch (\Throwable $th) {

        }
        return response([
            'status' => true,
            'data' => [
                'sudah_menulis_jurnal' => @$sudah_menulis_jurnal,
                // 'kesimpulan' => @$sesi_jurnal->kesimpulan_ai
            ]
        ]);
    }

    public function get_kalender_progress(){
        $data = [];
        try {
            // $data = SesiJournal::where('user_id', AuthCommon::user()->id)->where('status', 'SELESAI')->latest()->get();
        } catch (\Throwable $th) {

        }

        return response([
            'status' => true,
            'data' => $data
        ]);
    }

    public function get_jejak_ceritamu(){
        $data = [];
        try {
            // $data = SesiJournal::where('user_id', AuthCommon::user()->id)->where('status', 'SELESAI')->latest()->get();
        } catch (\Throwable $th) {

        }

        return response([
            'status' => true,
            'data' => $data
        ]);
    }


}

<?php

namespace App\Http\Controllers;

use App\DataTables\LaporanProduksiDataTable;
use App\Helpers\AuthCommon;

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

    public function datatable(LaporanProduksiDataTable $dataTable){
        return $dataTable->render('datatable');
    }
}

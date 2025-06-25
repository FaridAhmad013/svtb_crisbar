<?php

namespace App\Http\Controllers\ProsesProduksiHarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\OpnamePostProductionDataTable;
use App\Helpers\AuthCommon;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Models\OpnamePostProduction;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OpnamePostProductionController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = 'opname_post_production';
        $this->module_name = 'Opname (Post-Production)';
        $this->folder = 'proses_produksi_harian.opname_post_production';
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
            $sudah_melakukan_opname = OpnamePostProduction::whereDate('tanggal', $date)->first() ? true : false;
        } catch (\Throwable $th) {
            $sudah_melakukan_opname = false;
        }

        return response([
            'status' => true,
            'sudah_melakukan_opname' => $sudah_melakukan_opname
        ], 200);
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

        DB::beginTransaction();
        try{
            for($i = 0; $i < count($formData['data_bahan']); $i++){
                if(@$formData['data_bahan'][$i]){
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


    public function handle_update_qty(Request $request, $id)
    {

        $rules = [
            'qty' => 'required',
        ];

        $message = [
            'qty.required' => 'Kolom QTY tidak boleh kosong',
        ];

        $request->validate($rules, $message);

        $formData = $request->only([
            'qty',
        ]);

        $formData['qty'] = (float) $formData['qty'];
        try {
            $run = OpnamePostProduction::where('id', $id)->first();

            if(!$run){
                return response([
                    "status" => false,
                    "message" => ResponseConstant::RM_UPDATE_FAILED,
                    "data" => []
                ], 400);
            }

            $formData['nilai_persatuan'] = $run->nilai_rupiah/$formData['qty'];

            OpnamePostProduction::where('id', $id)->update($formData);

            return response([
                "status" => true,
                "message" => ResponseConstant::RM_UPDATE_SUCCESS,
                "data" => isset($run->data) ? $run->data : null
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
             return response([
                "status" => false,
                "message" => ResponseConstant::RM_UPDATE_FAILED,
                "data" => []
            ], 400);
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
            OpnamePostProduction::where('id', $id)->delete();

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

    public function datatable(OpnamePostProductionDataTable $dataTable){
        return $dataTable->render('datatable');
    }
}

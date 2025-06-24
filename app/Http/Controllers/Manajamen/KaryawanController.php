<?php

namespace App\Http\Controllers\Manajamen;

use App\DataTables\KaryawanDataTable;
use App\Helpers\AuthCommon;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    private $module, $module_name, $service, $help_key, $folder, $allow;

    function __construct()
    {
        $this->module = 'karyawan';
        $this->module_name = 'Karyawan';
        $this->folder = 'manajemen.karyawan';

    }

    public function index()
    {
        $user = AuthCommon::user() ?? null;
        if (!in_Array(@$user->role->role, ['Pemilik'])) abort('403');

        $allow = json_encode($this->allow);

        $group = "Manajemen";
        $icon = "fas fa-users";
        $module = $this->module;
        $module_name = $this->module_name;
        return view('pages.' . $this->folder . '.list', compact('allow', 'group', 'icon', 'module', 'module_name'));
    }

    public function show($id)
    {
        try {
            $auth = AuthCommon::user() ?? null;
            $data = Karyawan::where('id', $id)->first();
            if(!in_array($auth->role->role, ['Pemilik'])) {
                $body = '<h3>403 | Forbidden</h3>';
                $footer = '<button type="button" class="px-4 py-2 bg-gray-100 rounded-sm text-sm hover:bg-gray-200 border border-gray-300 transform  transition duration-300" data-dismiss="modal">Tutup</button>';
            }else{
                $body = view('pages.'.$this->folder.'.show', compact('data'))->render();
                $footer = '<button type="button" class="px-4 py-2 bg-gray-100 rounded-sm text-sm hover:bg-gray-200 border border-gray-300 transform  transition duration-300" data-dismiss="modal">Tutup</button>';
            }

            return [
                'title' => 'Detail '.$this->module_name,
                'body' => $body,
                'footer' => $footer
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

    public function create()
    {
        $user = AuthCommon::user();
        if (!in_Array(@$user->role->role, ['Pemilik'])) {
            $body = '<h3>403 | Forbidden</h3>';
            $footer = '<button type="button" class="px-4 py-2 bg-gray-100 rounded-sm text-sm hover:bg-gray-200 border border-gray-300 transform  transition duration-300" data-dismiss="modal">Tutup</button>';
        } else {
            $body = view('pages.' . $this->folder . '.create', [
                'module' => $this->module,
                'module_name' => $this->module_name,
                'folder' => $this->folder,
            ])->render();
            $footer = '<button type="button" class="focus:outline-none px-4 py-2 bg-gray-100 rounded-sm text-sm hover:bg-gray-200 border border-gray-300 transform  transition duration-300" data-dismiss="modal">Tutup</button>
                <button type="button" class="focus:outline-none btn-prev px-4 py-2 bg-red-400 rounded-sm text-sm font-bold tracking-wide text-white transform  transition duration-300" onclick="prevStep()" style="display: none;" >Sebelumnya</button>
                <button type="button" class="focus:outline-none btn-next px-4 py-2 bg-red-400 disabled:bg-red-300 rounded-sm text-sm font-bold tracking-wide text-white transform  transition duration-300" onclick="nextStep()">Selanjutnya</button>';
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
            'karyawan.nama_depan' => 'required',
            'karyawan.nama_belakang' => 'required',
            'user.username' => 'required|unique:users,username|regex:/^(?!.*[_.]{2})(?![_.])[a-zA-Z0-9._]{3,20}(?<![_.])$/',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|confirmed',
        ];

        $message = [
            'user.username.required' => 'Kolom Username tidak boleh kosong',
            'user.username.unique' => 'Username sudah digunakan',
            'user.username.regex' => 'Username hanya boleh berisi huruf, angka, titik, dan underscore tanpa simbol berurutan atau di awal/akhir.',
            'karyawan.nama_depan.required' => 'Kolom Nama Depan tidak boleh kosong',
            'karyawan.nama_belakang.required' => 'Kolom Nama Belakang tidak boleh kosong',
            'user.email.required' => 'Kolom Email tidak boleh kosong',
            'user.email.unique' => 'Email sudah digunakan',
            'user.password.required' => 'Kolom Password tidak boleh kosong',
            'user.password.confirmed' => 'Kolom Password tidak sama',
        ];
        $request->validate($rules, $message);

        if(!Util::isPasswordValid($request->user['password'], $request->user['username'])){
            return response([
                'status' => false,
                'message' => 'Password harus terdiri dari setidaknya satu angka (0-9), satu huruf kecil (a-z), satu huruf besar (A-Z), satu karakter khusus (@, #, $, %, ^, &, +, =, !), setidaknya berjumlah 8 dan tidak mengandung username'
            ], 400);
        }

        $formData = $request->only([
            'user',
            'karyawan',
        ]);

        $formData['user']['nama_depan'] = $formData['karyawan']['nama_depan'];
        $formData['user']['nama_belakang'] = $formData['karyawan']['nama_belakang'];
        $formData['karyawan']['nama_karyawan'] = $formData['user']['nama_depan'].' '.$formData['user']['nama_belakang'];
        unset($formData['karyawan']['nama_depan']);
        unset($formData['karyawan']['nama_belakang']);

        $formData['user']['password'] = bcrypt($formData['user']['password']);
        $formData['user']['status'] = '1';
        $formData['user']['role_id'] = 2;

        DB::beginTransaction();
        try {
            $user = User::create($formData['user']);
            if(!$user){
                DB::rollBack();
                return response([
                    'status' => false,
                    'message' => ResponseConstant::RM_CREATE_FAILED
                ], 400);
            }

            $lastKaryawan = Karyawan::orderBy('nomor_karyawan', 'desc')->first();

            if ($lastKaryawan) {
                $lastNumber = intval($lastKaryawan->nomor_karyawan);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $formData['karyawan']['nomor_karyawan'] = str_pad($newNumber, 6, '0', STR_PAD_LEFT);

            $formData['karyawan']['user_id'] = $user->id;
            Karyawan::create($formData['karyawan']);
            DB::commit();
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

    public function edit($id)
    {
        try {
            $data = Karyawan::findOrFail($id);

            $auth = AuthCommon::user() ?? null;
             if (!in_array(@$auth->role->role, ['Pemilik'])) {
                $body = '<h3>403 | Forbidden</h3>';
                $footer = '<button type="button" class="px-4 py-2 bg-gray-100 rounded-sm text-sm hover:bg-gray-200 border border-gray-300 transform  transition duration-300" data-dismiss="modal">Tutup</button>';
            } else {
                $body = view('pages.' . $this->folder . '.edit', [
                    'id' => $id,
                    'data' => $data,
                    'folder' => $this->folder,
                    'module' => $this->module,
                    'module_name' => $this->module_name,
                ])->render();
                $footer = '<button type="button" class="px-4 py-2 bg-gray-100 rounded-sm text-sm hover:bg-gray-200 border border-gray-300 transform  transition duration-300" data-dismiss="modal">Tutup</button>
                    <button type="button" class="focus:outline-none btn-next px-4 py-2 bg-red-400 disabled:bg-red-300 rounded-sm text-sm font-bold tracking-wide text-white transform  transition duration-300" onclick="save()">Simpan</button>';
            }

            return [
                'title' => 'Edit ' . $this->module_name,
                'body' => $body,
                'footer' => $footer
            ];
        } catch (\Throwable $th) {
            return response([
                "status" => false,
                "message" => "Bad Request",
                "data" => [],
                "error" => $th->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $auth = AuthCommon::user() ?? null;
        if (!in_array(@$auth->role->role, ['Pemilik'])) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }

        $rules = [
            'nama_karyawan' => 'required',
        ];

        $message = [
            'nama_karyawan.required' => 'Kolom Nama Karyawan tidak boleh kosong',
        ];

        $request->validate($rules, $message);

        $formData = $request->only([
            'nama_karyawan',
        ]);

        try {
            Karyawan::where('id', $id)->update($formData);

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
        if (!in_array(@$auth->role->role, ['Pemilik'])) {
            return response([
                'status' => false,
                'message' => '403 | Forbidden'
            ], 400);
        }

        try {
            User::where('id', $id)->delete();

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

    public function datatable(KaryawanDataTable $dataTable){
        return $dataTable->render('datatable');
    }
}

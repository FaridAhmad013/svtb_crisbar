<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuthCommon;
use App\Helpers\ConstantUtility;
use App\Helpers\GeminiUtility;
use App\Helpers\ResponseConstant;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\ResponAi;
use App\Models\Role;
use App\Models\SesiJournal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        $auth = AuthCommon::user();
        if($auth){
            return redirect()->route('dashboard.index');
        }

        return view('auth.login');
    }

    public function login_process(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $message = [
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ];
        $request->validate($rules, $message);

        $result =  User::where('username', $request->username)->select('id', 'username', 'nama_depan', 'nama_belakang', 'email', 'password', 'auth_attemp', 'status', 'role_id')->first();
        if(!$result){
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_INVALID_USERNAME_PASSWORD
            ], 400);
        }

        $auth_attemp = intval($result->auth_attemp ?? 0);
        if(!Hash::check($request->password, $result->password)){
            User::where('username', $request['username'])->update(['auth_attemp' => ($auth_attemp  + 1)]);
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_INVALID_USERNAME_PASSWORD
            ], 400);
        }

        if($auth_attemp > 2){
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_USER_ACCOUNT_BLOCKED
            ], 400);
        }

        if($result->status == 0){
            return response([
                'status' => false,
                'message' => ResponseConstant::RM_USER_ACCOUNT_BLOCKED
            ], 400);
        }


        $get_role = Role::find($result->role_id);
        if(!in_array($get_role->role, ['Admin', 'Pengguna'])){
            return response([
                'status' => false,
                'message' => 'Anda Tidak Punya Hak Akses'
            ], 400);
        }


        $data_session = (object) $result->toArray();
        unset($result->password);
        $data_session->role = $get_role;
        // menentukan tema jika pengguna
        if($get_role->role == 'Pengguna'){
            $data_session->theme = ConstantUtility::THEME_PERTANYAAN_DEFAULT;

            $respon_ai_result = SesiJournal::where('user_id', $data_session->id)->whereNotNull('kesimpulan_ai')->latest()->first();
            if($respon_ai_result){
                $data_session->theme = GeminiUtility::tentukanTemaHarian($respon_ai_result->kesimpulan_ai, $result->id);
            }
        }
        AuthCommon::setUser($data_session);

        User::where('username', $request->username)->update(['last_login' => Carbon::now()]);
        return response([
            'status' => true,
            'message' => 'Login Berhasil'
        ]);
    }

    public function logout()
    {
        AuthCommon::logout();
        return redirect('/');
    }


}

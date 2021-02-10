<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use DB;
use App\Models\User;
use App\Models\Bagian;


class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('dashboard');
        }
        return view('login');
    }
 
    public function login(Request $request)
    {
        $rules = [
            'username'                 => 'required',
            'password'              => 'required|string'
        ];
 
        $messages = [
            'username.required'     => 'Username wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $data = [
            'username'     => $request->input('username'),
            'password'  => $request->input('password'),
        ];
 
        Auth::attempt($data);
 
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            if (Auth::user()->jabatan == "user") {
                return redirect()->route('dashboard');
            } else if(Auth::user()->jabatan == "admin media") {
                return redirect()->route('dashboardadminmedia');
            }   else if(Auth::user()->jabatan == "kepala media") {
                return redirect()->route('dashboardkepalamedia');
            }
 
        } else { // false
 
            //Login Fail
            Session::flash('error', 'Usernanme atau password salah');
            return redirect()->route('loginshow');
        }
 
    }
 
    public function showFormRegister()
    {
        $bagian = DB::table('bagian')->select('id', 'nama_bagian')->get();
        return view('register', ['bagian' => $bagian]);
    }
 
    public function register(Request $request)
    {
        $rules = [
            'username'              => 'required',
            'password'              => 'required|confirmed',
            'nama'                  => 'required',
            'NIP'                   => 'required',
            'bagian'                => 'required',
            'jabatan'               => 'required'
        ];
 
        $messages = [
            'nama.required'         => 'Nama Lengkap wajib diisi',
            'username.required'     => 'Email wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            'NIP.required'          => 'nik wajib diisi',
            'bagian.required'       => 'no telepon wajib diisi',
            'jabatan.required'      => 'alamt wajib diisi'
        ];
 
        $validator = Validator::make($request->all(), $rules, $messages);
 
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
 
        $user = new User;
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->NIP = $request->NIP;
        $user->bagian = $request->bagian;
        $user->jabatan = $request->jabatan;

        $simpan = $user->save();
        
        if($simpan){
            Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
            return redirect()->route('loginshow');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('register');
        }
    }
 
    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('loginshow');
    }
}
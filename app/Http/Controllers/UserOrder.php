<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Validator;
use Session;
use App\Models\DetailOrder;


class UserOrder extends Controller
{
    public function index()
    {
        if (Auth::user()->jabatan == "user") {
            $data = DB::table('detailorder')
            ->join('user', 'user.id', '=', 'detailorder.iduser')
            ->join('detail_media', 'detail_media.id', '=', 'detailorder.idmedia')
            ->join('media', 'media.id', '=', 'detail_media.id_media')
            ->select(
                'detailorder.id as id',
                'media.nama_media as nama_media',
                'detailorder.jumlah as jumlah',
                'user.nama as nama',
                'detailorder.tanggal_order as tanggal',
                'detailorder.statusorder as status')
                ->get();

            return view('content.user.dashboard', compact("data"), ['title' => 'Dashboard', 'sidebardashboard' => 'active']);
        }else{
            return view('login');
        }
    }
    public function order()
    {
        if (Auth::user()->jabatan == "user") {
            return view('content.user.order', ['title' => 'Order', 'sidebarorder' => 'active']);
        }else{
            return view('login');
        }
    }

    public function autocompletemedia(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table('detail_media')
            ->join('media', 'detail_media.id_media', '=', 'media.id')
            ->join('satuan', 'detail_media.id_satuan', '=', 'satuan.id')
            ->select(
                'detail_media.id as id', 
                'media.nama_media as nama_media',
                'satuan.satuan as satuan',
                'detail_media.kemasan',
                'detail_media.stok as stok')
            ->where('media.nama_media','LIKE',"%$search%")
            ->get();
        }
        return response()->json($data);
    }

    public function create(Request $request)
    {
        if (Auth::user()->jabatan == "user") {
            $rules = [
                'media'                  => 'required',
                'jumlah'                 => 'required'
            ];
    
            $messages = [
                'media.required'         => 'Nama Lengkap wajib diisi',
                'jumlah.required'        => 'Email wajib diisi'
            ];
    
            $validator = Validator::make($request->all(), $rules, $messages);
    
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
    
            $order = new DetailOrder;
            $order->tanggal_order = NOW();
            $order->jumlah = $request->jumlah;
            $order->iduser = Auth::user()->id;
            $order->idmedia = $request->media;

            $simpan = $order->save();
            
            if($simpan){
                Session::flash('success', 'Berhasil Melakukan Order!');
                return redirect()->route('dashboard');
            } else {
                Session::flash('errors', ['' => 'Gagal Melakukan Order!']);
                return redirect()->route('order');
            }
        }else{
            return view('login');
        }
    }

    public function destroy($id){
        DetailOrder::find($id)->delete();
        Session::flash('success', 'Berhasil Menghapus Data');
        return redirect()->route('dashboard');
    }

}

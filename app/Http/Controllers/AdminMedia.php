<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Models\DetailOrder;
use App\Models\DetailMedia;
use App\Models\Media;
use App\Models\Satuan;
use Session;



class AdminMedia extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->jabatan == "admin media") {
            $data = DB::table('detailorder')
            ->join('detail_media','detail_media.id','=','detailorder.idmedia')
            ->join('media','media.id','=','detail_media.id_media')
            ->join('satuan', 'satuan.id', '=', 'detail_media.id_satuan')
            ->join('user','user.id','=','detailorder.iduser')
            ->join('bagian', 'bagian.id','=','user.bagian')
            ->select(
                'detailorder.id as id', 
                'detailorder.tanggal_order as tanggal', 
                'media.nama_media as nama_media', 
                'detailorder.jumlah as jumlah', 
                'detail_media.kemasan as kemasan',
                'satuan.satuan as satuan',
                'user.nama as nama', 
                'bagian.nama_bagian as bagian', 
                'detailorder.statusorder as status')
            ->get();
            return view('content.admin_media.dashboard', compact("data"), ['title' => 'Dashboard', 'sidebardashboard' => 'active']);
        }else{
            return view('/login');
        }
    }

    public function media()
    {
        if (Auth::user()->jabatan == "admin media") {
            $data = DB::table('media')
            ->select(
                'id','kode', 'nama_media', 'expired', 'batch')
            ->where('flag','0')
            ->get();
            return view('content.admin_media.media', compact("data"), ['title' => 'Media', 'sidebarmedia' => 'active']);
        }else{
            return view('/login');
        }
    }

    public function insertmedia(Request $request)
    {
        if (Auth::user()->jabatan == "admin media") {
            $rules = [
                'id'                => 'required',
                'nama_media'        => 'required',
                'expired'           => 'required',
                'batch'             => 'required'
            ];
        
            $messages = [
                'id.required'         => 'Id wajib diisi',
                'nama_media.required'         => 'Nama Media wajib diisi',
                'expired.required'        => 'Expired wajib diisi',
                'batch.required'        => 'Batch wajib diisi'
            ];
        
            $validator = Validator::make($request->all(), $rules, $messages);
    
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
    
            $media = new Media;
            $media->kode = $request->id;
            $media->nama_media = $request->nama_media;
            $media->expired = $request->expired;
            $media->batch = $request->batch;
            $simpan = $media->save();
               
            if($simpan){
                Session::flash('success', 'Berhasil Memasukan Data !');
                return redirect()->route('media');
            } else {
                Session::flash('errors', ['' => 'Gagal Memasukan Data!']);
                return redirect()->route('media');
            }
        }else{
                return view('login');
        }
    }

    public function updatemedia(Request $request, $id)
    {
        if (Auth::user()->jabatan == "admin media") {
            $rules = [
                'kode'                => 'required',
                'nama_media'        => 'required',
                'expired'           => 'required',
                'batch'             => 'required'
            ];
        
            $messages = [
                'kode.required'         => 'kode wajib diisi',
                'nama_media.required'         => 'Nama Media wajib diisi',
                'expired.required'        => 'Expired wajib diisi',
                'batch.required'        => 'Batch wajib diisi'
            ];
        
            $validator = Validator::make($request->all(), $rules, $messages);
    
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
    
            $update = Media::where('id',$request->id)->update(request()->except(['_token','input']));
               
            if($update){
                Session::flash('success', 'Berhasil Merubah Data !');
                return redirect()->route('media');
            } else {
                Session::flash('errors', ['' => 'Gagal Merubah Data!']);
                return redirect()->route('media');
            }
        }else{
                return view('login');
        }
    }

    public function mediaterhapus()
    {
        if (Auth::user()->jabatan == "admin media") {
            $data = DB::table('media')
            ->select(
                'id','kode', 'nama_media', 'expired', 'batch')
            ->where('flag','1')
            ->get();
            return view('content.admin_media.media_delete', compact("data"), ['title' => 'Media', 'sidebarmedia' => 'active']);
        }else{
            return view('/login');
        }
    }

    public function destroymedia($id)
    {
        if (Auth::user()->jabatan == "admin media") {

            $destroy_media = Media::find($id);
            $destroy_media->flag = '1';
            $destroy = $destroy_media->save();

            if($destroy){
                Session::flash('success', 'Berhasil Menghapus Data !');
                return redirect()->route('media');
            } else {
                Session::flash('errors', ['' => 'Gagal Menghapus Data!']);
                return redirect()->route('media');
            }
        }else{
                return view('login');
        }
    }

    public function undestroymedia($id)
    {
        if (Auth::user()->jabatan == "admin media") {

            $undestroy_media = Media::find($id);
            $undestroy_media->flag = '0';
            $destroy = $undestroy_media->save();

            if($destroy){
                Session::flash('success', 'Berhasil Mengambalikan Data !');
                return redirect()->route('mediaterhapus');
            } else {
                Session::flash('errors', ['' => 'Gagal Mengambalikan Data!']);
                return redirect()->route('mediaterhapus');
            }
        }else{
                return view('login');
        }
    }

    public function detailmedia()
    {
        if (Auth::user()->jabatan == "admin media") {
            $data = DB::table('detail_media')
            ->join('satuan','satuan.id','=','detail_media.id_satuan')
            ->join('media','media.id','=','detail_media.id_media')
            ->select(
                'detail_media.id as id',
                'media.id as id_media',
                'media.nama_media as nama_media', 
                'detail_media.kemasan as kemasan',
                'satuan.id as id_satuan',
                'satuan.satuan as satuan', 
                'detail_media.stok')
            ->where('detail_media.flag','0')
            ->get();
            return view('content.admin_media.detailmedia', compact("data"), ['title' => 'Detail Media', 'sidebardetailmedia' => 'active']);
        }else{
            return view('/login');
        }
    }

    public function insertdetailmedia(Request $request)
    {
        if (Auth::user()->jabatan == "admin media") {
            $rules = [
                'nama_media'                => 'required',
                'satuan'        => 'required',
                'kemasan'       => 'required',
                'stok'           => 'required'
            ];
        
            $messages = [
                'nama_media.required'         => 'Nama Media wajib diisi',
                'satuan.required'        => 'Expired wajib diisi',
                'kemasan.required'        => 'Kemasan wajib diisi',
                'stok.required'        => 'Batch wajib diisi'
            ];
        
            $validator = Validator::make($request->all(), $rules, $messages);
    
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
            $str = $request->kemasan;
            $change = str_replace(",",".",$str);
            
            $detailmedia = new DetailMedia;
            $detailmedia->id_media = $request->nama_media;
            $detailmedia->kemasan = $change;
            $detailmedia->id_satuan = $request->satuan;
            $detailmedia->stok = $request->stok;
            $simpan = $detailmedia->save();
               
            if($simpan){
                Session::flash('success', 'Berhasil Memasukan Data !');
                return redirect()->route('detailmedia');
            } else {
                Session::flash('errors', ['' => 'Gagal Memasukan Data!']);
                return redirect()->route('detailmedia');
            }
        }else{
                return view('login');
        }
    }

    public function updatedetailmedia(Request $request, $id)
    {
        if (Auth::user()->jabatan == "admin media") {
            $rules = [
                'id_media'        => 'required',
                'kemasan'       => 'required',
                'id_satuan'           => 'required',
                'stok'             => 'required'
            ];
        
            $messages = [
                'id_media.required'         => 'Nama Media wajib diisi',
                'kemasan.required'        => 'Kemasan wajib diisi',
                'id_satuan.required'        => 'Expired wajib diisi',
                'stok.required'        => 'Batch wajib diisi'
            ];
        
            $validator = Validator::make($request->all(), $rules, $messages);
    
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
            $str = $request->kemasan;
            $change = str_replace(",",".",$str);

            $update_detailmedia = DetailMedia::find($id);
            $update_detailmedia->id_media = $request->id_media;
            $update_detailmedia->kemasan = $change;
            $update_detailmedia->id_satuan = $request->id_satuan;
            $update_detailmedia->stok = $request->stok;
            $update = $update_detailmedia->save();

            if($update){
                Session::flash('success', 'Berhasil Merubah Data !');
                return redirect()->route('detailmedia');
            } else {
                Session::flash('errors', ['' => 'Gagal Merubah Data!']);
                return redirect()->route('detailmedia');
            }
        }else{
                return view('login');
        }
    }

    public function detailmediaterhapus()
    {
        if (Auth::user()->jabatan == "admin media") {
            $data = DB::table('detail_media')
            ->join('satuan','satuan.id','=','detail_media.id_satuan')
            ->join('media','media.id','=','detail_media.id_media')
            ->select(
                'detail_media.id as id',
                'media.id as id_media',
                'media.nama_media as nama_media', 
                'detail_media.kemasan as kemasan',
                'satuan.id as id_satuan',
                'satuan.satuan as satuan', 
                'detail_media.stok')
            ->where('detail_media.flag','1')
            ->get();
            return view('content.admin_media.detailmedia_delete', compact("data"), ['title' => 'Detail Media', 'sidebardetailmedia' => 'active']);
        }else{
            return view('/login');
        }
    }

    public function destroydetailmedia($id)
    {
        if (Auth::user()->jabatan == "admin media") {

            $destroy_detailmedia = DetailMedia::find($id);
            $destroy_detailmedia->flag = '1';
            $destroy = $destroy_detailmedia->save();

            if($destroy){
                Session::flash('success', 'Berhasil Menghapus Data !');
                return redirect()->route('detailmedia');
            } else {
                Session::flash('errors', ['' => 'Gagal Menghapus Data!']);
                return redirect()->route('detailmedia');
            }
        }else{
                return view('login');
        }
    }

    public function undestroydetailmedia($id)
    {
        if (Auth::user()->jabatan == "admin media") {

            $undestroy_detailmedia = DetailMedia::find($id);
            $undestroy_detailmedia->flag = '0';
            $destroy = $undestroy_detailmedia->save();

            if($destroy){
                Session::flash('success', 'Berhasil Mengambalikan Data !');
                return redirect()->route('detailmediaterhapus');
            } else {
                Session::flash('errors', ['' => 'Gagal Mengambalikan Data!']);
                return redirect()->route('detailmediaterhapus');
            }
        }else{
                return view('login');
        }
    }

    public function satuan()
    {
        if (Auth::user()->jabatan == "admin media") {
            $data = DB::table('satuan')
            ->select(
                'id','satuan')
            ->where('flag', '0')
            ->get();
            return view('content.admin_media.satuan', compact("data"), ['title' => 'Satuan', 'sidebarsatuan' => 'active']);
        }else{
            return view('/login');
        }
    }

    public function insertsatuan(Request $request)
    {
        if (Auth::user()->jabatan == "admin media") {
            $rules = [
                'satuan'                => 'required'
            ];
        
            $messages = [
                'satuan.required'         => 'Satuan wajib diisi'
            ];
        
            $validator = Validator::make($request->all(), $rules, $messages);
    
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
    
            $satuan = new Satuan;
            $satuan->satuan = $request->satuan;
            $simpan = $satuan->save();
               
            if($simpan){
                Session::flash('success', 'Berhasil Memasukan Data !');
                return redirect()->route('satuan');
            } else {
                Session::flash('errors', ['' => 'Gagal Memasukan Data!']);
                return redirect()->route('satuan');
            }
        }else{
                return view('login');
        }
    }

    public function updatesatuan(Request $request, $id)
    {
        if (Auth::user()->jabatan == "admin media") {
            $rules = [
                'satuan'                => 'required'
            ];
        
            $messages = [
                'satuan.required'         => 'Satuan wajib diisi'
            ];
        
            $validator = Validator::make($request->all(), $rules, $messages);
    
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }
    
            $update = Satuan::where('id',$request->id)->update(request()->except(['_token','input']));
               
            if($update){
                Session::flash('success', 'Berhasil Merubah Data !');
                return redirect()->route('satuan');
            } else {
                Session::flash('errors', ['' => 'Gagal Merubah Data!']);
                return redirect()->route('satuan');
            }
        }else{
                return view('login');
        }
    }

    public function satuanterhapus()
    {
        if (Auth::user()->jabatan == "admin media") {
            $data = DB::table('satuan')
            ->select(
                'id','satuan')
            ->where('flag', '1')
            ->get();
            return view('content.admin_media.satuan_delete', compact("data"), ['title' => 'Satuan', 'sidebarsatuan' => 'active']);
        }else{
            return view('/login');
        }
    }

    public function destroysatuan($id)
    {
        if (Auth::user()->jabatan == "admin media") {

            $destroy_satuan = Satuan::find($id);
            $destroy_satuan->flag = '1';
            $destroy = $destroy_satuan->save();

            if($destroy){
                Session::flash('success', 'Berhasil Menghapus Data !');
                return redirect()->route('satuan');
            } else {
                Session::flash('errors', ['' => 'Gagal Menghapus Data!']);
                return redirect()->route('satuan');
            }
        }else{
                return view('login');
        }
    }

    public function undestroysatuan($id)
    {
        if (Auth::user()->jabatan == "admin media") {

            $undestroy_satuan = Satuan::find($id);
            $undestroy_satuan->flag = '0';
            $destroy = $undestroy_satuan->save();

            if($destroy){
                Session::flash('success', 'Berhasil Mengambalikan Data !');
                return redirect()->route('satuanterhapus');
            } else {
                Session::flash('errors', ['' => 'Gagal Mengambalikan Data!']);
                return redirect()->route('satuanterhapus');
            }
        }else{
                return view('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function acc($id){
        if (Auth::user()->jabatan == "admin media") {
            DB::table('detailorder')->where('id',$id)->update([
                'statusorder' => '1'
            ]);
            // Armada::find($id)->delete();
            Session::flash('success', 'Berhasil Menghapus Data');
            return redirect()->route('dashboardadminmedia');
        } else{
            return view('/login');
        }
    }

    public function tolak($id){
        if (Auth::user()->jabatan == "admin media") {
            DB::table('detailorder')->where('id',$id)->update([
                'statusorder' => '2'
            ]);
            // Armada::find($id)->delete();
            Session::flash('success', 'Berhasil Menghapus Data');
            return redirect()->route('dashboardadminmedia');
        }else{
            return view('/login');
        }
    }

    public function destroy($id){
        Media::find($id)->delete();
        Session::flash('success', 'Berhasil Menghapus Data');
        return redirect()->route('agent');
    }

    public function autocompletemedia(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table('media')
            ->select(
                'id', 
                'kode',
                'nama_media',
                'expired',
                'batch')
            ->where('nama_media','LIKE',"%$search%")
            ->get();
        }
        return response()->json($data);
    }

    public function autocompletesatuan(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table('satuan')
            ->select(
                'id', 
                'satuan')
            ->where('satuan','LIKE',"%$search%")
            ->get();
        }
        return response()->json($data);
    }
}

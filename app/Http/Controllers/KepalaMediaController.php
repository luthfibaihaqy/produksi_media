<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Models\DetailOrder;
use App\Models\DetailMedia;
use App\Models\Media;
use App\Models\Satuan;
use Session;
use Illuminate\Http\Request;

class KepalaMediaController extends Controller
{
    public function index()
    {
        if (Auth::user()->jabatan == "kepala media") {
            $data = DB::select("select 
            detailorder.id as id, 
            media.kode as kode, 
            media.nama_media as nama_media, 
            media.batch as batch, 
            MONTHNAME(detailorder.tanggal_order) as bulan,
            sum(detailorder.jumlah) as total,
            detail_media.stok as stok,
            media.batch as batch
            from detailorder 
            INNER JOIN
            detail_media
            on detail_media.id = detailorder.idmedia
            INNER JOIN media
            ON media.id = detail_media.id_media
            where detailorder.statusorder = '1' and month(detailorder.tanggal_order) = MONTH(NOW()) and YEAR(detailorder.tanggal_order) = YEAR(NOW())
            GROUP BY media.nama_media");

            // $data2 = DB::select();
            return view('content.kepala_media.dashboard', compact("data"), ['title' => 'Dashboard', 'sidebardashboard' => 'active']);
        }else{
            return view('/login');
        }
    }
    

    public function orderperbulan(Request $request)
    {
        if (Auth::user()->jabatan == "kepala media") {
            $data = DB::select("select 
            detailorder.id as id, 
            media.kode as kode, 
            media.nama_media as nama_media, 
            media.batch as batch, 
            MONTHNAME(detailorder.tanggal_order) as bulan,
            sum(detailorder.jumlah) as total,
            detail_media.stok as stok,
            media.batch as batch
            from detailorder 
            INNER JOIN
            detail_media
            on detail_media.id = detailorder.idmedia
            INNER JOIN media
            ON media.id = detail_media.id_media
            where detailorder.statusorder = '1' and month(detailorder.tanggal_order) = $request->bulan
            GROUP BY media.nama_media");
            return view('content.kepala_media.dashboard', compact("data"), ['title' => 'Dashboard', 'sidebardashboard' => 'active']);
        }else{
            return view('/login');
        }
    }

    public function generate(Request $request)
    {
        
        return view('content.kepala_media.generate',  ['title' => 'Generate Jadwal', 'sidebargenerate' => 'active']);
        
    }
}


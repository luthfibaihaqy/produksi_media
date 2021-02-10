<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\UserOrder;  
use App\Http\Controllers\AdminMedia;  
use App\Http\Controllers\KepalaMediaController;  




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'showFormLogin'])->name('loginshow');
Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showFormRegister']);
Route::post('register', [AuthController::class, 'register'])->name('register');


Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    //user
    Route::get('/dashboard', [UserOrder::class, 'index'])->name('dashboard');
    Route::get('/order', [UserOrder::class, 'order'])->name('order');
    Route::get('/order/destroy/{id}', [UserOrder::class, 'destroy']);
    Route::get('/order/autocompletemedia',[UserOrder::class, 'autocompletemedia'])->name('order/autocompletemedia');
    Route::post('/order/create',[UserOrder::class, 'create'])->name('order/create');

    //admin media
    Route::get('/dashboardadminmedia', [AdminMedia::class, 'index'])->name('dashboardadminmedia');
    Route::get('/media', [AdminMedia::class, 'media'])->name('media');
    Route::post('/media/insertmedia', [AdminMedia::class, 'insertmedia']);
    Route::post('/media/updatemedia/{id}', [AdminMedia::class, 'updatemedia']);
    Route::get('/mediaterhapus', [AdminMedia::class, 'mediaterhapus'])->name('mediaterhapus');
    Route::get('/media/destroy/{id}', [AdminMedia::class, 'destroymedia']);
    Route::get('/media/undestroy/{id}', [AdminMedia::class, 'undestroymedia']);

    Route::get('adminmedia/acc/{id}', [AdminMedia::class, 'acc']);
    Route::get('adminmedia/tolak/{id}', [AdminMedia::class, 'tolak']);
    

    Route::get('/detailmedia', [AdminMedia::class, 'detailmedia'])->name('detailmedia');
    Route::post('/detailmedia/insertdetailmedia', [AdminMedia::class, 'insertdetailmedia']);
    Route::post('/detailmedia/updatedetailmedia/{id}', [AdminMedia::class, 'updatedetailmedia']);
    Route::get('/detailmedia/autocompletemedia',[AdminMedia::class, 'autocompletemedia'])->name('detailmedia/autocompletemedia');
    Route::get('/detailmedia/autocompletesatuan',[AdminMedia::class, 'autocompletesatuan'])->name('detailmedia/autocompletesatuan');
    Route::get('/detailmediaterhapus', [AdminMedia::class, 'detailmediaterhapus'])->name('detailmediaterhapus');
    Route::get('/detailmedia/destroy/{id}', [AdminMedia::class, 'destroydetailmedia']);
    Route::get('/detailmedia/undestroy/{id}', [AdminMedia::class, 'undestroydetailmedia']);

    Route::get('/satuan', [AdminMedia::class, 'satuan'])->name('satuan');
    Route::post('/satuan/insertsatuan', [AdminMedia::class, 'insertsatuan']);
    Route::post('/satuan/updatesatuan/{id}', [AdminMedia::class, 'updatesatuan']);
    Route::get('/satuanterhapus', [AdminMedia::class, 'satuanterhapus'])->name('satuanterhapus');
    Route::get('/satuan/destroy/{id}', [AdminMedia::class, 'destroysatuan']);
    Route::get('/satuan/undestroy/{id}', [AdminMedia::class, 'undestroysatuan']);

    // Kepala Media
    Route::get('/dashboardkepalamedia', [KepalaMediaController::class, 'index'])->name('dashboardkepalamedia');
    Route::post('/kepalamedia/orderperbulan', [KepalaMediaController::class, 'orderperbulan'])->name('/kepalamedia/orderperbulan');
    Route::get('/kepalamedia/generate', [KepalaMediaController::class, 'generate'])->name('generate');
    Route::post('/kepalamedia/generatecreate',[KepalaMediaController::class, 'create'])->name('/kepalamedia/generatecreate');
});


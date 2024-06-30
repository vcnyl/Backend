<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\WhatsAppController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/input_user', [UserController::class, 'input_user']);
Route::post('/login_user', [UserController::class, 'login_user']);
Route::get('/getall_user', [UserController::class, 'getall_user']);
Route::get('/get_detail_user/{id}', [UserController::class, 'get_detail_user']);
Route::post('/update_user/{id}', [UserController::class, 'update_user']);
Route::delete('/delete_user/{id}', [UserController::class, 'delete_user']);
Route::get('/get_search_user/{parameter}', [UserController::class, 'get_search_user']);

//PelangganController
Route::post('/input_pelanggan', [PelangganController::class, 'input_pelanggan']);
Route::get('/getall_pelanggan', [PelangganController::class, 'getall_pelanggan']);
Route::get('/get_detail_pelanggan/{id}', [PelangganController::class, 'get_detail_pelanggan']);
Route::delete('/delete_pelanggan/{id}', [PelangganController::class, 'delete_pelanggan']);
Route::post('/update_pelanggan/{id}', [PelangganController::class, 'update_pelanggan']);
Route::get('/get_search_pelanggan/{parameter}', [PelangganController::class, 'get_search_pelanggan']);

//JadwalController
Route::post('/input_jadwal', [JadwalController::class, 'input_jadwal']);
Route::get('/getall_jadwal', [JadwalController::class, 'getall_jadwal']);
Route::get('/get_detail_jadwal/{id}', [JadwalController::class, 'get_detail_jadwal']);
Route::get('/get_edit_jadwal/{id}', [JadwalController::class, 'get_edit_jadwal']);
Route::delete('/delete_jadwal/{id}', [JadwalController::class, 'delete_jadwal']);
Route::delete('/delete_jadwal_pelanggan/{id}', [JadwalController::class, 'delete_jadwal_pelanggan']);
Route::delete('/delete_jadwal_karyawan/{id}', [JadwalController::class, 'delete_jadwal_karyawan']);
Route::post('/update_jadwal/{id}', [JadwalController::class, 'update_jadwal']);
Route::get('/getall_jadwal_bulan', [JadwalController::class, 'getall_jadwal_bulan']);
Route::get('/getall_form_jadwal', [JadwalController::class, 'getall_form_jadwal']);
Route::get('/get_search_jadwal/{parameter}', [JadwalController::class, 'get_search_jadwal']);
Route::post('/send-whatsapp', [WhatsAppController::class, 'send']);
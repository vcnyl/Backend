<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\WhatsAppController;

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

Route::get('/', function () {
    return view('welcome');
});


//Route ini untuk menampilkan gambar
Route::get('/get-image/{filename}', function ($filename) {
    $path = storage_path('app/' . $filename);

    if (!Storage::exists("{$filename}")) {
        abort(404);
    }

    return response()->file($path);
})->where('filename', '.*');

Route::post('/send-whatsapp', [WhatsAppController::class, 'send']);
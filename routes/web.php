<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

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

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('masyarakat')->group(function () {
    Route::get('all', [MasyarakatController::class, 'show_all']);
    Route::get('search/{id_masyarakat}', [MasyarakatController::class, 'show_once']);
    Route::post('store', [MasyarakatController::class, 'store']);
    Route::post('update/profile', [MasyarakatController::class, 'update_profile']);
    Route::put('update/password', [MasyarakatController::class, 'update_password']);
    Route::post('delete', [MasyarakatController::class, 'destroy']);
});

Route::prefix('petugas')->group(function () {
    Route::get('all', [PetugasController::class, 'show_all']);
    Route::get('search/{id_petugas}', [PetugasController::class, 'show_once']);
    Route::post('store', [PetugasController::class, 'store']);
    Route::post('update/profile', [PetugasController::class, 'update_profile']);
    Route::put('update/password', [PetugasController::class, 'update_password']);
    Route::post('delete/', [PetugasController::class, 'destroy']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

Route::group([
    'prefix' => 'pengaduan'
], function () {
    Route::get('all/{id_masyarakat}', [PengaduanController::class, 'show_all']);
    Route::post('store', [PengaduanController::class, 'store']);
    Route::get('search/{id_pengaduan}', [PengaduanController::class, 'show_once']);
});
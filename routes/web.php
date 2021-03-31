<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PengaduanController;
use App\Models\Masyarakat;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('masyarakat')->group(function () {
    Route::get('all', [MasyarakatController::class, 'show_all']);
    Route::get('search/{nik}', [MasyarakatController::class, 'show_once']);
    Route::post('store', [MasyarakatController::class, 'store']);
    Route::put('update/profile', [MasyarakatController::class, 'update_profile']);
    Route::put('update/password', [MasyarakatController::class, 'update_password']);
    Route::delete('delete/{nik}', [MasyarakatController::class, 'destroy']);
});

Route::prefix('petugas')->group(function () {
    Route::get('all', [PetugasController::class, 'show_all']);
    Route::get('search/{id_petugas}', [PetugasController::class, 'show_once']);
    Route::post('store', [PetugasController::class, 'store']);
    Route::put('update/profile', [PetugasController::class, 'update_profile']);
    Route::put('update/password', [PetugasController::class, 'update_password']);
    Route::delete('delete/{id_petugas}', [PetugasController::class, 'destroy']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});
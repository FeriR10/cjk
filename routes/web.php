<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KartuController;
use App\Http\Controllers\PulsaController;
use App\Http\Controllers\BillerController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BillerPulsaController;
use App\Http\Controllers\DealerPulsaController;
use App\Http\Controllers\SupplierPulsaController;
use App\Http\Controllers\PenjualanBillerPulsaController;
use App\Http\Controllers\PenjualanDealerPulsaController;
use App\Http\Controllers\PenjualanSupplierPulsaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// All role
Route::group(['middleware' => 'guest'], function(){
    
    // Auth
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-process', [AuthController::class, 'loginProcess']);
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register-process', [AuthController::class, 'registerProcess']);
    
});

// All role
Route::group(['middleware' => 'auth'], function(){
    
    // Auth
    Route::get('/logout', [AuthController::class, 'logout']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // User
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/add', [UserController::class, 'add']);
    Route::post('/user/create', [UserController::class, 'create']);
    Route::get('/user/{id}/edit', [UserController::class, 'edit']);
    Route::put('/user/{id}/update', [UserController::class, 'update']);
    Route::put('/user/{id}/delete', [UserController::class, 'delete']);
    Route::get('/user/{id}/status', [UserController::class, 'status']);
    Route::put('/user/{id}/status-update', [UserController::class, 'statusUpdate']);

    // Pulsa
    Route::get('/pulsa', [PulsaController::class, 'index']);
    Route::get('/pulsa/add', [PulsaController::class, 'add']);
    Route::post('/pulsa/create', [PulsaController::class, 'create']);
    Route::get('/pulsa/{id}/edit', [PulsaController::class, 'edit']);
    Route::put('/pulsa/{id}/update', [PulsaController::class, 'update']);
    Route::put('/pulsa/{id}/delete', [PulsaController::class, 'delete']);

    // Kartu
    Route::get('/kartu', [KartuController::class, 'index']);
    Route::get('/kartu/add', [KartuController::class, 'add']);
    Route::post('/kartu/create', [KartuController::class, 'create']);
    Route::get('/kartu/{id}/edit', [KartuController::class, 'edit']);
    Route::put('/kartu/{id}/update', [KartuController::class, 'update']);
    Route::put('/kartu/{id}/delete', [KartuController::class, 'delete']);
    
    // Supplier
    Route::get('/supplier', [SupplierController::class, 'index']);
    Route::get('/supplier/add', [SupplierController::class, 'add']);
    Route::post('/supplier/create', [SupplierController::class, 'create']);
    Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/supplier/{id}/update', [SupplierController::class, 'update']);
    Route::put('/supplier/{id}/delete', [SupplierController::class, 'delete']);
    
    // Supplier Pulsa
    Route::get('/supplier-pulsa', [SupplierPulsaController::class, 'index']);
    Route::get('/supplier-pulsa/add', [SupplierPulsaController::class, 'add']);
    Route::post('/supplier-pulsa/create', [SupplierPulsaController::class, 'create']);
    Route::get('/supplier-pulsa/{id}/edit', [SupplierPulsaController::class, 'edit']);
    Route::put('/supplier-pulsa/{id}/update', [SupplierPulsaController::class, 'update']);
    Route::put('/supplier-pulsa/{id}/delete', [SupplierPulsaController::class, 'delete']);
    
    // Penjualan Supplier Pulsa
    Route::get('/penjualan-supplier-pulsa', [PenjualanSupplierPulsaController::class, 'index']);
    Route::get('/penjualan-supplier-pulsa/add', [PenjualanSupplierPulsaController::class, 'add']);
    Route::post('/penjualan-supplier-pulsa/create', [PenjualanSupplierPulsaController::class, 'create']);
    Route::get('/penjualan-supplier-pulsa/{id}/edit', [PenjualanSupplierPulsaController::class, 'edit']);
    Route::put('/penjualan-supplier-pulsa/{id}/update', [PenjualanSupplierPulsaController::class, 'update']);
    Route::put('/penjualan-supplier-pulsa/{id}/delete', [PenjualanSupplierPulsaController::class, 'delete']);

    // Dealer
    Route::get('/dealer', [DealerController::class, 'index']);
    Route::get('/dealer/add', [DealerController::class, 'add']);
    Route::post('/dealer/create', [DealerController::class, 'create']);
    Route::get('/dealer/{id}/edit', [DealerController::class, 'edit']);
    Route::put('/dealer/{id}/update', [DealerController::class, 'update']);
    Route::put('/dealer/{id}/delete', [DealerController::class, 'delete']);

    // Dealer Pulsa
    Route::get('/dealer-pulsa', [DealerPulsaController::class, 'index']);
    Route::get('/dealer-pulsa/add', [DealerPulsaController::class, 'add']);
    Route::post('/dealer-pulsa/create', [DealerPulsaController::class, 'create']);
    Route::get('/dealer-pulsa/{id}/tambah-saldo', [DealerPulsaController::class, 'tambahSaldo']);
    Route::post('/dealer-pulsa/{id}/create-tambah-saldo', [DealerPulsaController::class, 'createTambahSaldo']);
    Route::get('/dealer-pulsa/{id}/edit', [DealerPulsaController::class, 'edit']);
    Route::put('/dealer-pulsa/{id}/update', [DealerPulsaController::class, 'update']);
    Route::put('/dealer-pulsa/{id}/delete', [DealerPulsaController::class, 'delete']);

    // Penjualan Dealer Pulsa
    Route::get('/penjualan-dealer-pulsa', [PenjualanDealerPulsaController::class, 'index']);
    Route::get('/penjualan-dealer-pulsa/add', [PenjualanDealerPulsaController::class, 'add']);
    Route::post('/penjualan-dealer-pulsa/create', [PenjualanDealerPulsaController::class, 'create']);
    Route::get('/penjualan-dealer-pulsa/{id}/edit', [PenjualanDealerPulsaController::class, 'edit']);
    Route::put('/penjualan-dealer-pulsa/{id}/update', [PenjualanDealerPulsaController::class, 'update']);
    Route::put('/penjualan-dealer-pulsa/{id}/delete', [PenjualanDealerPulsaController::class, 'delete']);

    // Biller
    Route::get('/biller', [BillerController::class, 'index']);
    Route::get('/biller/add', [BillerController::class, 'add']);
    Route::post('/biller/create', [BillerController::class, 'create']);
    Route::get('/biller/{id}/edit', [BillerController::class, 'edit']);
    Route::put('/biller/{id}/update', [BillerController::class, 'update']);
    Route::put('/biller/{id}/delete', [BillerController::class, 'delete']);

    // Biller Pulsa
    Route::get('/biller-pulsa', [BillerPulsaController::class, 'index']);
    Route::get('/biller-pulsa/add', [BillerPulsaController::class, 'add']);
    Route::post('/biller-pulsa/create', [BillerPulsaController::class, 'create']);
    Route::get('/biller-pulsa/{id}/tambah-saldo', [BillerPulsaController::class, 'tambahSaldo']);
    Route::post('/biller-pulsa/{id}/create-tambah-saldo', [BillerPulsaController::class, 'createTambahSaldo']);
    Route::get('/biller-pulsa/{id}/edit', [BillerPulsaController::class, 'edit']);
    Route::put('/biller-pulsa/{id}/update', [BillerPulsaController::class, 'update']);
    Route::put('/biller-pulsa/{id}/delete', [BillerPulsaController::class, 'delete']);
    
    // Penjualan Biller Pulsa
    Route::get('/penjualan-biller-pulsa', [PenjualanBillerPulsaController::class, 'index']);
    Route::get('/penjualan-biller-pulsa/add', [PenjualanBillerPulsaController::class, 'add']);
    Route::post('/penjualan-biller-pulsa/create', [PenjualanBillerPulsaController::class, 'create']);
    Route::get('/penjualan-biller-pulsa/{id}/edit', [PenjualanBillerPulsaController::class, 'edit']);
    Route::put('/penjualan-biller-pulsa/{id}/update', [PenjualanBillerPulsaController::class, 'update']);
    Route::put('/penjualan-biller-pulsa/{id}/delete', [PenjualanBillerPulsaController::class, 'delete']);
});



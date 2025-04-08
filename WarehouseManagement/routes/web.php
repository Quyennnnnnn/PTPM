<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NguyenLieuController;
use App\Http\Controllers\LoaiNguyenLieuController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\PhieuNhapController;
use App\Http\Controllers\PhieuXuatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CoSoController;
use App\Http\Controllers\Api\NhapKhoController;
use App\Http\Controllers\Api\XuatKhoController;

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

Route::middleware(['auth'])->group(function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('nguyen-lieu')->group(function () {
        Route::get('/', [NguyenLieuController::class, 'index'])->name('nguyen-lieu.index');
        Route::get('/xem/{code}', [NguyenLieuController::class, 'show'])->name('nguyen-lieu.show');

        Route::get('/xem/{code}?{ma_ncc}', [NguyenLieuController::class, 'show'])->name('nguyen-lieu.showInfo');

        Route::get('/them', [NguyenLieuController::class, 'create'])->name('nguyen-lieu.create');
        Route::post('/them', [NguyenLieuController::class, 'store'])->name('nguyen-lieu.store');

        Route::get('/sua/{code}', [NguyenLieuController::class, 'edit'])->name('nguyen-lieu.edit');
        Route::put('/sua/{code}', [NguyenLieuController::class, 'update'])->name('nguyen-lieu.update');

        Route::delete('/xoa/{id}', [NguyenLieuController::class, 'destroy'])->name('nguyen-lieu.delete');
    });

    Route::prefix('loai-nguyen-lieu')->group(function () {
        Route::get('/', [LoaiNguyenLieuController::class, 'index'])->name('loai-nguyen-lieu.index');
        Route::get('/them', [LoaiNguyenLieuController::class, 'create'])->name('loai-nguyen-lieu.create');
        Route::post('/them', [LoaiNguyenLieuController::class, 'store'])->name('loai-nguyen-lieu.store');
        Route::get('/sua/{id}', [LoaiNguyenLieuController::class, 'edit'])->name('loai-nguyen-lieu.edit');
        Route::put('/sua/{id}', [LoaiNguyenLieuController::class, 'update'])->name('loai-nguyen-lieu.update');
        Route::get('/xem/{id}', [LoaiNguyenLieuController::class, 'show'])->name('loai-nguyen-lieu.show');
        Route::delete('/xoa/{id}', [LoaiNguyenLieuController::class, 'destroy'])->name('loai-nguyen-lieu.destroy');
    });

    Route::prefix('nhap-kho')->group(function () {
        Route::get('/', [PhieuNhapController::class, 'index'])->name('nhap-kho.index');
        Route::get('/tao-phieu', [PhieuNhapController::class, 'create'])->name('nhap-kho.create');
        Route::post('/tao-phieu/store', [PhieuNhapController::class, 'store'])->name('nhap-kho.store');
        Route::post('/tao-phieu', [PhieuNhapController::class, 'import'])->name('nhap-kho.import');
        Route::get('/xem/{code}', [PhieuNhapController::class, 'show'])->name('nhap-kho.show');
        Route::delete('xoa/{code}',[PhieuNhapController::class, 'destroy'])->name('phieu-nhap.delete')->middleware('can:user');
    });

    Route::prefix('xuat-kho')->group(function () {
        Route::get('/', [PhieuXuatController::class, 'index'])->name('xuat-kho.index');
        Route::get('/xuat-kho/create', [PhieuXuatController::class, 'create'])->name('xuat-kho.create');
        Route::post('/tao-phieu', [PhieuXuatController::class, 'store'])->name('xuat-kho.store');
        Route::post('/tao-phieu-excel', [PhieuXuatController::class, 'import'])->name('xuat-kho.import');
        Route::get('/xem/{code}', [PhieuXuatController::class, 'show'])->name('xuat-kho.show');
        Route::delete('xoa/{code}',[PhieuXuatController::class, 'destroy'])->name('phieu-xuat.delete')->middleware('can:user');
    });


    Route::prefix('nha-cung-cap')->group(function () {
        Route::get('/', [NhaCungCapController::class, 'index'])->name('nha-cung-cap.index');
        Route::get('/them', [NhaCungCapController::class, 'create'])->name('nha-cung-cap.create');
        Route::post('/them', [NhaCungCapController::class, 'store'])->name('nha-cung-cap.store');
        Route::get('/xem/{code}', [NhaCungCapController::class, 'show'])->name('nha-cung-cap.show');
        Route::get('/sua/{code}', [NhaCungCapController::class, 'edit'])->name('nha-cung-cap.edit');
        Route::put('/sua/{code}', [NhaCungCapController::class, 'update'])->name('nha-cung-cap.update');
        Route::delete('xoa/{code}',[NhaCungCapController::class, 'destroy'])->name('nha-cung-cap.delete');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/{id}', [UserController::class, 'show'])->name('user.show');
        Route::post('/doi-mat-khau', [UserController::class, 'updatePassword'])->name('user.updatePassword');
        Route::put('/doi-thong-tin', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    });

    Route::prefix('thong-ke')->group(function () {
        Route::get('/', [ThongKeController::class, 'index'])->name('thong-ke.index');
    });

    Route::prefix('tai-khoan')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('tai-khoan.index')->middleware('can:user');

        Route::get('/them-tai-khoan', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('can:user');
        Route::post('/them-tai-khoan', [RegisterController::class, 'register'])->middleware('can:user');

        Route::put('/{id}', [UserController::class, 'changeRole'])->name('user.changeRole')->middleware('can:user');
        Route::get('/xem/{id}', [UserController::class, 'showUser'])->name('tai-khoan.showUser')->middleware('can:user');
        Route::delete('/xoa/{id}', [UserController::class, 'delete'])->name('tai-khoan.delete')->middleware('can:user');
    });
    Route::prefix('co-so')->group(function () {
        Route::get('/', [CoSoController::class, 'index'])->name('co-so.index');
        Route::get('/them', [CoSoController::class, 'create'])->name('co-so.create');
        Route::post('/them', [CoSoController::class, 'store'])->name('co-so.store');
        Route::get('/xem/{code}', [CoSoController::class, 'show'])->name('co-so.show');
        Route::get('/sua/{id}', [CoSoController::class, 'edit'])->name('co-so.edit');
        Route::put('/sua/{id}', [CoSoController::class, 'update'])->name('co-so.update');
        Route::delete('xoa/{id}',[CoSoController::class, 'destroy'])->name('co-so.destroy');
    });




    Route::post('/nhap-kho/store', [NhapKhoController::class, 'store'])->name('api.nhap-kho.store');
    Route::post('/nhap-kho/tao-phieu/them-nguyen-lieu', [NhapKhoController::class, 'add'])->name('api.them-nguyen-lieu.add');
    Route::post('/xuat-kho/tao-phieu/store', [XuatKhoController::class, 'store'])->name('api.xuat-kho.store');
    Route::post('/xuat-kho/tao-phieu/import', [XuatKhoController::class, 'import'])->name('api.xuat-kho.import');
    Route::get('/xuat-kho/tao-phieu', [XuatKhoController::class, 'search'])->name('api.xuat-kho.search');
    Route::post('/nguyen-lieu', [NguyenLieuController::class, 'import'])->name('api.them-nguyen-lieu.import');
    Route::get('/doanh-thu', [DashboardController::class, 'thongKeNhapXuatHangThang'])->name('api.doanh-thu');


});

Route::get('/dang-nhap', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/dang-nhap', [LoginController::class, 'login']);
Route::post('/dang-xuat', [LoginController::class, 'logout'])->name('logout');

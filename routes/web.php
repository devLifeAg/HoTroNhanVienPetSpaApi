<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

Route::post('/HoTroNhanVienPetSpaApi/login', [AppController::class, 'Login'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

//quản lý hoa hồng
Route::get('/HoTroNhanVienPetSpaApi/thongtinhoahong', [AppController::class, 'getDanhSachTTHH']);
Route::get('/HoTroNhanVienPetSpaApi/getdichvuchacon', [AppController::class, 'getDanhSachDichVuChaCon']);
Route::post('/HoTroNhanVienPetSpaApi/addTTHH', [AppController::class, 'themTTHH'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::put('/HoTroNhanVienPetSpaApi/updateTTHH', [AppController::class, 'capNhatTTHH'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::delete('/HoTroNhanVienPetSpaApi/deleteTTHH', [AppController::class, 'xoaTTHH'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

//quản lý ngày nghỉ
Route::get('/HoTroNhanVienPetSpaApi/getngaynghi', [AppController::class, 'getNgayNghi']);
Route::post('/HoTroNhanVienPetSpaApi/addngaynghi', [AppController::class, 'themNgayNghi'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::put('/HoTroNhanVienPetSpaApi/updatengaynghi', [AppController::class, 'capNhatNgayNghi'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::delete('/HoTroNhanVienPetSpaApi/deletengaynghi', [AppController::class, 'xoaNgayNghi'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

//quản lý tăng ca
Route::get('/HoTroNhanVienPetSpaApi/gettangca', [AppController::class, 'getTangCa']);
Route::post('/HoTroNhanVienPetSpaApi/addtangca', [AppController::class, 'themTangCa'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::put('/HoTroNhanVienPetSpaApi/updatetangca', [AppController::class, 'capNhatTangCa'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::delete('/HoTroNhanVienPetSpaApi/deletetangca', [AppController::class, 'xoaTangCa'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

//xem bảng lương
Route::get('/HoTroNhanVienPetSpaApi/getbangluong', [AppController::class, 'getBangLuong']);

//call api
Route::post('/callDeepSeekAPI', [AppController::class, 'callDeepseekR1'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::post('/HoTroNhanVienPetSpaApi/phantich', [AppController::class, 'aiPhanTichTaiChinh'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
// Route::get('/HoTroNhanVienPetSpaApi/phantich', [AppController::class, 'aiPhanTichTaiChinh']);

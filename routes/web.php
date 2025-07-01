<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DienDanController;
Route::get('/',[UserController::class,'dashboard'])->name('home');
Route::get('/login',[UserController::class,'login'])->name('login');
Route::post('/login',[UserController::class,'loginPost'])->name('login.post');
Route::get('/register',[UserController::class,'register'])->name('register');
Route::post('/register',[UserController::class,'registerPost'])->name('register.post');
Route::get('/logout',[UserController::class,'logout'])->name('logout');
Route::get('/dashboard',[UserController::class,'dashboard'])->name('user.dashboard');
Route::get('/profile',[UserController::class,'profile'])->name('user.profile');
Route::post('/profile',[UserController::class,'profilePost'])->name('user.profile.post');
Route::get('/profile/edit',[UserController::class,'profileEdit'])->name('user.profile.edit');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/upload-file',[UserController::class,'uploadFile'])->name('user.upload-file');
    Route::post('/upload-file',[UserController::class,'uploadFilePost'])->name('user.upload-file.post');
    Route::delete('/user/delete-image/{id}',[UserController::class,'deleteImage'])->name('user.delete-image');
});

// Routes cho bình luận (yêu cầu đăng nhập)
Route::group(['middleware' => 'auth'], function () {
    Route::post('/comments', [DienDanController::class, 'storeComment'])->name('comments.store');
    Route::get('/comments/{postId}', [DienDanController::class, 'getComments'])->name('comments.get');
    Route::put('/comments/{commentId}', [DienDanController::class, 'updateComment'])->name('comments.update');
    Route::delete('/comments/{commentId}', [DienDanController::class, 'deleteComment'])->name('comments.delete');
    Route::get('/dien-dan-cua-toi',[DienDanController::class,'dienDanCuaToi'])->name('dien-dan.cua-toi');
    Route::get('/doi-mat-khau',[UserController::class,'doiMatKhau'])->name('user.doi-mat-khau');
    Route::post('/doi-mat-khau',[UserController::class,'doiMatKhauPost'])->name('user.doi-mat-khau.post');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'dien-dan'], function () {
        Route::get('/danh-muc',[AdminController::class,'danhMucDienDan'])->name('admin.danh-muc-dien-dan');
        Route::get('/danh-sach',[AdminController::class,'danhSachDienDan'])->name('admin.danh-sach-dien-dan');
        Route::post('/danh-muc',[AdminController::class,'storeDanhMuc'])->name('admin.danh-muc.store');
        Route::post('/danh-muc/{id}',[AdminController::class,'updateDanhMuc'])->name('admin.danh-muc.update');
        Route::delete('/danh-muc/{id}',[AdminController::class,'deleteDanhMuc'])->name('admin.danh-muc.delete');
        Route::get('/danh-muc/{id}',[AdminController::class,'getDanhMuc'])->name('admin.danh-muc.get');
        // Routes cho quản lý diễn đàn
        Route::post('/tao-dien-dan',[AdminController::class,'taoDienDan'])->name('admin.dien-dan.store');
        Route::post('/{id}',[AdminController::class,'updateDienDan'])->name('admin.dien-dan.update');
        Route::delete('/{id}',[AdminController::class,'deleteDienDan'])->name('admin.dien-dan.delete');
        Route::get('/{id}',[AdminController::class,'getDienDan'])->name('admin.dien-dan.get');
        });
    });
    Route::group(['prefix' => 'tai-khoan'], function () {
        Route::get('/',[UserController::class,'taiKhoan'])->name('user.tai-khoan');
        Route::put('/update-profile',[UserController::class,'updateProfile'])->name('user.update-profile');
    });
});

Route::get('/dien-dan/{slug}.html',[DienDanController::class,'dienDanTheoDanhMuc'])->name('dien-dan-theo-danh-muc');
Route::get('/chi-tiet-dien-dan/{slug}.html',[DienDanController::class,'chiTietDienDan'])->name('dien-dan.chi-tiet');
Route::get('/dien-dan-moi',[DienDanController::class,'dienDanMoi'])->name('dien-dan.moi');
Route::get('/dien-dan-quan-tam',[DienDanController::class,'dienDanQuanTam'])->name('dien-dan.quan-tam');
Route::get('/dien-dan-binh-luan-moi',[DienDanController::class,'dienDanBinhLuanMoi'])->name('dien-dan.binh-luan-moi');
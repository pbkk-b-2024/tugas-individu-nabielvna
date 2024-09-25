<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Pertemuan2Controller;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PBKK1Controller;
use App\Http\Controllers\Pertemuan3Controller;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\AuthMiddleware;

Route::get('/', [HomePageController::class, 'showContentPage'])->name('home');

Route::prefix('/PBKK1')->group(function(){
    Route::get('/even-odd', [PBKK1Controller::class, 'evenOdd'])->name('even-odd');
    Route::get('/fibbonaci',[PBKK1Controller::class,'fibonacci'])->name('fibonacci');
    Route::get('/prime-number', [PBKK1Controller::class, 'primeNumber'])->name('prime-number');
    Route::get('/param', fn() => view('PBKK1.param'))->name('param');
    Route::get('/param/{param1}', [PBKK1Controller::class, 'param1'])->name('param1');
    Route::get('/param/{param1}/{param2}', [PBKK1Controller::class, 'param2'])->name('param2');
});

Route::prefix('/pertemuan2')->group(function(){
    Route::resource('/crud-buku', Pertemuan2Controller::class);
});

Route::prefix('/pertemuan3')->group(function(){
    Route::get('/', [Pertemuan3Controller::class,'index'])->name('pertemuan3.index')->middleware(AuthMiddleware::class);
    Route::post('/login', [Pertemuan3Controller::class,'login'])->name('pertemuan3.login');
    Route::post('/register', [Pertemuan3Controller::class,'register'])->name('pertemuan3.register');
    Route::post('/logout', [Pertemuan3Controller::class,'logout'])->name('pertemuan3.logout');

});

Route::fallback(function () {
    return redirect('/');
});
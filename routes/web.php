<?php

use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\SenaraiController;
use App\Http\Controllers\HelpdeskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestLoginController;
use App\Http\Controllers\TestRegisterController;

//index/home page
Route::get('/',[DashboardController::class,'index'])->name('home');
Route::get('/home',[DashboardController::class,'index'])->name('home');

//calendar events fetch 
Route::get('kursus/events', [KursusController::class, 'getKursusEvents'])->name('kursus.events');

//navbar handler
Route::get('/test-navbar', [NavbarController::class, 'index']);
Route::get('/navbar',[MenuController::class, 'navbar']);

//helpdesk page
Route::get('/helpdesk',[HelpdeskController::class,'helpdesk']);
Route::post('/helpdesk',[HelpdeskController::class, 'store'])->name('helpdesk.store');

//galeri page
Route::get('/galeri',[GaleriController::class,'galeri']);

//daftar kursus page[HOME]
Route::get('/daftar_kursus', [KursusController::class, 'create'])->name('kursus.create');
Route::post('/daftar_kursus', [KursusController::class, 'store'])->name('kursus.store');

//senarai kursus page[HOME]
Route::get('/senarai_kursus',[SenaraiController::class,'index'])->name('senarai.index');

//test register route
Route::get('/register',[TestRegisterController::class,'create'])->name('register.create');
Route::post('/register',[TestRegisterController::class,'store'])->name('register.store');

//login route
Route::get('/login',[TestLoginController::class,'showLogin'])->name('login.show');
Route::post('/login',[TestLoginController::class,'checkLogin'])->name('login.check');

//logout route
Route::get('/logout',function(){
    session()->forget('user');
    session()->forget('user_level');
    return redirect()->route('login.show')->with('success','Berjaya log keluar!');
})->name('logout');

//statistik kehadiran route
Route::get('/statistik-kehadiran',[StatistikController::class, 'statistikKehadiran'])->name('statistik-kehadiran');
Route::get('/getJabatan',[StatistikController::class, 'getJabatan']);
Route::get('/getKursus',[StatistikController::class, 'getKursus']);
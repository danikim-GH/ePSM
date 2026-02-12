<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\SenaraiController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\HelpdeskController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirektoriController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\testDebugController;
use App\Http\Controllers\TestLoginController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\TestRegisterController;


//login route
Route::get('/login',[TestLoginController::class,'showLogin'])->middleware('guest:lampirana')->name('login');
Route::post('/login',[TestLoginController::class,'checkLogin'])->name('login.check');

//add middleware function for auth
Route::middleware('auth:lampirana')->group(function(){
    //index/home page
    Route::get('/',[DashboardController::class,'index'])->name('home');
    Route::get('/index.php',[DashboardController::class,'index']);
    Route::get('/home',[DashboardController::class,'index']);

    //sub info
    Route::get('/info/{id}', [InfoController::class, 'show'])->name('info.show');

    //daftar kursus page[HOME]
    Route::get('/daftar_kehadiran.php', [KursusController::class, 'create'])->name('kursus.create');
    Route::post('/daftar_kursus', [KursusController::class, 'store'])->name('kursus.store');
    //anjuran dropdown fetch route
    Route::get('/ajax/anjuran', [KursusController::class, 'getAnjuranList'])->name('ajax.anjuran');


    //calendar events fetch 
    Route::get('kursus/events', [KursusController::class, 'getKursusEvents'])->name('kursus.events');

    // Main gallery page
    Route::get('/galeri/{menuId}', [GaleriController::class, 'galeri'])
        ->name('galeri.menu');

    // Optional: AJAX route to get images for specific event
    Route::get('/galeri/event/{id}', [GaleriController::class, 'getEventImages'])->name('galeri.event');

    //navbar handler
    Route::get('/test-navbar', [NavbarController::class, 'index']);
    Route::get('/navbar',[MenuController::class, 'navbar']);

    // ========== MENU API ROUTES (NEW) ==========
    // Get side menu items based on user level (menu_arah = 'menutepi')
    Route::get('/api/menu/side-menu', [MenuController::class, 'getSideMenu'])->name('menu.side');
    Route::get('/api/menu/count', [MenuController::class, 'getMenuCount'])->name('menu.count');

    //direktori page
    Route::get('/direktori', [DirektoriController::class, 'index']);
    Route::get('/direktori/{id}', [DirektoriController::class, 'show'])->name('direktori.menu');

    //helpdesk page
    Route::get('/definisi.php',[HelpdeskController::class,'helpdesk'])->name('helpdesk');
    Route::post('/helpdesk',[HelpdeskController::class, 'store'])->name('helpdesk.store');

    //User Profile
    //Route::get('/profail.php', [UserProfileController::class, 'view'])->name('profile.view');
    Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');



    //senarai kursus page[HOME]
    Route::get('/kursus_semua.php',[SenaraiController::class,'index'])->name('senarai.index');

    //statistik kehadiran route
    Route::get('/statkehadiran.php',[StatistikController::class, 'statistikKehadiran'])->name('statistik-kehadiran');
    Route::get('/getJabatan',[StatistikController::class, 'getJabatan']);
    Route::get('/getKursus',[StatistikController::class, 'getKursus']);

    // Admin Approve Kursus
    Route::get('/admin-panel/sah-kursus',[KursusController::class,'viewAdminApproveKursus'])->name('admin.viewApproveKursus');
    Route::get('/admin/kursus/pending', [KursusController::class, 'getPendingKursus']);
    Route::get('/admin/kursus/details/{id}', [KursusController::class, 'getKursusDetails']);
    Route::post('/admin/kursus/approve/{id}', [KursusController::class, 'approveKursus']);

    // Admin Helpdesk
    Route::get('/admin-panel/admin-helpdesk', [HelpdeskController::class, 'adminHelpdeskView'])->name('admin.helpdesk');
    Route::get('/admin-panel/helpdesk/tickets', [HelpdeskController::class, 'getHelpdeskTickets'])->name('admin.helpdesk.tickets');
    Route::get('/admin-panel/helpdesk/tickets/{id}', [HelpdeskController::class, 'getHelpdeskDetail'])->name('admin.helpdesk.detail');
    Route::post('/admin-panel/helpdesk/tickets/{id}/status', [HelpdeskController::class, 'updateStatus'])->name('admin.helpdesk.updateStatus');

    //admin panel route
    Route::get('/admin/home.php',[AdminPanelController::class, 'adminView'])->name('adminView');//pending user page
    Route::post('/admin/approve/{nokp}', [AdminPanelController::class, 'approveUser'])->name('admin.approve');//admin approval user pending registration
    Route::get('/admin/edit-user/{nokp}',[AdminPanelController::class, 'editUser'])->name('admin.editUser');//admin button edit info user soon will be edit!!! 27/11/2025
    Route::post('/admin/suspend-user/{nokp}',[AdminPanelController::class, 'suspendUser'])->name('admin.suspendUser');//admin suspend user registration
    Route::get('/admin/suspended-count', function(){
        $count = DB::table('lampirana')->where('userlevel', 'SP')->count();
        return response()->json(['total_suspended' => $count]);
    });//count suspended user fetch using API
    Route::get('/admin/pending-users-count',[AdminPanelController::class, 'pendingUsersCount'])->name('admin.pendingUsersCount');//count pending user fetch using API
    Route::get('/admin-panel/pending-user-list',[AdminPanelController::class, 'pendingUsers'])->name('admin.pendingUsers');// fetch pending user list only
    Route::get('/admin-panel/suspended-user-list',[AdminPanelController::class, 'suspendedUsers'])->name('admin.suspendedUsers');//fetch suspended user list only
    Route::post('/admin/users/{nokp}/update-level',[AdminPanelController::class, 'updateLevel']);
    Route::delete('/admin/users/{nokp}',[AdminPanelController::class, 'deleteUser']);

    //Admin User List Routes
    Route::get('/admin-panel/user-list',[UserListController::class,'view'])->name('view');
    Route::get('/admin-panel/user-list/list',[UserListController::class,'getUsers']);
    Route::get('/admin-panel/user-list/total-users',[UserListController::class,'getTotalUsers']);//fetch total users count
    Route::delete('/admin-panel/users/{id}',[UserListController::class,'deleteUser']);//delete user by admin
    Route::put('/admin-panel/users/{id}',[UserListController::class,'updateUser']);//update user info by admin

    // Admin Settings Routes
    Route::prefix('admin-panel')->group(function () {
        Route::get('/settings', [AdminSettingController::class, 'adminSettingView'])->name('admin.setting');
        Route::get('/settings/carousel', [AdminSettingController::class, 'carouselSettingsView'])->name('admin.carousel.settings');
    });

    // Keep your existing carousel API routes as they are
    Route::prefix('admin')->group(function () {
        Route::get('/carousel', [CarouselController::class, 'index'])->name('admin.carousel');
        Route::post('/carousel/store', [CarouselController::class, 'store'])->name('admin.carousel.store');
        Route::get('/carousel/edit/{id}', [CarouselController::class, 'edit'])->name('admin.carousel.edit');
        Route::post('/carousel/update', [CarouselController::class, 'update'])->name('admin.carousel.update');
        Route::delete('/carousel/delete/{id}', [CarouselController::class, 'destroy'])->name('admin.carousel.delete');
        Route::get('/carousel/list', [CarouselController::class, 'list'])->name('admin.carousel.list');
    });


});

//test on kursus based on user auth
Route::get('/kursus-pengguna', [KursusController::class, 'myKursus'])->name('kursus.pengguna')->middleware('auth:lampirana');

//test register route
Route::get('/register',[TestRegisterController::class,'viewRegister'])->name('register.view');
Route::post('/register',[TestRegisterController::class,'store'])->name('register.store');


Route::post('/logout.php', function () { // Gunakan POST di sini
    Auth::guard('lampirana')->logout();   
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('login')
        ->with('success', 'Berjaya log keluar!');
})->name('logout');

//test debug view route
Route::get('/test-debug',[testDebugController::class,'viewDebug'])->name('testDebug');
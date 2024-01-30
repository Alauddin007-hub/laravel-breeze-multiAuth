<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->group(function(){
    Route::get('login',[AdminController::class, 'index'])->name('admin_login_form');
    Route::post('login/owner',[AdminController::class, 'login'])->name('admin.login');
    Route::post('logout',[AdminController::class, 'logout'])->name('admin.logout');
    Route::get('dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');
});

Route::prefix('marketing')->group(function(){
    Route::get('login',[MarketingController::class, 'index'])->name('marketing_login_form');
    Route::post('login/owner',[MarketingController::class, 'login'])->name('marketing.login');
    Route::post('logout',[MarketingController::class, 'logout'])->name('marketing.logout');
    Route::get('register',[MarketingController::class, 'marketing_create'])->name('marketing_create.create');
    Route::post('registed',[MarketingController::class, 'marketing_store'])->name('marketing_store.store');
    Route::get('dashboard',[MarketingController::class, 'dashboard'])->name('marketing.dashboard');
});

//->middleware('marketing')

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

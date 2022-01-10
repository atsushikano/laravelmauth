<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainUserContorller;
use App\Http\Controllers\MainAdminContorller;
use App\Http\Controllers\MainAdminController;

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

Route::group(['prefix'=>'admin','middleware'=>['admin:admin']],function(){
	Route::get('/login', [AdminController::class, 'loginForm']);
	Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});

Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
    return view('admin.index');
})->name('dashboard');

Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    return view('user.index');
})->name('dashboard');

Route::get('/admin/logout', [AdminController::class, 'destroy'] )->name('admin.logout');

Route::get('/user/logout', [MainUserContorller::class, 'Logout'] )->name('user.logout');
Route::get('/user/profile', [MainUserContorller::class, 'UserProfile'] )->name('user.profile');
Route::get('/user/profile/edit', [MainUserContorller::class, 'UserProfileEdit'] )->name('profile.edit');
Route::post('/user/profile/store', [MainUserContorller::class, 'UserProfileStore'] )->name('profile.store');
Route::get('/user/password/view', [MainUserContorller::class, 'UserPasswordView'] )->name('user.password.edit');
Route::post('/user/password/update', [MainUserContorller::class, 'UserPasswordUpdate'] )->name('user.password.update');

Route::get('/admin/profile', [MainAdminController::class, 'AdminProfile'] )->name('admin.profile');
Route::get('/admin/profile/edit', [MainAdminController::class, 'AdminProfileEdit'] )->name('profile.edit');
Route::post('/admin/profile/store', [MainAdminController::class, 'AdminProfileStore'] )->name('admin.profile.store');
Route::get('/admin/password/view', [MainAdminController::class, 'AdminPasswordView'] )->name('admin.password.edit');
Route::post('/admin/password/update', [MainAdminController::class, 'AdminPasswordUpdate'] )->name('admin.password.update');

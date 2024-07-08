<?php

use App\Http\Controllers\Admin\Settings\PermissionController;
use App\Http\Controllers\Admin\Settings\RoleController;
use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/users/trash', [UserController::class, 'trash'])->name('users.trash');
Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
Route::resource('users',UserController::class);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'role:admin', 'check.route.permissions'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('app', [SettingController::class, 'appIndex'])->name('app');
        Route::post('app', [SettingController::class, 'appUpdate'])->name('app.update');

        Route::get('website', [SettingController::class, 'websiteIndex'])->name('website');
        Route::post('website', [SettingController::class, 'websiteUpdate'])->name('website.update');


        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });
});

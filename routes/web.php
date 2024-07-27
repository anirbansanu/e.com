<?php

use App\Http\Controllers\Admin\Products\BrandController;
use App\Http\Controllers\Admin\Products\ProductAttributeController;
use App\Http\Controllers\Admin\Products\ProductCategoryController;
use App\Http\Controllers\Admin\Products\ProductController;
use App\Http\Controllers\Admin\Products\ProductUnitController;
use App\Http\Controllers\Admin\Products\ProductVariantController;
use App\Http\Controllers\Admin\Settings\PermissionController;
use App\Http\Controllers\Admin\Settings\RoleController;
use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return 'Cache cleared!';
});
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
    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::resource('brands', BrandController::class)->except('show');
        Route::post('/brands/{brand}/change-status', [BrandController::class,'changeStatus'])->name('brands.change-status');
        Route::post('/brands/json', [BrandController::class,'getJsonBrands'])->name('brands.json');

        Route::resource('categories', ProductCategoryController::class)->except('show');
        Route::post('/categories/{category}/change-status', [ProductCategoryController::class,'toggleStatus'])->name('categories.change-status');
        Route::post('/categories/json', [ProductCategoryController::class,'getJsonCategories'])->name('categories.json');

        Route::resource('attributes', ProductAttributeController::class)->except('show');
        Route::post('/attributes/{attribute}/change-status', [ProductAttributeController::class,'changeStatus'])->name('attributes.change-status');
        Route::post('attributes/json', [ProductAttributeController::class, 'getJson'])->name('attributes.json');

        Route::resource('units', ProductUnitController::class)->except('show');
        Route::post('units/json', [ProductUnitController::class, 'getJson'])->name('units.json');

        Route::resource('listing', ProductController::class)->except('store');

        Route::post('store/stepOne', [ProductController::class,'storeStepOne'])->name('store.stepOne');
        Route::post('store/stepTwo', [ProductController::class,'storeStepTwo'])->name('store.stepTwo');
        Route::post('store/stepThree', [ProductController::class,'storeStepThree'])->name('store.stepThree');

        Route::apiResource('variants', ProductVariantController::class);
        Route::get('variants/byproduct/{slug}', [ProductVariantController::class, 'getByProductSlug'])->name('variants.byproduct');

    });
});

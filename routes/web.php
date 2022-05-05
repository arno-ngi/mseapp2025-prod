<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/lang/{lang}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('switch.lang');
Route::get('/colorswitch', [\App\Http\Controllers\ColorController::class, 'switch'])->name('switch.color');

Route::get('/mfa', [\App\Http\Controllers\Auth\MultiFactorController::class, 'index'])->name('mfa.index');
Route::get('/mfa/resent', [\App\Http\Controllers\Auth\MultiFactorController::class, 'resent'])->name('mfa.resent');
Route::post('/mfa', [\App\Http\Controllers\Auth\MultiFactorController::class, 'store'])->name('mfa.store');

Route::middleware(['auth', 'mfa'])->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('index');
    Route::get('/test1', [\App\Http\Controllers\TestController::class, 'test1'])->name('test1');

    Route::group(['middleware' => ['is_superadmin']], function () {
        Route::get('/tenants', [\App\Http\Controllers\TenantController::class, 'index'])->name('tenants.index');
        Route::post('/tenants', [\App\Http\Controllers\TenantController::class, 'store'])->name('tenants.store');
        Route::get('/tenants/create', [\App\Http\Controllers\TenantController::class, 'create'])->name('tenants.create');
        Route::get('/tenants/{tenant}', [\App\Http\Controllers\TenantController::class, 'edit'])->name('tenants.edit');
        Route::get('/tenants/{tenant}/switch', [\App\Http\Controllers\TenantController::class, 'switch'])->name('tenants.switch');
        Route::patch('/tenants/{tenant}', [\App\Http\Controllers\TenantController::class, 'update'])->name('tenants.update');

        Route::get('/appsettings', [\App\Http\Controllers\AppSettingController::class, 'index'])->name('appsettings.index');
        Route::get('/appsettings/{appSetting}', [\App\Http\Controllers\AppSettingController::class, 'edit'])->name('appsettings.edit');
        Route::patch('/appsettings/{appSetting}', [\App\Http\Controllers\AppSettingController::class, 'update'])->name('appsettings.update');
    });

    Route::group(['middleware' => ['permission:module.users']], function () {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::post('/users/{user}/files', [\App\Http\Controllers\UserController::class, 'store_files'])->name('users.store.files');
        Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    });

    Route::group(['middleware' => ['permission:module.settings']], function () {
        Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [\App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
        Route::get('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
        Route::patch('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
    });

    Route::group(['middleware' => ['permission:module.rfa']], function () {
        Route::get('/rfa', [\App\Http\Controllers\InvoiceRequestController::class, 'index'])->name('rfa.index');
        Route::post('/rfa', [\App\Http\Controllers\InvoiceRequestController::class, 'store'])->name('rfa.store');
        Route::get('/rfa/create', [\App\Http\Controllers\InvoiceRequestController::class, 'create'])->name('rfa.create');
        Route::post('/rfa/{invoiceRequest}/files', [\App\Http\Controllers\InvoiceRequestController::class, 'store_files'])->name('rfa.store.files');
        Route::get('/rfa/{invoiceRequest}', [\App\Http\Controllers\InvoiceRequestController::class, 'edit'])->name('rfa.edit');
        Route::patch('/rfa/{invoiceRequest}', [\App\Http\Controllers\InvoiceRequestController::class, 'update'])->name('rfa.update');
    });

    Route::group(['middleware' => ['permission:module.rfa']], function () {
        Route::get('/expenserequest', [\App\Http\Controllers\ExpenseRequestController::class, 'index'])->name('expenserequest.index');
        Route::post('/expenserequest', [\App\Http\Controllers\ExpenseRequestController::class, 'store'])->name('expenserequest.store');
        Route::get('/expenserequest/create', [\App\Http\Controllers\ExpenseRequestController::class, 'create'])->name('expenserequest.create');
        Route::post('/expenserequest/{expenseRequest}/files', [\App\Http\Controllers\ExpenseRequestController::class, 'store_files'])->name('expenserequest.store.files');
        Route::get('/expenserequest/{expenseRequest}', [\App\Http\Controllers\ExpenseRequestController::class, 'edit'])->name('expenserequest.edit');
        Route::patch('/expenserequest/{expenseRequest}', [\App\Http\Controllers\ExpenseRequestController::class, 'update'])->name('expenserequest.update');
    });

    Route::post('/requestitem', [\App\Http\Controllers\RequestItemController::class, 'store'])->name('requestitem.store');
    Route::patch('/requestitem/{requestItem}', [\App\Http\Controllers\RequestItemController::class, 'update'])->name('requestitem.update');

    Route::post('/dailyallowance', [\App\Http\Controllers\DailyAllowanceController::class, 'store'])->name('dailyallowance.store');
    Route::patch('/dailyallowance/{dailyAllowance}', [\App\Http\Controllers\DailyAllowanceController::class, 'update'])->name('dailyallowance.update');

});

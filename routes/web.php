<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/lang/{lang}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('switch.lang');
Route::get('/colorswitch', [\App\Http\Controllers\ColorController::class, 'switch'])->name('switch.color');

Route::get('/mfa', [\App\Http\Controllers\Auth\MultiFactorController::class, 'index'])->name('mfa.index');
Route::get('/mfa/resent', [\App\Http\Controllers\Auth\MultiFactorController::class, 'resent'])->name('mfa.resent');
Route::post('/mfa', [\App\Http\Controllers\Auth\MultiFactorController::class, 'store'])->name('mfa.store');

Route::get('/eid', [\App\Http\Controllers\EidController::class, 'index'])->name('eid.index');
Route::get('/eid/checkout/{VisitorCheckIn}', [\App\Http\Controllers\EidController::class, 'checkout'])->name('eid.checkout');
Route::get('/eid/show', [\App\Http\Controllers\EidController::class, 'show'])->name('eid.show');
Route::post('/eid/show', [\App\Http\Controllers\EidController::class, 'show']);
Route::post('/eid', [\App\Http\Controllers\EidController::class, 'store'])->name('eid.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('index');
    Route::get('/myprofile', [\App\Http\Controllers\DashboardController::class, 'myprofile'])->name('myprofile');
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
        Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    });

    Route::group(['middleware' => ['permission:module.visitors']], function () {
        Route::get('/visitors', [\App\Http\Controllers\VisitorController::class, 'index'])->name('visitors.index');
        Route::get('/visitors/{VisitorCheckIn}/docheckout', [\App\Http\Controllers\VisitorController::class, 'docheckout'])->name('visitors.docheckout');
    });

    Route::post('/users/{user}/files', [\App\Http\Controllers\UserController::class, 'store_files'])->name('users.store.files');
    Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::patch('/myprofile/{user}', [\App\Http\Controllers\UserController::class, 'update2'])->name('users.update2');
    Route::patch('/users/profile/{user}', [\App\Http\Controllers\UserController::class, 'update_profile'])->name('users.profile.update');

    Route::group(['middleware' => ['permission:module.settings']], function () {
        Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [\App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
        Route::get('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
        Route::patch('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
    });

    Route::group(['middleware' => ['permission:module.barcodes']], function () {
        Route::get('/barcodes', [\App\Http\Controllers\BarcodeController::class, 'index'])->name('barcodes.index');
        Route::post('/barcodes', [\App\Http\Controllers\BarcodeController::class, 'store'])->name('barcodes.store');
        Route::get('/barcodes/create', [\App\Http\Controllers\BarcodeController::class, 'create'])->name('barcodes.create');
        Route::get('/barcodes/{barcode}', [\App\Http\Controllers\BarcodeController::class, 'edit'])->name('barcodes.edit');
        Route::get('/barcodes/{barcode}/pdf', [\App\Http\Controllers\BarcodeController::class, 'pdf'])->name('barcodes.pdf');
        Route::patch('/barcodes/{barcode}', [\App\Http\Controllers\BarcodeController::class, 'update'])->name('barcodes.update');
    });

    Route::group(['middleware' => ['permission:module.rfa']], function () {
        Route::get('/rfa', [\App\Http\Controllers\InvoiceRequestController::class, 'index'])->name('rfa.index');
        Route::get('/rfa/{invoiceRequest}/makeclosed', [\App\Http\Controllers\InvoiceRequestController::class, 'makeclosed'])->name('rfa.makeclosed');
        Route::get('/rfa/{invoiceRequest}/changestatus/{status}', [\App\Http\Controllers\InvoiceRequestController::class, 'changestatus'])->name('rfa.changestatus');
        Route::post('/rfa', [\App\Http\Controllers\InvoiceRequestController::class, 'store'])->name('rfa.store');
        Route::get('/rfa/create', [\App\Http\Controllers\InvoiceRequestController::class, 'create'])->name('rfa.create');
        Route::post('/rfa/{invoiceRequest}/files', [\App\Http\Controllers\InvoiceRequestController::class, 'store_files'])->name('rfa.store.files');
        Route::get('/rfa/{invoiceRequest}', [\App\Http\Controllers\InvoiceRequestController::class, 'edit'])->name('rfa.edit');
        Route::patch('/rfa/{invoiceRequest}', [\App\Http\Controllers\InvoiceRequestController::class, 'update'])->name('rfa.update');
    });

    Route::group(['middleware' => ['permission:module.rfa']], function () {
        Route::get('/expenserequest', [\App\Http\Controllers\ExpenseRequestController::class, 'index'])->name('expenserequest.index');
        Route::get('/expenserequest/{expenseRequest}/changestatus/{status}', [\App\Http\Controllers\ExpenseRequestController::class, 'changestatus'])->name('expenserequests.changestatus');
        Route::get('/expenserequest/{expenseRequest}/makeclosed', [\App\Http\Controllers\ExpenseRequestController::class, 'makeclosed'])->name('expenserequests.makeclosed');
        Route::post('/expenserequest', [\App\Http\Controllers\ExpenseRequestController::class, 'store'])->name('expenserequest.store');
        Route::get('/expenserequest/create', [\App\Http\Controllers\ExpenseRequestController::class, 'create'])->name('expenserequest.create');
        Route::post('/expenserequest/{expenseRequest}/files', [\App\Http\Controllers\ExpenseRequestController::class, 'store_files'])->name('expenserequest.store.files');
        Route::get('/expenserequest/{expenseRequest}', [\App\Http\Controllers\ExpenseRequestController::class, 'edit'])->name('expenserequest.edit');
        Route::patch('/expenserequest/{expenseRequest}', [\App\Http\Controllers\ExpenseRequestController::class, 'update'])->name('expenserequest.update');
    });

    Route::group(['middleware' => ['permission:module.tasks']], function () {
        Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
        Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/create', [\App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks/{task}/files', [\App\Http\Controllers\TaskController::class, 'store_files'])->name('tasks.store.files');
        Route::get('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'edit'])->name('tasks.edit');
        Route::patch('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
    });

    Route::post('/requestitem', [\App\Http\Controllers\RequestItemController::class, 'store'])->name('requestitem.store');
    Route::patch('/requestitem/{requestItem}', [\App\Http\Controllers\RequestItemController::class, 'update'])->name('requestitem.update');

    Route::post('/dailyallowance', [\App\Http\Controllers\DailyAllowanceController::class, 'store'])->name('dailyallowance.store');
    Route::patch('/dailyallowance/{dailyAllowance}', [\App\Http\Controllers\DailyAllowanceController::class, 'update'])->name('dailyallowance.update');

});

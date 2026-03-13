<?php

use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\GeofenceController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Admin\LicenseStockController;
use App\Http\Controllers\Admin\LicenseTransferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\StockReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VehicleController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
->prefix('admin')
->name('admin.')
->group(function () {

    Route::resource('roles', RoleController::class);

    Route::resource('permissions', PermissionController::class);

    Route::resource('users', UserController::class);
    // setting
    Route::resource('settings',SettingController::class);


    Route::prefix('vehicles')->group(function(){

        Route::get('/map',[VehicleController::class,'map'])
            ->name('vehicles.map');


        Route::get('/history',[VehicleController::class,'history'])
            ->name('vehicles.history');

    });

    /* GEOFENCE */

    Route::resource('geofences',GeofenceController::class);


    /* ALERTS */

    Route::get('/alerts',[AlertController::class,'index'])
    ->name('alerts.index');

    // licenece route

    Route::resource('licenses', LicenseController::class)
        ->names('licenses');
    Route::get('license-stock',[LicenseStockController::class,'index'])
    ->name('license-stock.index');

    Route::get('license-transfer/create',[LicenseTransferController::class,'create'])
    ->name('license-transfer.create');

    Route::post('license-transfer/store',[LicenseTransferController::class,'store'])
    ->name('license-transfer.store');
    
    // stocks

    Route::get('stocks',[StockController::class,'index'])
    ->name('stocks.index');

    Route::get('stock-transfer/create',[LicenseTransferController::class,'create'])
    ->name('stock-transfer.create');

    Route::post('stock-transfer/store',[LicenseTransferController::class,'store'])
    ->name('stock-transfer.store');

    Route::get('stock-report',[StockReportController::class,'index'])
    ->name('stock-report.index');

});



require __DIR__.'/auth.php';

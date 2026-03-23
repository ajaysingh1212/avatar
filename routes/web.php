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
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\WalletTransactionController;

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
    Route::get('stocks',[LicenseStockController::class,'index'])
    ->name('stocks.index');
        Route::get('stocks/{id}', [LicenseStockController::class,'show'])
        ->name('stocks.show');
    Route::get('/get-users-by-role/{role}',[LicenseTransferController::class,'getUsersByRole'])->name('getUsersByRole');
    Route::resource('license-transfer', LicenseTransferController::class);
    Route::get('stock-report',[StockReportController::class,'index'])
    ->name('stock-report.index');

    Route::get('stock-report-users/{role}',[StockReportController::class,'getUsersByRole']);

    Route::post('stock-report',[StockReportController::class,'report'])
    ->name('stock-report.search');

    // wallet trensction

  /* =================================
       WALLET MANAGEMENT
    ================================= */

    Route::get('/wallets', [WalletController::class,'index'])->name('wallets.index');

    Route::get('/wallets/create', [WalletController::class,'create'])->name('wallets.create');

    Route::post('/wallets', [WalletController::class,'store'])->name('wallets.store');

    Route::get('/wallets/{id}', [WalletController::class,'show'])->name('wallets.show');

    Route::get('/wallets/{id}/edit', [WalletController::class,'edit'])->name('wallets.edit');

    Route::put('/wallets/{id}', [WalletController::class,'update'])->name('wallets.update');
    Route::get('/wallets/{wallet_id}/history',[WalletController::class,'history'])->name('wallet.history');
    Route::get('/wallet/{id}/analytics',[WalletController::class,'analytics'])->name('wallet.analytics');

    Route::get('/wallet/{id}/live-transactions',[WalletController::class,'liveTransactions'])->name('wallet.liveTransactions');

    /* =================================
       WALLET APPROVAL
    ================================= */

    Route::post('/wallets/{id}/approve', [WalletController::class,'approveWallet'])->name('wallets.approve');

    Route::post('/wallets/{id}/reject', [WalletController::class,'rejectWallet'])->name('wallets.reject');



    /* =================================
       WALLET FREEZE
    ================================= */

    Route::post('/wallets/{id}/freeze', [WalletController::class,'freeze'])->name('wallets.freeze');

    Route::post('/wallets/{id}/unfreeze', [WalletController::class,'unfreeze'])->name('wallets.unfreeze');
    Route::post('/wallets/add-fund',[WalletTransactionController::class,'addAmount']);


    /* =================================
       WALLET HISTORY
    ================================= */

    Route::get('/wallets/{wallet_id}/history', [WalletController::class,'history'])->name('wallets.history');



    /* =================================
       WALLET TRANSACTIONS
    ================================= */

    Route::get('/transactions', [WalletTransactionController::class,'index'])->name('transactions.index');

    Route::get('/transactions/pending', [WalletTransactionController::class,'pending'])->name('transactions.pending');

    Route::get('/transactions/{id}', [WalletTransactionController::class,'show'])->name('transactions.show');

    Route::post('/transactions/approve/{id}', [WalletTransactionController::class,'approveTransaction']);
    Route::post('/transactions/reject/{id}', [WalletTransactionController::class,'rejectTransaction']);
    Route::post('/transactions/hold/{id}', [WalletTransactionController::class,'holdTransaction']);
    Route::get('/transactions/show/{id}', [WalletTransactionController::class,'show'])->name('transactions.show');
    /* =================================
       ADD AMOUNT REQUEST
    ================================= */

    Route::post('/transactions/add-amount', [WalletTransactionController::class,'addAmount'])->name('transactions.addAmount');



    /* =================================
       TRANSACTION APPROVAL
    ================================= */

    Route::post('/transactions/{id}/approve', [WalletTransactionController::class,'approveTransaction'])->name('transactions.approve');

    Route::post('/transactions/{id}/reject', [WalletTransactionController::class,'rejectTransaction'])->name('transactions.reject');



});



require __DIR__.'/auth.php';

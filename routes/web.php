<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('test',[ \App\Http\Controllers\TestController::class, 'index']);

Route::group(['middleware' => ['auth', 'tenancy']], function() {

        Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

        Route::get('bag-device-summary', [\App\Http\Controllers\BagDevice\DashboardController::class, 'index'])->name('bag-device-summary');
        Route::get('env-device-summary', [\App\Http\Controllers\EnvDevice\DashboardController::class, 'index'])->name('env-device-summary');

        Route::get('report', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
        Route::post('report', [\App\Http\Controllers\ReportController::class, 'create'])->name('report.create');

        Route::resource('bag-devices', \App\Http\Controllers\BagDevice\BagDeviceController::class);
        Route::resource('bag-device-types', \App\Http\Controllers\BagDevice\BagDeviceTypeController::class);
        Route::resource('data-cards', \App\Http\Controllers\DataCardController::class);
        Route::resource('env-devices', \App\Http\Controllers\EnvDevice\EnvDeviceController::class);
        Route::resource('profile', \App\Http\Controllers\ProfileController::class);
        Route::resource('regions', \App\Http\Controllers\RegionController::class);
        Route::resource('roles', \App\Http\Controllers\RoleController::class);
        Route::resource('users', \App\Http\Controllers\UserController::class);

        Route::post('env_devices_feed', [\App\Http\Controllers\EnvDevice\DashboardController::class, 'refreshFeed'])->name('env-device-refreshFeed');
        Route::post('set_env_device_region', [\App\Http\Controllers\EnvDevice\DashboardController::class, 'set_region'])->name('env-device-setRegion');

        Route::post('bag_devices_feed', [\App\Http\Controllers\BagDevice\DashboardController::class, 'refreshFeed'])->name('bag-device-refreshFeed');
        Route::post('set_bag_device_region', [\App\Http\Controllers\BagDevice\DashboardController::class, 'set_region'])->name('bag-device-setRegion');

        Route::post('change_tenant', [\App\Http\Controllers\UserController::class, 'change_tenant']);

        Route::post('send_test_sms', [\App\Http\Controllers\UserController::class, 'send_test_sms']);
        Route::post('check_sms_confirmation', [\App\Http\Controllers\UserController::class, 'check_sms_confirmation']);
});

Route::post('/logout', function() {
    auth()->logout();
    return redirect('login');
})->name('logout');

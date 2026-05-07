<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TenantSiteController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// cache clear
Route::get('/clear', function() {
  Auth::logout();
  session()->flush();
  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  return "Cleared!";
});

 Route::fallback(function () {
    return redirect('/');
});

require __DIR__.'/admin.php';

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', function () {
    if (app()->bound('currentTenant')) {
        return app(TenantSiteController::class)->index();
    }
    return app(HomeController::class)->dashboard();
})->name('home');

Route::middleware('tenant')->group(function () {
    Route::get('/', [TenantSiteController::class, 'index']);
    Route::get('/about', [TenantSiteController::class, 'about']);
    Route::get('/contact', [TenantSiteController::class, 'contact']);
    Route::get('/services', [TenantSiteController::class, 'services']);
    Route::get('/services/{slug}', [TenantSiteController::class, 'serviceDetail']);
    Route::post('/contact', [TenantSiteController::class, 'contactSubmit']);
});

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::group(['prefix' =>'user/', 'middleware' => ['auth', 'is_user', 'verified']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');

});
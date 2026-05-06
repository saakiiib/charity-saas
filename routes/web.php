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

Auth::routes();
Route::middleware('tenant')->group(function () {
    Route::get('/login', function () { abort(404); });
    Route::get('/register', function () { abort(404); });
    Route::get('/password/reset', function () { abort(404); });
});

Route::get('/', function () {
    if (app()->bound('currentTenant')) {
        return app(TenantSiteController::class)->index();
    }
    return app(HomeController::class)->dashboard();
})->name('home');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::group(['prefix' =>'user/', 'middleware' => ['auth', 'is_user', 'verified']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');

});
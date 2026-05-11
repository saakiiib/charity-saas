<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    Auth::logout();
    session()->flush();
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});

require __DIR__ . '/admin.php';

Auth::routes([
    'register' => false,
    'reset'    => false,
    'verify'   => false,
]);

Route::get('/', function () {
    if (app()->bound('currentTenant')) {
        return app(FrontendController::class)->index();
    }
    return app(HomeController::class)->dashboard();
})->name('home');

Route::get('/about', [FrontendController::class, 'about'])->name('about');

Route::get('/services', [FrontendController::class, 'services'])->name('services');

Route::get('/services/{slug}', [FrontendController::class, 'serviceDetail'])->name('service.detail');

Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

Route::post('/contact', [FrontendController::class, 'contactSubmit'])->name('contact.submit');

Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');

Route::get('/updates', [FrontendController::class, 'updates'])->name('updates');

Route::get('/updates/{slug}', [FrontendController::class, 'updatesDetail'])->name('updates.detail');

Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy.policy');

Route::get('/terms-and-conditions', [FrontendController::class, 'termsAndConditions'])->name('terms.and.conditions');

Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::group(['prefix' => 'user/', 'middleware' => ['auth', 'is_user', 'verified']], function () {
    Route::get('/dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');
});

Route::fallback(function () {
    return redirect('/');
});
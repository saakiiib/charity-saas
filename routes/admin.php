<?php

use App\Http\Controllers\Admin\CompanyDetailsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/', 'middleware' => ['auth', 'is_admin']], function () {
    Route::get('/dashboard', [HomeController::class, 'adminHome'])->name('admin.dashboard');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user-update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::post('/user-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');

    //Tenant
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenant.index');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenant.store');
    Route::get('/tenants/{id}/edit', [TenantController::class, 'edit'])->name('tenant.edit');
    Route::post('/tenants-update', [TenantController::class, 'update'])->name('tenant.update');
    Route::delete('/tenants/{id}', [TenantController::class, 'destroy'])->name('tenant.delete');
    Route::post('/tenants-status', [TenantController::class, 'toggleStatus'])->name('tenant.status');
    Route::get('/tenants/{id}/manage', [TenantController::class, 'manage'])->name('tenant.manage');
    Route::get('/tenants/manage/exit', [TenantController::class, 'exit'])->name('tenant.manage.exit');

    // Company Details
    Route::get('/company-details', [CompanyDetailsController::class, 'index'])->name('companyDetails.index');
    Route::post('/company-details', [CompanyDetailsController::class, 'update'])->name('companyDetails.update');

    // Master
    Route::get('/master', [MasterController::class, 'index'])->name('master.index');
    Route::post('/master', [MasterController::class, 'store'])->name('master.store');
    Route::get('/master/{id}/edit', [MasterController::class, 'edit'])->name('master.edit');
    Route::post('/master-update', [MasterController::class, 'update'])->name('master.update');
    Route::delete('/master/{id}', [MasterController::class, 'destroy'])->name('master.delete');

    // Section
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::post('/sections/update-order', [SectionController::class, 'updateOrder'])->name('sections.updateOrder');
    Route::post('/sections/toggle-status', [SectionController::class, 'toggleStatus'])->name('sections.toggleStatus');

    // Slider
    Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
    Route::post('/slider', [SliderController::class, 'store']);
    Route::get('/slider/{id}/edit', [SliderController::class, 'edit']);
    Route::post('/slider-update', [SliderController::class, 'update']);
    Route::delete('/slider/{id}', [SliderController::class, 'destroy'])->name('slider.delete');
    Route::post('/slider-status', [SliderController::class, 'toggleStatus']);
    Route::post('/sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.updateOrder');

    // Contact
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}/delete', [ContactController::class, 'destroy'])->name('contacts.delete');
    Route::post('/contacts/toggle-status', [ContactController::class, 'toggleStatus'])->name('contacts.toggleStatus');

    // FAQ
    Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');
    Route::post('/faq', [FAQController::class, 'store'])->name('faq.store');
    Route::get('/faq/{id}/edit', [FAQController::class, 'edit'])->name('faq.edit');
    Route::post('/faq-update', [FAQController::class, 'update'])->name('faq.update');
    Route::delete('/faq/{id}', [FAQController::class, 'destroy'])->name('faq.delete');

});
<?php

use App\Http\Controllers\Admin\CompanyDetailsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ThemeController;
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

    // Theme
    Route::get('/theme', [ThemeController::class, 'index'])->name('theme.index');
    Route::post('/theme', [ThemeController::class, 'update'])->name('theme.update');

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

    // Posts
    Route::get('/posts', [PostController::class, 'index'])->name('post.index');
    Route::post('/posts', [PostController::class, 'store'])->name('post.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/posts-update', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('post.delete');
    Route::post('/posts-status', [PostController::class, 'toggleStatus'])->name('post.toggleStatus');

    // Testimonial
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonial.index');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonial.store');
    Route::get('/testimonials/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonial.edit');
    Route::post('/testimonials-update', [TestimonialController::class, 'update'])->name('testimonial.update');
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy'])->name('testimonial.delete');
    Route::post('/testimonials-status', [TestimonialController::class, 'toggleStatus'])->name('testimonial.toggleStatus');

    // Gallery
    Route::get('/galleries', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/galleries', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/galleries/{id}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::post('/galleries-update', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy'])->name('gallery.delete');
    Route::post('/galleries-status', [GalleryController::class, 'toggleStatus'])->name('gallery.toggleStatus');
    Route::post('/galleries-order', [GalleryController::class, 'updateOrder'])->name('gallery.updateOrder');

    //Service
    Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
    Route::post('/services', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
    Route::post('/services-update', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('service.delete');
    Route::post('/services-status', [ServiceController::class, 'toggleStatus'])->name('service.toggleStatus');
    Route::post('/services-order', [ServiceController::class, 'updateOrder'])->name('service.updateOrder');

    // Faq
    Route::get('/faqs', [FaqController::class, 'index'])->name('faq.index');
    Route::post('/faqs', [FaqController::class, 'store'])->name('faq.store');
    Route::get('/faqs/{id}/edit', [FaqController::class, 'edit'])->name('faq.edit');
    Route::post('/faqs-update', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('/faqs/{id}', [FaqController::class, 'destroy'])->name('faq.delete');
    Route::post('/faqs-status', [FaqController::class, 'toggleStatus'])->name('faq.toggleStatus');
    Route::post('/faqs-order', [FaqController::class, 'updateOrder'])->name('faq.updateOrder');

    // Contact
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}/delete', [ContactController::class, 'destroy'])->name('contacts.delete');
    Route::post('/contacts/toggle-status', [ContactController::class, 'toggleStatus'])->name('contacts.toggleStatus');

});
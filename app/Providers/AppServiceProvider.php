<?php

namespace App\Providers;

use App\Models\CompanyDetails;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $tenant  = app()->bound('currentTenant') ? app('currentTenant') : null;
            $company = $tenant
                ? CompanyDetails::where('tenant_id', $tenant->id)->first()
                : null;

            $view->with('currentTenant', $tenant);
            $view->with('company', $company);
        });
    }
}

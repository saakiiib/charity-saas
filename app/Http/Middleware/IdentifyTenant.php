<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next)
    {
        $host       = preg_replace('/^www\./', '', $request->getHost());
        $mainDomain = preg_replace('/^www\./', '', parse_url(config('app.url'), PHP_URL_HOST));

        if ($host === $mainDomain || filter_var($host, FILTER_VALIDATE_IP)) {
            return $next($request);
        }

        $tenant = Tenant::where('domain', $host)->where('status', 1)->first();

        if ($tenant) {
            if ($request->is('login')) {
                abort(404);
            }

            app()->instance('currentTenant', $tenant);
            view()->share('currentTenant', $tenant);
        }

        return $next($request);
    }
}
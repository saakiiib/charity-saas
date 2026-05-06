<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        // Skip main domain
        if ($host === 'charityhubhub.co.uk' || $host === 'www.charityhubhub.co.uk') {
            return $next($request);
        }

        $tenant = Tenant::where('domain', $host)->where('status', 1)->first();

        if (!$tenant) {
            return $next($request);
        }

        app()->instance('currentTenant', $tenant);
        view()->share('currentTenant', $tenant);

        return $next($request);
    }
}

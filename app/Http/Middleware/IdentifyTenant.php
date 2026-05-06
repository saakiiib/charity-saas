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

        // Remove www. prefix
        $host = preg_replace('/^www\./', '', $host);

        if (
            $host === 'charityhubhub.co.uk' ||
            filter_var($host, FILTER_VALIDATE_IP) ||
            $host === 'localhost'
        ) {
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

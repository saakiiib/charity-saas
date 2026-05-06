<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantSiteController extends Controller
{
    public function index()
    {
        \Log::info('TenantSiteController hit', [
            'bound' => app()->bound('currentTenant'),
            'host'  => request()->getHost(),
        ]);

        $tenant = app()->bound('currentTenant') ? app('currentTenant') : null;

        if (!$tenant) {
            abort(404);
        }

        return view('tenant.home', compact('tenant'));
    }
}
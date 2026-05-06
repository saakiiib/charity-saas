<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantSiteController extends Controller
{
    public function index()
    {
        if (!app()->bound('currentTenant')) {
            return redirect()->route('login');
        }

        $tenant = app('currentTenant');
        return view('tenant.home', compact('tenant'));
    }
}
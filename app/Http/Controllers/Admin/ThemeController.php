<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;

class ThemeController extends Controller
{
    public function index()
    {
        $tenant = Tenant::findOrFail($this->tenantId());
        return view('admin.theme.index', compact('tenant'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15',
        ]);

        Tenant::findOrFail($this->tenantId())->update(['theme' => $request->theme]);

        return redirect()->back()->with('success', 'Theme updated successfully.');
    }
}
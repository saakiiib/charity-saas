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
            'theme' => 'required|in:1,2,3',
        ]);

        Tenant::findOrFail($this->tenantId())->update(['theme' => $request->theme]);

        return redirect()->back()->with('success', 'Theme updated successfully.');
    }
}
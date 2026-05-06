<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use DataTables;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tenants = Tenant::select(['id', 'name', 'domain', 'email', 'status']);

            return DataTables::of($tenants)
                ->addIndexColumn()
                ->addColumn('domain_link', function ($row) {
                    return '<a href="http://' . $row->domain . '" target="_blank">'
                        . $row->domain .
                    '</a>';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch" dir="ltr">
                        <input type="checkbox" class="form-check-input toggle-status"
                               id="tenantSwitch' . $row->id . '" 
                               data-id="' . $row->id . '" ' . $checked . '>
                        <label class="form-check-label" for="tenantSwitch' . $row->id . '"></label>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm dropdown"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item" id="EditBtn" rid="' . $row->id . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn"
                                        data-delete-url="' . route('tenant.delete', $row->id) . '"
                                        data-method="DELETE"
                                        data-table="#tenantTable">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['domain_link', 'status', 'action'])
                ->make(true);
        }

        return view('admin.tenant.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'domain' => 'required',
            'email'     => 'nullable|email',
        ], [
            'domain.unique'     => 'This domain is already taken.',
            'domain.alpha_dash' => 'domain can only contain letters, numbers, and hyphens.',
            'domain.lowercase'  => 'domain must be lowercase.',
        ]);

        $data = new Tenant;
        $data->name          = $request->name;
        $data->domain     = strtolower($request->domain);
        $data->tagline       = $request->tagline;
        $data->email         = $request->email;
        $data->phone         = $request->phone;
        $data->primary_color = $request->primary_color ?? '#007bff';

        if ($request->hasFile('logo')) {
            $file       = $request->file('logo');
            $randomName = mt_rand(10000000, 99999999) . '.' . $file->getClientOriginalExtension();
            $path       = public_path('uploads/tenants/');

            if (!file_exists($path)) mkdir($path, 0755, true);

            $file->move($path, $randomName);
            $data->logo = '/uploads/tenants/' . $randomName;
        }

        if ($data->save()) {
            return response()->json(['message' => 'Charity created successfully!'], 200);
        }

        return response()->json(['message' => 'Server error.'], 500);
    }

    public function edit($id)
    {
        $tenant = Tenant::findOrFail($id);
        return response()->json($tenant);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'domain' => 'required|unique:tenants,domain,' . $request->codeid,
            'email'     => 'nullable|email',
        ]);

        $data = Tenant::findOrFail($request->codeid);
        $data->name          = $request->name;
        $data->domain     = strtolower($request->domain);
        $data->tagline       = $request->tagline;
        $data->email         = $request->email;
        $data->phone         = $request->phone;
        $data->primary_color = $request->primary_color ?? $data->primary_color;

        if ($request->hasFile('logo')) {
            if ($data->logo && file_exists(public_path($data->logo))) {
                @unlink(public_path($data->logo));
            }

            $file       = $request->file('logo');
            $randomName = mt_rand(10000000, 99999999) . '.' . $file->getClientOriginalExtension();
            $path       = public_path('uploads/tenants/');

            if (!file_exists($path)) mkdir($path, 0755, true);

            $file->move($path, $randomName);
            $data->logo = '/uploads/tenants/' . $randomName;
        }

        if ($data->save()) {
            return response()->json(['message' => 'Charity updated successfully!'], 200);
        }

        return response()->json(['message' => 'Failed to update.'], 500);
    }

    public function delete($id)
    {
        $data = Tenant::findOrFail($id);

        if ($data->logo && file_exists(public_path($data->logo))) {
            @unlink(public_path($data->logo));
        }

        if ($data->delete()) {
            return response()->json(['message' => 'Charity deleted successfully.'], 200);
        }

        return response()->json(['message' => 'Failed to delete.'], 500);
    }

    public function toggleStatus(Request $request)
    {
        $tenant = Tenant::findOrFail($request->tenant_id);
        $tenant->status = $request->status;

        if ($tenant->save()) {
            return response()->json(['message' => 'Status updated successfully.'], 200);
        }

        return response()->json(['message' => 'Failed to update status.'], 500);
    }
}

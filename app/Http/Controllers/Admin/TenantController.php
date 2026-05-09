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
            $tenants = Tenant::select(['id', 'name', 'domain', 'status']);

            return DataTables::of($tenants)
                ->addIndexColumn()
                ->addColumn('domain_link', function ($row) {
                    return '<a href="http://' . $row->domain . '" target="_blank">'
                        . $row->domain . '</a>';
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
                        <div class="d-flex gap-2">
                            <a href="' . route('tenant.manage', $row->id) . '" class="btn btn-soft-primary btn-sm">
                                <i class="ri-settings-3-line me-1"></i> Manage
                            </a>
                            <button class="btn btn-soft-secondary btn-sm" id="EditBtn" rid="' . $row->id . '">
                                <i class="ri-pencil-fill"></i>
                            </button>
                            <button class="btn btn-soft-danger btn-sm deleteBtn"
                                data-delete-url="' . route('tenant.delete', $row->id) . '"
                                data-method="DELETE"
                                data-table="#tenantTable">
                                <i class="ri-delete-bin-fill"></i>
                            </button>
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
            'name'   => 'required',
            'domain' => 'required|unique:tenants,domain',
        ]);

        $data = new Tenant;
        $data->name   = $request->name;
        $data->domain = strtolower($request->domain);

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
            'name'   => 'required',
            'domain' => 'required|unique:tenants,domain,' . $request->codeid,
        ]);

        $data = Tenant::findOrFail($request->codeid);
        $data->name   = $request->name;
        $data->domain = strtolower($request->domain);

        if ($data->save()) {
            return response()->json(['message' => 'Charity updated successfully!'], 200);
        }

        return response()->json(['message' => 'Failed to update.'], 500);
    }

    public function destroy($id)
    {
        $data = Tenant::findOrFail($id);

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

    public function manage($id)
    {
        $tenant = Tenant::findOrFail($id);
        session([
            'managing_tenant' => $id,
            'managing_tenant_name' => $tenant->name,
        ]);
        return redirect()->route('companyDetails.index');
    }

    public function exit()
    {
        session()->forget(['managing_tenant', 'managing_tenant_name']);
        return redirect()->route('tenant.index');
    }
}
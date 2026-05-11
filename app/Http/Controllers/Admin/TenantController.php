<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyDetails;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Master;
use App\Models\Post;
use App\Models\Section;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Tenant;
use App\Models\Testimonial;
use DataTables;
use Illuminate\Http\Request;

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
                            <button class="btn btn-soft-success btn-sm cloneBtn" data-id="' . $row->id . '">
                                <i class="ri-file-copy-line"></i>
                            </button>
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

        $company = CompanyDetails::where('tenant_id', $id)->first();
        if ($company) {
            foreach (['fav_icon', 'company_logo', 'footer_logo'] as $field) {
                if ($company->$field && file_exists(public_path('uploads/company/' . $company->$field))) {
                    @unlink(public_path('uploads/company/' . $company->$field));
                }
            }
            if ($company->meta_image && file_exists(public_path('uploads/company/meta/' . $company->meta_image))) {
                @unlink(public_path('uploads/company/meta/' . $company->meta_image));
            }
            $company->delete();
        }

        Master::where('tenant_id', $id)->each(function ($row) {
            foreach (['image', 'image2'] as $field) {
                if ($row->$field && file_exists(public_path('uploads/masters/' . $row->$field))) {
                    @unlink(public_path('uploads/masters/' . $row->$field));
                }
            }
            if ($row->meta_image && file_exists(public_path('uploads/meta_image/' . $row->meta_image))) {
                @unlink(public_path('uploads/meta_image/' . $row->meta_image));
            }
            $row->delete();
        });

        Slider::where('tenant_id', $id)->each(function ($row) {
            if ($row->image && file_exists(public_path('uploads/slider/' . $row->image))) {
                @unlink(public_path('uploads/slider/' . $row->image));
            }
            $row->delete();
        });

        Service::where('tenant_id', $id)->each(function ($row) {
            if ($row->image && file_exists(public_path('uploads/services/' . $row->image))) {
                @unlink(public_path('uploads/services/' . $row->image));
            }
            $row->delete();
        });

        Testimonial::where('tenant_id', $id)->each(function ($row) {
            if ($row->image && file_exists(public_path('uploads/testimonials/' . $row->image))) {
                @unlink(public_path('uploads/testimonials/' . $row->image));
            }
            $row->delete();
        });

        Gallery::where('tenant_id', $id)->each(function ($row) {
            if ($row->image && file_exists(public_path('uploads/galleries/' . $row->image))) {
                @unlink(public_path('uploads/galleries/' . $row->image));
            }
            $row->delete();
        });

        Post::where('tenant_id', $id)->each(function ($row) {
            if ($row->image && file_exists(public_path('uploads/posts/' . $row->image))) {
                @unlink(public_path('uploads/posts/' . $row->image));
            }
            $row->delete();
        });

        Faq::where('tenant_id', $id)->delete();
        Section::where('tenant_id', $id)->delete();

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

    public function clone($id)
    {
        $original = Tenant::findOrFail($id);

        $newTenant = $original->replicate();
        $newTenant->name   = $original->name . ' (Copy)';
        $newTenant->domain = 'copy-' . time() . '-' . $original->domain;
        $newTenant->save();

        $newId = $newTenant->id;
        $oldId = $original->id;

        $company = CompanyDetails::where('tenant_id', $oldId)->first();
        if ($company) {
            $newCompany = $company->replicate();
            $newCompany->tenant_id = $newId;
            $newCompany->save();
        }

        Master::where('tenant_id', $oldId)->each(function ($row) use ($newId) {
            $new = $row->replicate();
            $new->tenant_id = $newId;
            $new->save();
        });

        Slider::where('tenant_id', $oldId)->each(function ($row) use ($newId) {
            $new = $row->replicate();
            $new->tenant_id = $newId;
            $new->save();
        });

        Service::where('tenant_id', $oldId)->each(function ($row) use ($newId) {
            $new = $row->replicate();
            $new->tenant_id = $newId;
            $new->save();
        });

        Testimonial::where('tenant_id', $oldId)->each(function ($row) use ($newId) {
            $new = $row->replicate();
            $new->tenant_id = $newId;
            $new->save();
        });

        Gallery::where('tenant_id', $oldId)->each(function ($row) use ($newId) {
            $new = $row->replicate();
            $new->tenant_id = $newId;
            $new->save();
        });

        Post::where('tenant_id', $oldId)->each(function ($row) use ($newId) {
            $new = $row->replicate();
            $new->tenant_id = $newId;
            $new->save();
        });

        Faq::where('tenant_id', $oldId)->each(function ($row) use ($newId) {
            $new = $row->replicate();
            $new->tenant_id = $newId;
            $new->save();
        });

        Section::where('tenant_id', $oldId)->each(function ($row) use ($newId) {
            $new = $row->replicate();
            $new->tenant_id = $newId;
            $new->save();
        });

        return response()->json(['message' => 'Tenant cloned successfully!'], 200);
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
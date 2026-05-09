<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use DataTables;
use Intervention\Image\Facades\Image;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $services = Service::select(['id', 'title', 'image', 'serial', 'status'])
                ->where('tenant_id', $this->tenantId())
                ->orderBy('serial');

            return DataTables::of($services)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return $row->image
                        ? '<img src="' . asset('uploads/services/' . $row->image) . '" class="img-thumbnail" style="width:50px;height:50px;object-fit:cover;">'
                        : '';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch" dir="ltr">
                                <input type="checkbox" class="form-check-input toggle-status"
                                       id="serviceSwitch' . $row->id . '" data-id="' . $row->id . '" ' . $checked . '>
                                <label class="form-check-label" for="serviceSwitch' . $row->id . '"></label>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item EditBtn" rid="' . $row->id . '">
                                        <i class="ri-pencil-fill me-2"></i> Edit
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn"
                                        data-delete-url="' . route('service.delete', $row->id) . '"
                                        data-method="DELETE"
                                        data-table="#serviceTable">
                                        <i class="ri-delete-bin-fill me-2"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        $services = Service::where('tenant_id', $this->tenantId())->orderBy('serial')->get();
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = new Service();
        $data->tenant_id         = $this->tenantId();
        $data->title             = $request->title;
        $data->short_description = $request->short_description;
        $data->content           = $request->content;

        $lastSerial = Service::where('tenant_id', $this->tenantId())->max('serial');
        $data->serial = $lastSerial ? $lastSerial + 1 : 1;

        $name = mt_rand(10000000, 99999999) . '.webp';
        $path = public_path('uploads/services/');
        if (!file_exists($path)) mkdir($path, 0755, true);

        Image::make($request->file('image'))
            ->resize(1200, null, fn($c) => $c->aspectRatio())
            ->encode('webp', 80)
            ->save($path . $name);

        $data->image = $name;
        $data->save();

        return response()->json(['message' => 'Service created successfully!'], 200);
    }

    public function edit($id)
    {
        $service = Service::where('tenant_id', $this->tenantId())->findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $service = Service::where('tenant_id', $this->tenantId())->findOrFail($request->codeid);
        $service->title             = $request->title;
        $service->short_description = $request->short_description;
        $service->content           = $request->content;

        if ($request->hasFile('image')) {
            if ($service->image && file_exists(public_path('uploads/services/' . $service->image))) {
                @unlink(public_path('uploads/services/' . $service->image));
            }
            $name = mt_rand(10000000, 99999999) . '.webp';
            $path = public_path('uploads/services/');
            if (!file_exists($path)) mkdir($path, 0755, true);

            Image::make($request->file('image'))
                ->resize(1200, null, fn($c) => $c->aspectRatio())
                ->encode('webp', 80)
                ->save($path . $name);

            $service->image = $name;
        }

        $service->save();
        return response()->json(['message' => 'Service updated successfully!'], 200);
    }

    public function destroy($id)
    {
        $service = Service::where('tenant_id', $this->tenantId())->findOrFail($id);
        if ($service->image && file_exists(public_path('uploads/services/' . $service->image))) {
            @unlink(public_path('uploads/services/' . $service->image));
        }
        $service->delete();
        return response()->json(['message' => 'Service deleted successfully.'], 200);
    }

    public function toggleStatus(Request $request)
    {
        $service = Service::where('tenant_id', $this->tenantId())->findOrFail($request->service_id);
        $service->status = $request->status;
        $service->save();
        return response()->json(['message' => 'Status updated successfully.'], 200);
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Service::where('id', $id)
                ->where('tenant_id', $this->tenantId())
                ->update(['serial' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use DataTables;
use Intervention\Image\Facades\Image;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $testimonials = Testimonial::select(['id', 'name', 'designation', 'company', 'image', 'status'])
                ->where('tenant_id', $this->tenantId())
                ->latest();

            return DataTables::of($testimonials)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return $row->image
                        ? '<img src="' . asset('uploads/testimonials/' . $row->image) . '" class="img-thumbnail rounded-circle" style="width:50px;height:50px;object-fit:cover;">'
                        : '';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch" dir="ltr">
                                <input type="checkbox" class="form-check-input toggle-status"
                                       id="testimonialSwitch' . $row->id . '" data-id="' . $row->id . '" ' . $checked . '>
                                <label class="form-check-label" for="testimonialSwitch' . $row->id . '"></label>
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
                                        data-delete-url="' . route('testimonial.delete', $row->id) . '"
                                        data-method="DELETE"
                                        data-table="#testimonialTable">
                                        <i class="ri-delete-bin-fill me-2"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.testimonials.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = new Testimonial();
        $data->tenant_id   = $this->tenantId();
        $data->name        = $request->name;
        $data->designation = $request->designation;
        $data->company     = $request->company;
        $data->message     = $request->message;

        if ($request->hasFile('image')) {
            $name = mt_rand(10000000, 99999999) . '.webp';
            $path = public_path('uploads/testimonials/');
            if (!file_exists($path)) mkdir($path, 0755, true);

            Image::make($request->file('image'))
                ->resize(300, 300, fn($c) => $c->aspectRatio())
                ->encode('webp', 80)
                ->save($path . $name);

            $data->image = $name;
        }

        $data->save();
        return response()->json(['message' => 'Testimonial created successfully!'], 200);
    }

    public function edit($id)
    {
        $testimonial = Testimonial::where('tenant_id', $this->tenantId())->findOrFail($id);
        return response()->json($testimonial);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $testimonial = Testimonial::where('tenant_id', $this->tenantId())->findOrFail($request->codeid);
        $testimonial->name        = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->company     = $request->company;
        $testimonial->message     = $request->message;

        if ($request->hasFile('image')) {
            if ($testimonial->image && file_exists(public_path('uploads/testimonials/' . $testimonial->image))) {
                @unlink(public_path('uploads/testimonials/' . $testimonial->image));
            }
            $name = mt_rand(10000000, 99999999) . '.webp';
            $path = public_path('uploads/testimonials/');
            if (!file_exists($path)) mkdir($path, 0755, true);

            Image::make($request->file('image'))
                ->resize(300, 300, fn($c) => $c->aspectRatio())
                ->encode('webp', 80)
                ->save($path . $name);

            $testimonial->image = $name;
        }

        $testimonial->save();
        return response()->json(['message' => 'Testimonial updated successfully!'], 200);
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::where('tenant_id', $this->tenantId())->findOrFail($id);
        if ($testimonial->image && file_exists(public_path('uploads/testimonials/' . $testimonial->image))) {
            @unlink(public_path('uploads/testimonials/' . $testimonial->image));
        }
        $testimonial->delete();
        return response()->json(['message' => 'Testimonial deleted successfully.'], 200);
    }

    public function toggleStatus(Request $request)
    {
        $testimonial = Testimonial::where('tenant_id', $this->tenantId())->findOrFail($request->testimonial_id);
        $testimonial->status = $request->status;
        $testimonial->save();
        return response()->json(['message' => 'Status updated successfully.'], 200);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use DataTables;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $galleries = Gallery::select(['id', 'title', 'image', 'video', 'serial', 'status'])
                ->where('tenant_id', $this->tenantId())
                ->orderBy('serial');

            return DataTables::of($galleries)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return $row->image
                        ? '<img src="' . asset('uploads/galleries/' . $row->image) . '" class="img-thumbnail" style="width:50px;height:50px;object-fit:cover;">'
                        : '';
                })
                ->addColumn('video', function ($row) {
                    return $row->video
                        ? '<a href="' . $row->video . '" target="_blank"><i class="ri-play-circle-line fs-4 text-primary"></i></a>'
                        : '<span class="text-muted">—</span>';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch" dir="ltr">
                                <input type="checkbox" class="form-check-input toggle-status"
                                       id="gallerySwitch' . $row->id . '" data-id="' . $row->id . '" ' . $checked . '>
                                <label class="form-check-label" for="gallerySwitch' . $row->id . '"></label>
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
                                        data-delete-url="' . route('gallery.delete', $row->id) . '"
                                        data-method="DELETE"
                                        data-table="#galleryTable">
                                        <i class="ri-delete-bin-fill me-2"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'video', 'status', 'action'])
                ->make(true);
        }

        $galleries = Gallery::where('tenant_id', $this->tenantId())->orderBy('serial')->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'video' => 'nullable|url|max:255',
        ]);

        $data = new Gallery();
        $data->tenant_id = $this->tenantId();
        $data->title     = $request->title;
        $data->video     = $request->video;

        $lastSerial = Gallery::where('tenant_id', $this->tenantId())->max('serial');
        $data->serial = $lastSerial ? $lastSerial + 1 : 1;

        $name = mt_rand(10000000, 99999999) . '.webp';
        $path = public_path('uploads/galleries/');
        if (!file_exists($path)) mkdir($path, 0755, true);

        Image::make($request->file('image'))
            ->resize(1200, null, fn($c) => $c->aspectRatio())
            ->encode('webp', 80)
            ->save($path . $name);

        $data->image = $name;
        $data->save();

        return response()->json(['message' => 'Gallery item created successfully!'], 200);
    }

    public function edit($id)
    {
        $gallery = Gallery::where('tenant_id', $this->tenantId())->findOrFail($id);
        return response()->json($gallery);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'video' => 'nullable|url|max:255',
        ]);

        $gallery = Gallery::where('tenant_id', $this->tenantId())->findOrFail($request->codeid);
        $gallery->title = $request->title;
        $gallery->video = $request->video;

        if ($request->hasFile('image')) {
            if ($gallery->image && file_exists(public_path('uploads/galleries/' . $gallery->image))) {
                @unlink(public_path('uploads/galleries/' . $gallery->image));
            }
            $name = mt_rand(10000000, 99999999) . '.webp';
            $path = public_path('uploads/galleries/');
            if (!file_exists($path)) mkdir($path, 0755, true);

            Image::make($request->file('image'))
                ->resize(1200, null, fn($c) => $c->aspectRatio())
                ->encode('webp', 80)
                ->save($path . $name);

            $gallery->image = $name;
        }

        $gallery->save();
        return response()->json(['message' => 'Gallery item updated successfully!'], 200);
    }

    public function destroy($id)
    {
        $gallery = Gallery::where('tenant_id', $this->tenantId())->findOrFail($id);
        if ($gallery->image && file_exists(public_path('uploads/galleries/' . $gallery->image))) {
            @unlink(public_path('uploads/galleries/' . $gallery->image));
        }
        $gallery->delete();
        return response()->json(['message' => 'Gallery item deleted successfully.'], 200);
    }

    public function toggleStatus(Request $request)
    {
        $gallery = Gallery::where('tenant_id', $this->tenantId())->findOrFail($request->gallery_id);
        $gallery->status = $request->status;
        $gallery->save();
        return response()->json(['message' => 'Status updated successfully.'], 200);
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Gallery::where('id', $id)
                ->where('tenant_id', $this->tenantId())
                ->update(['serial' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }
}
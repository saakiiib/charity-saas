<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Master::where('tenant_id', $this->tenantId())->orderByDesc('id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown">
                                <i class="ri-more-fill"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item EditBtn" data-id="' . $row->id . '">
                                        <i class="ri-pencil-fill me-2"></i>Edit
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item CopyBtn" data-id="' . $row->id . '">
                                        <i class="ri-file-copy-fill me-2"></i>Copy
                                    </button>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item deleteBtn"
                                        data-delete-url="' . route('master.delete', $row->id) . '"
                                        data-method="DELETE"
                                        data-table="#masterTable">
                                        <i class="ri-delete-bin-fill me-2"></i>Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.master.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $data = new Master();
        $data->tenant_id        = $this->tenantId();
        $data->page             = $request->page;
        $data->name             = $request->name;
        $data->short_title      = $request->short_title;
        $data->long_title       = $request->long_title;
        $data->short_description = $request->short_description;
        $data->long_description = $request->long_description;
        $data->meta_title       = $request->meta_title;
        $data->meta_description = $request->meta_description;
        $data->meta_keywords    = $request->meta_keywords;

        // content JSON - FIXED
        if ($request->has('has_content_field')) {
            $content = [];
            if ($request->has('content_key') && is_array($request->content_key)) {
                foreach ($request->content_key as $i => $key) {
                    if (!empty($key)) {
                        $content[] = [
                            'key'            => $key,
                            'short_desc'     => $request->content_short_desc[$i] ?? null,
                            'long_desc'      => $request->content_long_desc[$i] ?? null,
                        ];
                    }
                }
            }
            $data->content = !empty($content) ? $content : null;
        }

        $this->handleImage($request, $data, 'image', 'image');
        $this->handleImage($request, $data, 'image2', 'image2');
        $this->handleImage($request, $data, 'meta_image', 'meta_image');

        $data->save();
        return response()->json(['message' => 'Master data created successfully.'], 200);
    }

    public function edit($id)
    {
        $data = Master::where('tenant_id', $this->tenantId())->findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'page' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $data = Master::where('tenant_id', $this->tenantId())->findOrFail($request->codeid);
        $data->page             = $request->page;
        $data->name             = $request->name;
        $data->short_title      = $request->short_title;
        $data->long_title       = $request->long_title;
        $data->short_description = $request->short_description;
        $data->long_description = $request->long_description;
        $data->meta_title       = $request->meta_title;
        $data->meta_description = $request->meta_description;
        $data->meta_keywords    = $request->meta_keywords;

        // content JSON - FIXED
        if ($request->has('has_content_field')) {
            $content = [];
            if ($request->has('content_key') && is_array($request->content_key)) {
                foreach ($request->content_key as $i => $key) {
                    if (!empty($key)) {
                        $content[] = [
                            'key'        => $key,
                            'short_desc' => $request->content_short_desc[$i] ?? null,
                            'long_desc'  => $request->content_long_desc[$i] ?? null,
                        ];
                    }
                }
            }
            $data->content = !empty($content) ? $content : null;
        }

        $this->handleImage($request, $data, 'image', 'image');
        $this->handleImage($request, $data, 'image2', 'image2');
        $this->handleImage($request, $data, 'meta_image', 'meta_image');

        $data->save();
        return response()->json(['message' => 'Master data updated successfully.'], 200);
    }

    public function destroy($id)
    {
        $data = Master::where('tenant_id', $this->tenantId())->findOrFail($id);
        foreach (['image', 'image2', 'meta_image'] as $field) {
            $folder = $field === 'meta_image' ? 'meta_image' : 'masters';
            if ($data->$field && file_exists(public_path("uploads/{$folder}/" . $data->$field))) {
                @unlink(public_path("uploads/{$folder}/" . $data->$field));
            }
        }
        $data->delete();
        return response()->json(['message' => 'Master data deleted successfully.'], 200);
    }

    public function copy($id)
    {
        $original = Master::where('tenant_id', $this->tenantId())->findOrFail($id);

        $data = $original->replicate();
        $data->name      = $original->name . '_copy';
        $data->image     = $this->copyFile($original->image, 'uploads/masters');
        $data->image2    = $this->copyFile($original->image2, 'uploads/masters');
        $data->meta_image = $this->copyFile($original->meta_image, 'uploads/meta_image');
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();

        return response()->json([
            'message' => 'Master data copied successfully.',
            'data' => $data
        ], 200);
    }

    private function copyFile($filename, $folder)
    {
        if (!$filename) return null;

        $source = public_path($folder . '/' . $filename);
        if (!file_exists($source)) return null;

        $ext     = pathinfo($filename, PATHINFO_EXTENSION);
        $newName = mt_rand(10000000, 99999999) . '.' . $ext;
        $dest    = public_path($folder . '/' . $newName);

        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0755, true);
        }

        copy($source, $dest);

        return $newName;
    }

    private function handleImage(Request $request, Master $data, string $field, string $column)
    {
        if (!$request->hasFile($field)) return;

        $folder = $field === 'meta_image' ? 'meta_image' : 'masters';
        $path   = public_path("uploads/{$folder}/");
        if (!file_exists($path)) mkdir($path, 0755, true);

        if ($data->$column && file_exists($path . $data->$column)) {
            @unlink($path . $data->$column);
        }

        $name = mt_rand(10000000, 99999999) . '.webp';
        Image::make($request->file($field))
            ->resize(1200, null, fn($c) => $c->aspectRatio())
            ->encode('webp', 80)
            ->save($path . $name);

        $data->$column = $name;
    }
}
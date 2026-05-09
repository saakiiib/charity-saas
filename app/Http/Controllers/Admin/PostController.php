<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use DataTables;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::select(['id', 'title', 'image', 'status'])
                ->where('tenant_id', $this->tenantId())
                ->latest();

            return DataTables::of($posts)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return $row->image
                        ? '<img src="' . asset('uploads/posts/' . $row->image) . '" class="img-thumbnail" style="width:50px;height:50px;">'
                        : '';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch" dir="ltr">
                                <input type="checkbox" class="form-check-input toggle-status"
                                       id="postSwitch' . $row->id . '" data-id="' . $row->id . '" ' . $checked . '>
                                <label class="form-check-label" for="postSwitch' . $row->id . '"></label>
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
                                        data-delete-url="' . route('post.delete', $row->id) . '"
                                        data-method="DELETE"
                                        data-table="#postTable">
                                        <i class="ri-delete-bin-fill me-2"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.posts.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = new Post();
        $data->tenant_id = $this->tenantId();
        $data->title = $request->title;
        $data->short_description = $request->short_description;
        $data->long_description = $request->long_description;

        $name = mt_rand(10000000, 99999999) . '.webp';
        $path = public_path('uploads/posts/');
        if (!file_exists($path)) mkdir($path, 0755, true);

        Image::make($request->file('image'))
            ->resize(1200, null, fn($c) => $c->aspectRatio())
            ->encode('webp', 80)
            ->save($path . $name);

        $data->image = $name;
        $data->save();

        return response()->json(['message' => 'Post created successfully!'], 200);
    }

    public function edit($id)
    {
        $post = Post::where('tenant_id', $this->tenantId())->findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $post = Post::where('tenant_id', $this->tenantId())->findOrFail($request->codeid);
        $post->title = $request->title;
        $post->short_description = $request->short_description;
        $post->long_description = $request->long_description;

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path('uploads/posts/' . $post->image))) {
                @unlink(public_path('uploads/posts/' . $post->image));
            }
            $name = mt_rand(10000000, 99999999) . '.webp';
            $path = public_path('uploads/posts/');
            if (!file_exists($path)) mkdir($path, 0755, true);

            Image::make($request->file('image'))
                ->resize(1200, null, fn($c) => $c->aspectRatio())
                ->encode('webp', 80)
                ->save($path . $name);

            $post->image = $name;
        }

        $post->save();
        return response()->json(['message' => 'Post updated successfully!'], 200);
    }

    public function destroy($id)
    {
        $post = Post::where('tenant_id', $this->tenantId())->findOrFail($id);
        if ($post->image && file_exists(public_path('uploads/posts/' . $post->image))) {
            @unlink(public_path('uploads/posts/' . $post->image));
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully.'], 200);
    }

    public function toggleStatus(Request $request)
    {
        $post = Post::where('tenant_id', $this->tenantId())->findOrFail($request->post_id);
        $post->status = $request->status;
        $post->save();
        return response()->json(['message' => 'Status updated successfully.'], 200);
    }
}
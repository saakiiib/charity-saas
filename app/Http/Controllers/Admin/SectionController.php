<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::where('tenant_id', $this->tenantId())->orderBy('sl')->get();
        return view('admin.sections.index', compact('sections'));
    }

    public function updateOrder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Section::where('id', $id)
                ->where('tenant_id', $this->tenantId())
                ->update(['sl' => $index + 1]);
        }
        return response()->json(['status' => 'success', 'message' => 'Section order updated']);
    }

    public function toggleStatus(Request $request)
    {
        $section = Section::findOrFail($request->id);
        $section->status = $request->status;
        $section->save();
        return response()->json(['status' => 'success', 'message' => 'Status updated']);
    }
}
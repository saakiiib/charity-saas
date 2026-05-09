<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use DataTables;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $faqs = Faq::select(['id', 'question', 'serial', 'status'])
                ->where('tenant_id', $this->tenantId())
                ->orderBy('serial');

            return DataTables::of($faqs)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $checked = $row->status == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch" dir="ltr">
                                <input type="checkbox" class="form-check-input toggle-status"
                                       id="faqSwitch' . $row->id . '" data-id="' . $row->id . '" ' . $checked . '>
                                <label class="form-check-label" for="faqSwitch' . $row->id . '"></label>
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
                                        data-delete-url="' . route('faq.delete', $row->id) . '"
                                        data-method="DELETE"
                                        data-table="#faqTable">
                                        <i class="ri-delete-bin-fill me-2"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $faqs = Faq::where('tenant_id', $this->tenantId())->orderBy('serial')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required',
        ]);

        $data = new Faq();
        $data->tenant_id = $this->tenantId();
        $data->question  = $request->question;
        $data->answer    = $request->answer;

        $lastSerial = Faq::where('tenant_id', $this->tenantId())->max('serial');
        $data->serial = $lastSerial ? $lastSerial + 1 : 1;

        $data->save();
        return response()->json(['message' => 'FAQ created successfully!'], 200);
    }

    public function edit($id)
    {
        $faq = Faq::where('tenant_id', $this->tenantId())->findOrFail($id);
        return response()->json($faq);
    }

    public function update(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required',
        ]);

        $faq = Faq::where('tenant_id', $this->tenantId())->findOrFail($request->codeid);
        $faq->question = $request->question;
        $faq->answer   = $request->answer;
        $faq->save();

        return response()->json(['message' => 'FAQ updated successfully!'], 200);
    }

    public function destroy($id)
    {
        Faq::where('tenant_id', $this->tenantId())->findOrFail($id)->delete();
        return response()->json(['message' => 'FAQ deleted successfully.'], 200);
    }

    public function toggleStatus(Request $request)
    {
        $faq = Faq::where('tenant_id', $this->tenantId())->findOrFail($request->faq_id);
        $faq->status = $request->status;
        $faq->save();
        return response()->json(['message' => 'Status updated successfully.'], 200);
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Faq::where('id', $id)
                ->where('tenant_id', $this->tenantId())
                ->update(['serial' => $index + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Order updated successfully!']);
    }
}
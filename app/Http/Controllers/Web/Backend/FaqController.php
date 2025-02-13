<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {

            $data = Faq::latest();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('question', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('question', function ($data) {
                    $page_content       = $data->question;
                    $short_page_content = strlen($page_content) > 60 ? substr($page_content, 0, 60) . '...' : $page_content;
                    return '<p>' . $short_page_content . '</p>';
                })
                ->addColumn('answer', function ($data) {
                    $page_content       = $data->answer;
                    $short_page_content = strlen($page_content) > 60 ? substr($page_content, 0, 60) . '...' : $page_content;
                    return '<p>' . $short_page_content . '</p>';
                })
                ->addColumn('status', function ($data) {
                    $status = ' <div class="form-check form-switch">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
                    if ($data->status == "active") {
                        $status .= "checked";
                    }
                    $status .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="text-center"><div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('admin.faqs.edit', ['id' => $data->id]) . '" class="text-white btn btn-primary" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="text-white btn btn-danger" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div></div>';
                })
                ->rawColumns(['question', 'answer', 'action', 'status'])
                ->make(true);
        }
        return view('backend.layouts.faq.index');
    }

    public function create() {
        return view('backend.layouts.faq.create');
    }

    public function store(Request $request) {

        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        try {

            Faq::create([
                'question'=> $request->input('question'),
                'answer'=> $request->input('answer')
            ]);

            return to_route('admin.faqs.index')->with('t-success', 'FAQ Created');

        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }

    public function edit($id) {
        $data = Faq::findOrFail($id);
        return view('backend.layouts.faq.edit', compact('data'));
    }

    public function update(Request $request, int $id) {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        try {

            Faq::where('id', $id)->update([
                'question'=> $request->input('question'),
                'answer'=> $request->input('answer')
            ]);

            return to_route('admin.faqs.index')->with('t-success', 'FAQ Updated');

        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }

    public function status(int $id): JsonResponse {
        $data = Faq::findOrFail($id);
        if ($data->status == 'inactive') {
            $data->status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        }
    }

    public function destroy(int $id): JsonResponse {
        $data = Faq::findOrFail($id);
        $data->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }
}

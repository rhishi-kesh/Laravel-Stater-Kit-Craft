<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {

            $data = Category::latest();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('name', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image_url', function ($data) {
                    $url = asset($data->image_url);
                    $image = '<img src="'. $url .'" width="100px">';

                    return $image;
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
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('admin.category.edit', ['id' => $data->id]) . '" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['image_url', 'status', 'action'])
                ->make(true);
        }
        return view('backend.layouts.category.index');
    }

    public function create() {
        return view('backend.layouts.category.create');
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:4048',
        ]);

        if ($request->hasFile('image')) {
            $image                        = $request->file('image');
            $imageName                    = uploadImage($image, 'Category');
        }

        try {

            Category::create([
                'name' => $request->name,
                'image_url' => $imageName,
            ]);

            return to_route('admin.category.index')->with('t-success', 'New Category Created');

        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }

    public function edit($id) {
        $data = Category::findOrFail($id);
        return view('backend.layouts.category.edit', compact('data'));
    }

    public function update(Request $request, $id) {

        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:4048',
        ]);

        $data = Category::findOrFail($id);
        if ($request->hasFile('image')) {

            if ($data->image_url) {
                $previousImagePath = public_path($data->image_url);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }

            $image                        = $request->file('image');
            $imageName                    = uploadImage($image, 'Category');
        }else {
            $imageName = $data->image_url;
        }

        try {

            Category::where('id', $id)->update([
                'name'=> $request->name,
                'image_url'=> $imageName,
            ]);

            return to_route('admin.category.index')->with('t-success', 'Category Updated');

        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }

    public function status(int $id): JsonResponse {
        $data = Category::findOrFail($id);
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
        $data = Category::findOrFail($id);
        if ($data->image_url) {
            $previousImagePath = public_path($data->image_url);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
        $data->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }
}

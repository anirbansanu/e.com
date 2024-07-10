<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $entries = $request->input('entries', config('app.pagination_limit'));

            $categories = ProductCategory::where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate($entries);

            $categories->appends(['search' => $search, 'sort_by' => $sort_by, 'sort_order' => $sort_order,'entries'=>$entries]);

            return view("admin.products.categories.index", compact("categories",  'search', 'sort_by', 'sort_order', 'entries'));
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $categories = ProductCategory::all();
            return view('admin.products.categories.create', compact("categories"));
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    public function store(ProductCategoryRequest $request)
    {
        try {
            $data = $request->validated();

            // If a parent category is selected, associate it with the new category
            if ($request->has('parent_id') && $request->parent_id) {
                $parentCategory = ProductCategory::find($request->input('parent_id'));
                if ($parentCategory) {
                    $data['parent_id'] = $parentCategory->id;
                }
            }
            $data['is_active'] = $request->has('is_active') ? "1" : "0";
            ProductCategory::create($data);


            return redirect()->route('categories.index');
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    public function edit(ProductCategory $category)
    {
        try {
            $categories = ProductCategory::all();
            return view('admin.products.categories.edit', compact('category','categories'));
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        try {
            $data = $request->validated();
            $data['parent_id'] = $request->input('parent_id');
            $data['is_active'] = $request->has('is_active') ? "1" : "0";
            $category->update($data);

            return redirect()->route('categories.index');
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    public function destroy(ProductCategory $category)
    {
        try {
            $category->delete();

            return redirect()->route('categories.index');
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    public function toggleStatus($category,Request $request)
    {
        try {
            $category = ProductCategory::find($category);
            $category->is_active = $request->is_active == "1" ? "1" : "0";
            $category->save();
            $status = $request->is_active == "1" ? 'activated' : 'deactivated';
            $msg = "Category {$category->name} {$status} successfully";
            return response()->json(['status' => true, 'msg' => $msg, 'data' => $category]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response('',404)->json(['status' => true, 'msg' => $msg]);
        }
    }
    function getJsonCategories(Request $request){
        try {
            $query = $request->input('q');
            $page = $request->input('page', 1);
            $perPage = config('app.pagination_limit');

            $categories = ProductCategory::where('name', 'like', "%$query%")
                ->paginate($perPage, ['*'], 'page', $page);
            $msg = "Categories fetched successfully";
            return response()->json($categories);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response('',404)->json(['status' => true, 'msg' => $msg]);
        }
    }
}

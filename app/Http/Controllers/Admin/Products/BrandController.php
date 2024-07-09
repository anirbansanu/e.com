<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $entries = $request->input('entries', config('app.pagination_limit'));

            $brands = Brand::where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate($entries);

            $brands->appends(['search' => $search, 'sort_by' => $sort_by, 'sort_order' => $sort_order, 'entries' => $entries]);

            return view("admin.products.brands.index",compact('brands', 'search', 'sort_by', 'sort_order', 'entries'));


        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            return view('admin.products.brands.create');
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    public function store(BrandRequest $request)
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->has('is_active') ? "1" : "0";
            Brand::create($data);

            return redirect()->route('brands.index');
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    public function edit(Brand $brand)
    {
        try {
            return view('admin.products.brands.edit', compact('brand'));
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    public function update(BrandRequest $request,$brand)
    {

        try {
            $brand = Brand::find($brand);
            $brand->name = $request->name;
            $brand->description = $request->description;
            $brand->is_active = $request->has('is_active') ? "1" : "0";

            $brand->save();

            return redirect()->route('brands.index');
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();

            return redirect()->route('brands.index');
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }
    public function changeStatus($brand,Request $request)
    {
        try {
            $brand = Brand::find($brand);
            $brand->is_active = $request->is_active == "1" ? "1" : "0";
            $brand->save();
            $status = $request->is_active == "1" ? 'activated' : 'deactivated';
            $msg = "Brand {$brand->name} {$status} successfully";
            return response()->json(['status' => true, 'msg' => $msg, 'data' => $brand]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response('',404)->json(['status' => true, 'msg' => $msg]);
        }
    }
    public function getJsonBrands(Request $request){
        try {
            $query = $request->input('q');
            $page = $request->input('page', 1);
            $perPage = config('app.pagination_limit');

            $brands = Brand::where('name', 'like', "%$query%")
                ->paginate($perPage, ['*'], 'page', $page);
            return response()->json($brands);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response('',404)->json(['status' => true, 'msg' => $msg]);
        }
    }
}

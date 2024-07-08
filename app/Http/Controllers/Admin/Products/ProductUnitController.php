<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductUnitRequest;
use App\Models\ProductUnit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductUnitController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = $request->input('query');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $product_units = ProductUnit::where(function ($q) use ($query) {
                $q->where('unit_name', 'like', '%' . $query . '%');
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate(config('app.pagination_limit'));

            $product_units->appends(['query' => $query, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);

            return view('admin.products.product_units.index', compact('product_units', 'query', 'sort_by', 'sort_order'));
        } catch (\Exception $e) {
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function create()
    {
        try {
            return view('admin.products.product_units.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function store(ProductUnitRequest $request)
    {
        try {
            $validatedData = $request->validated();
            ProductUnit::create($validatedData);
            toast('Product unit created successfully','success');
            return redirect()->route('admin.product_units.index')->with('success', 'Product unit created successfully.');
        } catch (ValidationException $e) {

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function show($id)
    {
        try {
            $productUnit = ProductUnit::findOrFail($id);
            return view('admin.products.product_units.show', compact('productUnit'));
        } catch (ModelNotFoundException $e) {
            toast('Product unit not found','error');
            return redirect()->route('admin.product_units.index')->with('error', 'Product unit not found.');
        } catch (\Exception $e) {
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function edit($id)
    {
        try {
            $productUnit = ProductUnit::findOrFail($id);
            return view('admin.products.product_units.edit', compact('productUnit'));
        } catch (ModelNotFoundException $e) {
            toast('Product unit not found','error');
            return redirect()->route('admin.product_units.index')->with('error', 'Product unit not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function update(ProductUnitRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $productUnit = ProductUnit::findOrFail($id);
            $productUnit->update($validatedData);
            toast('Product unit updated successfully','success');
            return redirect()->route('admin.product_units.index')->with('success', 'Product unit updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            toast('Product unit not found','error');
            return redirect()->route('admin.product_units.index')->with('error', 'Product unit not found.');
        } catch (\Exception $e) {
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function destroy($id)
    {
        try {
            $productUnit = ProductUnit::findOrFail($id);
            $productUnit->delete();
            return redirect()->route('admin.product_units.index')->with('success', 'Product unit deleted successfully.');
        } catch (ModelNotFoundException $e) {
            toast('Product unit not found','error');
            return redirect()->route('admin.product_units.index')->with('error', 'Product unit not found.');
        } catch (\Exception $e) {
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function trash(Request $request)
    {
        try {
            $query = $request->input('query');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $product_units = ProductUnit::onlyTrashed()
                                ->where(function ($q) use ($query) {
                                    $q->where('unit_name', 'like', '%' . $query . '%');
                                })
                                ->orderBy($sort_by, $sort_order)
                                ->paginate(config('app.pagination_limit'));

            $product_units->appends(['query' => $query, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);
            return view('admin.products.product_units.trash', compact('product_units', 'query', 'sort_by', 'sort_order'));
        } catch (\Exception $e) {
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function untrash($id)
    {
        try {
            $productUnit = ProductUnit::withTrashed()->findOrFail($id);
            $productUnit->restore();
            return redirect()->route('admin.product_units.index')->with('success', 'Product unit restored successfully.');
        } catch (ModelNotFoundException $e) {
            toast('Product unit not found','error');
            return redirect()->route('admin.product_units.index')->with('error', 'Product unit not found.');
        } catch (\Exception $e) {
            toast($e->getMessage(),'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }
    function getJson(Request $request){
        try {
            $query = $request->input('q');
            $page = $request->input('page', 1);
            $perPage = config('app.pagination_limit');

            $productUnits = ProductUnit::where('unit_name', 'like', "%$query%")
                ->paginate($perPage, ['*'], 'page', $page);
            return response()->json($productUnits);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response('',404)->json(['status' => true, 'msg' => $msg]);
        }
    }
    
    // public function toggleStatus($id)
    // {
    //     try {
    //         $productUnit = ProductUnit::findOrFail($id);
    //         $productUnit->is_active = !$productUnit->is_active;
    //         $productUnit->save();
    //         return redirect()->route('admin.product_units.index')->with('success', 'Product unit status toggled successfully.');
    //     } catch (ModelNotFoundException $e) {
    //         toast('Product unit not found','error');
    //         return redirect()->route('admin.product_units.index')->with('error', 'Product unit not found.');
    //     } catch (\Exception $e) {
    //         toast($e->getMessage(),'error');
    //         return redirect()->back()->with('error', 'An error occurred.');
    //     }
    // }
}

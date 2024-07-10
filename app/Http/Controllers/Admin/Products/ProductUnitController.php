<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductUnitRequest;
use App\Models\ProductUnit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductUnitController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $entries = $request->input('entries', config('app.pagination_limit'));

            $units = ProductUnit::where(function ($q) use ($search) {
                $q->where('unit_name', 'like', '%' . $search . '%');
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate($entries);

            $units->appends(['search' => $search, 'sort_by' => $sort_by, 'sort_order' => $sort_order,'entries'=>$entries]);

            return view('admin.products.units.index', compact('units', 'search', 'sort_by', 'sort_order', 'entries'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.products.units.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(ProductUnitRequest $request)
    {
        try {
            $validatedData = $request->validated();
            ProductUnit::create($validatedData);

            return redirect()->route('admin.units.index')->with('success', 'Product unit created successfully.');
        } catch (ValidationException $e) {

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $productUnit = ProductUnit::findOrFail($id);
            return view('admin.products.units.show', compact('productUnit'));
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.units.index')->with('error', 'Product unit not found.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function edit($id)
    {
        try {
            $unit = ProductUnit::findOrFail($id);
            return view('admin.products.units.edit', compact('unit'));
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.units.index')->with('error', 'Product unit not found.');
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

            return redirect()->route('admin.units.index')->with('success', 'Product unit updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.units.index')->with('error', 'Product unit not found.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function destroy($id)
    {
        try {
            $productUnit = ProductUnit::findOrFail($id);
            $productUnit->delete();
            return redirect()->route('admin.units.index')->with('success', 'Product unit deleted successfully.');
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.units.index')->with('error', 'Product unit not found.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function trash(Request $request)
    {
        try {
            $search = $request->input('search');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $units = ProductUnit::onlyTrashed()
                                ->where(function ($q) use ($search) {
                                    $q->where('unit_name', 'like', '%' . $search . '%');
                                })
                                ->orderBy($sort_by, $sort_order)
                                ->paginate(config('app.pagination_limit'));

            $units->appends(['search' => $search, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);
            return view('admin.products.units.trash', compact('units', 'search', 'sort_by', 'sort_order'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function untrash($id)
    {
        try {
            $productUnit = ProductUnit::withTrashed()->findOrFail($id);
            $productUnit->restore();
            return redirect()->route('admin.units.index')->with('success', 'Product unit restored successfully.');
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.units.index')->with('error', 'Product unit not found.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }
    function getJson(Request $request){
        try {
            $search = $request->input('q');
            $page = $request->input('page', 1);
            $perPage = config('app.pagination_limit');

            $productUnits = ProductUnit::where('unit_name', 'like', "%$search%")
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
    //         return redirect()->route('admin.units.index')->with('success', 'Product unit status toggled successfully.');
    //     } catch (ModelNotFoundException $e) {
    //
    //         return redirect()->route('admin.units.index')->with('error', 'Product unit not found.');
    //     } catch (\Exception $e) {
    //
    //         return redirect()->back()->with('error', 'An error occurred.');
    //     }
    // }
}

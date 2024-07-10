<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductAttributeRequest;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductAttributeController extends Controller
{
    // Index method for listing product attributes with search and sorting
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $entries = $request->input('entries', config('app.pagination_limit'));

            $attributes = ProductAttribute::where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate($entries);

            $attributes->appends(['search' => $search, 'sort_by' => $sort_by, 'sort_order' => $sort_order,'entries'=>$entries]);

            return view('admin.products.attributes.index', compact('attributes', 'search', 'sort_by', 'sort_order', 'entries'));


        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Create method for displaying the product attribute creation form
    public function create()
    {
        try {
            return view('admin.products.attributes.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Store method for handling the creation of a new product attribute
    public function store(ProductAttributeRequest $request)
    {
        try {
            $validatedData = $request->validated();
            ProductAttribute::create($validatedData);

            return redirect()->route('admin.attributes.index')->with('success', 'Product attribute created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Show method for displaying a specific product attribute
    public function show($id)
    {
        try {
            $attribute = ProductAttribute::findOrFail($id);
            return view('admin.products.attributes.show', compact('attribute'));
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.attributes.index')->with('error', 'Product attribute not found.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Edit method for displaying the product attribute editing form
    public function edit($id)
    {
        try {
            $attribute = ProductAttribute::findOrFail($id);
            return view('admin.products.attributes.edit', compact('attribute'));
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.attributes.index')->with('error', 'Product attribute not found.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Update method for handling the update of an existing product attribute
    public function update(ProductAttributeRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $attribute = ProductAttribute::findOrFail($id);
            $attribute->update($validatedData);

            return redirect()->route('admin.attributes.index')->with('success', 'Product attribute updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.attributes.index')->with('error', 'Product attribute not found.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Destroy method for handling the deletion of a product attribute
    public function destroy($id)
    {
        try {
            $attribute = ProductAttribute::findOrFail($id);
            $attribute->delete();

            return redirect()->route('admin.attributes.index')->with('success', 'Product attribute deleted successfully.');
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.attributes.index')->with('error', 'Product attribute not found.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Trash method for listing trashed product attributes
    public function trash(Request $request)
    {
        try {
            $search = $request->input('search');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $entries = $request->input('entries', config('app.pagination_limit'));

            $trashedProductAttributes = ProductAttribute::onlyTrashed()
                ->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orderBy($sort_by, $sort_order)
                ->paginate($entries);

            $trashedProductAttributes->appends(['search' => $search, 'sort_by' => $sort_by, 'sort_order' => $sort_order,'entries'=>$entries]);

            return view('admin.products.attributes.trash', compact('trashedProductAttributes', 'search', 'sort_by', 'sort_order', 'entries'));


        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Untrash method for restoring a trashed product attribute
    public function untrash($id)
    {
        try {
            $attribute = ProductAttribute::withTrashed()->findOrFail($id);
            $attribute->restore();
            return redirect()->route('admin.attributes.index')->with('success', 'Product attribute restored successfully.');
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.attributes.index')->with('error', 'Product attribute not found.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Delete permanently method for deleting a product attribute permanently from the database
    public function forceDelete($id)
    {
        try {
            $attribute = ProductAttribute::withTrashed()->findOrFail($id);
            $attribute->forceDelete();

            return redirect()->route('admin.attributes.trash');
            } catch (ModelNotFoundException $e) {

                return redirect()->route('admin.attributes.index');
            } catch (\Exception $e) {

                return redirect()->back()->withInput();
            }
    }
    public function getJson(Request $request){
        try {
            $search = $request->input('search');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $entries = $request->input('entries', config('app.pagination_limit'));

            $attributes = ProductAttribute::where('name', 'like', "%$search%")
                ->orderBy($sort_by, $sort_order)
                ->paginate($entries);
            return response()->json($attributes);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response('',404)->json(['status' => true, 'msg' => $msg]);
        }
    }
}


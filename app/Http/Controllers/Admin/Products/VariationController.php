<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariationRequest;
use App\Models\Variation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VariationController extends Controller
{
    // Index method for listing product variations with search and sorting
    public function index(Request $request)
    {
        try {
            $query = $request->input('query');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $variations = Variation::where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
                ->orderBy($sort_by, $sort_order)
                ->paginate(config('app.pagination_limit'));

            $variations->appends(['query' => $query, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);

            return view('admin.products.variations.index', compact('variations', 'query', 'sort_by', 'sort_order'));
        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Create method for displaying the product variation creation form
    public function create()
    {
        try {
            return view('admin.products.variations.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Store method for handling the creation of a new product variation
    public function store(VariationRequest $request)
    {
        try {
            $validatedData = $request->validated();
            Variation::create($validatedData);
            toast('Product variation created successfully', 'success');
            return redirect()->route('admin.variations.index')->with('success', 'Product variation created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Show method for displaying a specific product variation
    public function show($id)
    {
        try {
            $variation = Variation::findOrFail($id);
            return view('admin.products.variations.show', compact('variation'));
        } catch (ModelNotFoundException $e) {
            toast('Product variation not found', 'error');
            return redirect()->route('admin.variations.index')->with('error', 'Product variation not found.');
        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Edit method for displaying the product variation editing form
    public function edit($id)
    {
        try {
            $variation = Variation::findOrFail($id);
            return view('admin.products.variations.edit', compact('variation'));
        } catch (ModelNotFoundException $e) {
            toast('Product variation not found', 'error');
            return redirect()->route('admin.variations.index')->with('error', 'Product variation not found.');
        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Update method for handling the update of an existing product variation
    public function update(VariationRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $variation = Variation::findOrFail($id);
            $variation->update($validatedData);
            toast('Product variation updated successfully', 'success');
            return redirect()->route('admin.variations.index')->with('success', 'Product variation updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            toast('Product variation not found', 'error');
            return redirect()->route('admin.variations.index')->with('error', 'Product variation not found.');
        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Destroy method for handling the deletion of a product variation
    public function destroy($id)
    {
        try {
            $variation = Variation::findOrFail($id);
            $variation->delete();
            toast('Product variation deleted successfully.', 'success');
            return redirect()->route('admin.variations.index')->with('success', 'Product variation deleted successfully.');
        } catch (ModelNotFoundException $e) {
            toast('Product variation not found', 'error');
            return redirect()->route('admin.variations.index')->with('error', 'Product variation not found.');
        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Trash method for listing trashed product variations
    public function trash(Request $request)
    {
        try {
            $query = $request->input('query');
            $sort_by = $request->input('sort_by', 'updated_at');
            $sort_order = $request->input('sort_order', 'desc');
            $trashedVariations = Variation::onlyTrashed()
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%')
                        ->orWhere('value', 'like', '%' . $query . '%');
                })
                ->orderBy($sort_by, $sort_order)
                ->paginate(config('app.pagination_limit'));

            $trashedVariations->appends(['query' => $query, 'sort_by' => $sort_by, 'sort_order' => $sort_order]);

            return view('admin.products.variations.trash', compact('trashedVariations', 'query', 'sort_by', 'sort_order'));
        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Untrash method for restoring a trashed product variation
    public function untrash($id)
    {
        try {
            $variation = Variation::withTrashed()->findOrFail($id);
            $variation->restore();
            return redirect()->route('admin.variations.index')->with('success', 'Product variation restored successfully.');
        } catch (ModelNotFoundException $e) {
            toast('Product variation not found', 'error');
            return redirect()->route('admin.variations.index')->with('error', 'Product variation not found.');
        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    // Delete permanently method for deleting a product variation permanently from the database
    public function forceDelete($id)
    {
        try {
            $variation = Variation::withTrashed()->findOrFail($id);
            $variation->forceDelete();
            toast('Product variation deleted successfully.', 'success');
            return redirect()->route('admin.variations.trash');
            } catch (ModelNotFoundException $e) {
                toast('Product variation not found', 'error');
                return redirect()->route('admin.variations.index');
            } catch (\Exception $e) {
                toast($e->getMessage(), 'error');
                return redirect()->back()->withInput();
            }
    }
    public function getJson(Request $request){
        try {
            $query = $request->input('q');
            $page = $request->input('page', 1);
            $perPage = config('app.pagination_limit');

            $variations = Variation::where('name', 'like', "%$query%")
                ->paginate($perPage, ['*'], 'page', $page);
            return response()->json($variations);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response('',404)->json(['status' => true, 'msg' => $msg]);
        }
    }
}


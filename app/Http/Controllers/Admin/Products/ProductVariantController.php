<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductVariantDynamicRequest;
use App\Http\Resources\Product\ProductVariantResource;
use App\Models\ProductVariant;
use App\Services\Products\ProductService;
use App\Services\Products\ProductVariantService;
use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;

class ProductVariantController extends Controller
{
    private $productVariantService;
    private $productService;
    /**
     * ProductVariantController constructor.
     * @param ProductVariantService $productVariantService
     */
    public function __construct(ProductVariantService $productVariantService,ProductService $productService)
    {
        $this->productVariantService  = $productVariantService;
        $this->productService  = $productService;
    }

    public function store(Request $request)
    {

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'product_id' => 'required|exists:products,id',
                'attribute_name' => 'required|exists:product_attributes,name',
                'unit_name' => 'exists:product_units,unit_name',
                'attribute_value' => 'required|string|max:255',
            ]);
            // return $this->response(200, 'Product variant test', $request->all(), null);
            // Attempt to store the data
            $productVariant = $this->productVariantService->create($validatedData);

            // If the storage operation is successful, return a success response
            return $this->response(200, 'Product variants stored successfully', new ProductVariantResource($productVariant), null);
        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return $this->response(422, 'Validation error', [], $e->errors());
        } catch (\Exception $e) {
            // If an error occurs during the storage operation, return an error response
            return $this->response(500, 'Failed to store product variants', [], $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'product_id' => 'required|exists:products,id',
                'attribute_name' => 'required|exists:product_attributes,name',
                'unit_name' => 'exists:product_units,unit_name',
                'attribute_value' => 'required|string|max:255',
            ]);

            // Attempt to update the data
            $productVariant = $this->productVariantService->update($id, $validatedData);
            return $this->response(200, 'Product variants updated successfully', new ProductVariantResource($productVariant), null);
        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return $this->response(422, 'Validation error', [], $e->errors());
        } catch (\Exception $e) {
            // If an error occurs during the update operation, return an error response
            return $this->response(500, 'Failed to update product variants', [], $e->getMessage());
        }
    }

    public function destroy($variant)
    {
        try {
            // Attempt to delete the data
            $this->productVariantService->delete($variant);

            // Return a success response
            return $this->response(200, 'Product variants deleted successfully', [], null);
        } catch (\Exception $e) {
            // If an error occurs during the deletion operation, return an error response
            return $this->response(500, 'Failed to delete product variants', [], $e->getMessage());
        }
    }
    public function index(Request $request)
    {
        try {

            // Get all product variations
            $productVariants = $this->productVariantService->getAll();

            // Return a success response with the retrieved data
            return $this->response(200, 'All product variants retrieved successfully', ProductVariantResource::collection($productVariants), null);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return $this->response(500, 'Failed to retrieve all product variants', [], $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        try {
            // Get the product variants by ID
            $productVariant = $this->productVariantService->getById($id);

            // Return a success response with the retrieved data
            return $this->response(200, 'Product variants retrieved successfully', new ProductVariantResource($productVariant), null);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return $this->response(500, 'Failed to retrieve product variants', [], $e->getMessage());
        }
    }

    public function GetByProductSlug(Request $request,$slug)
    {
        try {

            // Get the product variants by product ID
            $product = $this->productService->getBySlug($slug);
            if($product)
            {
                $productVariants = $this->productVariantService->getByProductId($request,$product->id);
                $current_page = $productVariants->currentPage(); // Current page number
                $last_page = $productVariants->lastPage(); // Total number of pages
            }
            else{
                return $this->response(404, 'Product not found', [],'Failed to retrieve product');
            }

            // Return a success response with the retrieved data
            return $this->response(200, 'Product variants retrieved successfully', ProductVariantResource::collection($productVariants), [],[],["current_page"=>$current_page,"last_page"=>$last_page,"request"=>$request->all()]);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return $this->response(500, 'Failed to retrieve product variants', [], $e->getMessage());
        }
    }

    public function getByRequest(ProductVariantDynamicRequest $request)
    {
        // Initialize variables from validated query parameters
        $relations_array = $request->query('with', []);
        $where_array = $request->query('where', []);
        $group_by = $request->query('group_by', 'attribute_name'); // Default to 'attribute_name'
        $having_clause = $request->query('having_clause', null);
        $search = $request->query('search', '');
        $sort_by = $request->query('sort_by', 'attribute_name'); // Sort by a grouped column
        $sort_order = $request->query('sort_order', 'desc');
        $entries = $request->query('entries', config('app.pagination_limit'));

        // Initialize the query builder with relations
        $query = ProductVariant::with($relations_array);

        // Apply 'where' conditions, including nested relations
        foreach ($where_array as $key => $value) {
            if (strpos($key, '.') !== false) {
                list($relation, $relationKey) = explode('.', $key, 2);
                $query->whereHas($relation, function ($q) use ($relationKey, $value) {
                    $q->where($relationKey, $value);
                });
            } else {
                $query->where($key, $value);
            }
        }

        // Apply search conditions
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('attribute_name', 'like', '%' . $search . '%')
                ->orWhere('unit_name', 'like', '%' . $search . '%')
                ->orWhere('attribute_value', 'like', '%' . $search . '%');
            });
        }

        // Apply group by and having clauses if provided
        if (!empty($group_by)) {
            $query->groupBy($group_by);
        }

        if (!empty($having_clause)) {
            $query->havingRaw($having_clause);
        }

        // Apply sorting on a column that is part of the GROUP BY clause
        $query->orderBy($sort_by, $sort_order);

        // Paginate results
        $variants = $query->paginate($entries);
        $current_page = $variants->currentPage(); // Current page number
        $last_page = $variants->lastPage(); // Total number of pages
        return $this->response(200, 'Product variants retrieved successfully', $variants, [],[],["current_page"=>$current_page,"last_page"=>$last_page,"request"=>$request->all()]);
    }


}

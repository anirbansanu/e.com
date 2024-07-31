<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductVariantResource;
use App\Services\Products\ProductService;
use App\Services\Products\ProductVariantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
            return $this->response(200, 'Product variant relationship stored successfully', new ProductVariantResource($productVariant), null);
        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return $this->response(422, 'Validation error', [], $e->errors());
        } catch (\Exception $e) {
            // If an error occurs during the storage operation, return an error response
            return $this->response(500, 'Failed to store product variant relationship', [], $e->getMessage());
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
            return $this->response(200, 'Product variant relationship updated successfully', new ProductVariantResource($productVariant), null);
        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return $this->response(422, 'Validation error', [], $e->errors());
        } catch (\Exception $e) {
            // If an error occurs during the update operation, return an error response
            return $this->response(500, 'Failed to update product variant relationship', [], $e->getMessage());
        }
    }

    public function destroy($variant)
    {
        try {
            // Attempt to delete the data
            $this->productVariantService->delete($variant);

            // Return a success response
            return $this->response(200, 'Product variant relationship deleted successfully', [], null);
        } catch (\Exception $e) {
            // If an error occurs during the deletion operation, return an error response
            return $this->response(500, 'Failed to delete product variant relationship', [], $e->getMessage());
        }
    }
    public function index(Request $request)
    {
        try {

            // Get all product variation relationships
            $productVariants = $this->productVariantService->getAll();

            // Return a success response with the retrieved data
            return $this->response(200, 'All product variant relationships retrieved successfully', ProductVariantResource::collection($productVariants), null);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return $this->response(500, 'Failed to retrieve all product variant relationships', [], $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        try {
            // Get the product variant relationship by ID
            $productVariant = $this->productVariantService->getById($id);

            // Return a success response with the retrieved data
            return $this->response(200, 'Product variant relationship retrieved successfully', new ProductVariantResource($productVariant), null);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return $this->response(500, 'Failed to retrieve product variant relationship', [], $e->getMessage());
        }
    }

    public function GetByProductSlug(Request $request,$slug)
    {
        try {

            // Get the product variant relationships by product ID
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
            return $this->response(200, 'Product variant relationships retrieved successfully', ProductVariantResource::collection($productVariants), [],[],["current_page"=>$current_page,"last_page"=>$last_page,"request"=>$request->all()]);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return $this->response(500, 'Failed to retrieve product variant relationships', [], $e->getMessage());
        }
    }

}

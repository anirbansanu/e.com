<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Services\ProductVariantService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductVariantController extends Controller
{
    private $productVariationService;

    /**
     * ProductVariantController constructor.
     * @param ProductVariantService $productVariationService
     */
    public function __construct(ProductVariantService $productVariationService )
    {
        $this->productVariationService  = $productVariationService ;
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

            // Attempt to store the data
            $productToVariation = $this->productVariationService->create($validatedData);

            // If the storage operation is successful, return a success response
            return $this->response(200, 'Product to variation relationship stored successfully', $productToVariation, null);
        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return $this->response(422, 'Validation error', [], $e->errors());
        } catch (\Exception $e) {
            // If an error occurs during the storage operation, return an error response
            return $this->response(500, 'Failed to store product to variation relationship', [], $e->getMessage());
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
            $productToVariation = $this->productVariationService->update($id, $validatedData);
            return $this->response(200, 'Product to variation relationship updated successfully', $productToVariation, null);
        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return $this->response(422, 'Validation error', [], $e->errors());
        } catch (\Exception $e) {
            // If an error occurs during the update operation, return an error response
            return $this->response(500, 'Failed to update product to variation relationship', [], $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Attempt to delete the data
            $this->productVariationService->delete($id);

            // Return a success response
            return $this->response(200, 'Product to variation relationship deleted successfully', [], null);
        } catch (\Exception $e) {
            // If an error occurs during the deletion operation, return an error response
            return $this->response(500, 'Failed to delete product to variation relationship', [], $e->getMessage());
        }
    }
    public function get(Request $request)
    {
        try {
            // Get all product to variation relationships
            $productToVariations = $this->productVariationService->getAll();

            // Return a success response with the retrieved data
            return $this->response(200, 'All product to variation relationships retrieved successfully', $productToVariations, null);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return $this->response(500, 'Failed to retrieve all product to variation relationships', [], $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        try {
            // Get the product to variation relationship by ID
            $productToVariation = $this->productVariationService->getById($id);

            // Return a success response with the retrieved data
            return $this->response(200, 'Product to variation relationship retrieved successfully', $productToVariation, null);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return $this->response(500, 'Failed to retrieve product to variation relationship', [], $e->getMessage());
        }
    }

    public function GetByProductId(Request $request)
    {
        try {
            // Get the product to variation relationships by product ID
            $productToVariations = $this->productVariationService->getByProductId($request->product_id);

            // Return a success response with the retrieved data
            return $this->response(200, 'Product to variation relationships retrieved successfully', $productToVariations, null);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return $this->response(500, 'Failed to retrieve product to variation relationships', [], $e->getMessage());
        }
    }

}

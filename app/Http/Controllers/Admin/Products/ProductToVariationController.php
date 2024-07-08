<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Services\ProductToVariationService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductToVariationController extends Controller
{
    private $productToVariationService;

    /**
     * ProductToVariationController constructor.
     * @param ProductToVariationService $productToVariationService
     */
    public function __construct(ProductToVariationService $productToVariationService)
    {
        $this->productToVariationService = $productToVariationService;
    }

    public function ajaxStore(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'required|exists:variations,id',
                'unit_id' => 'exists:product_units,id',
                'variant_value' => 'required|string|max:255',
            ]);
            $validatedData['variation_id']=$validatedData['variant_id'];
            // Attempt to store the data
            $productToVariation = $this->productToVariationService->create($validatedData);

            // If the storage operation is successful, return a success response
            return response()->json([
                'success' => true,
                'message' => 'Product to variation relationship stored successfully',
                'data' => $productToVariation
            ], 200);
        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // If an error occurs during the storage operation, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to store product to variation relationship',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    public function ajaxUpdate(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'required|exists:variations,id',
                'unit_id' => 'exists:product_units,id',
                'variant_value' => 'required|string|max:255',
            ]);
            $validatedData['variation_id']=$validatedData['variant_id'];
            // Attempt to update the data
            $productToVariation = $this->productToVariationService->update($id, $validatedData);

            // If the update operation is successful, return a success response
            return response()->json([
                'success' => true,
                'message' => 'Product to variation relationship updated successfully',
                'data' => $productToVariation
            ], 200);
        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // If an error occurs during the update operation, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product to variation relationship',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function ajaxDelete($id)
    {
        try {
            // Attempt to delete the data
            $this->productToVariationService->delete($id);

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Product to variation relationship deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            // If an error occurs during the deletion operation, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product to variation relationship',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    public function ajaxGetAll(Request $request)
    {
        try {
            // Get all product to variation relationships
            $productToVariations = $this->productToVariationService->getAll();

            // Return a success response with the retrieved data
            return response()->json([
                'success' => true,
                'message' => 'All product to variation relationships retrieved successfully',
                'data' => $productToVariations
            ], 200);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve all product to variation relationships',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function ajaxGet(Request $request, $id)
    {
        try {
            // Get the product to variation relationship by ID
            $productToVariation = $this->productToVariationService->getById($id);

            // Return a success response with the retrieved data
            return response()->json([
                'success' => true,
                'message' => 'Product to variation relationship retrieved successfully',
                'data' => $productToVariation
            ], 200);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product to variation relationship',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function ajaxGetByProductId(Request $request)
    {
        try {
            // Get the product to variation relationships by product ID
            $productToVariations = $this->productToVariationService->getByProductId($request->product_id);

            // Return a success response with the retrieved data
            return response()->json([
                'success' => true,
                'message' => 'Product to variation relationships retrieved successfully',
                'data' => $productToVariations
            ], 200);
        } catch (\Exception $e) {
            // If an error occurs during the retrieval operation, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product to variation relationships',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

}

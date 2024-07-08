<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\StockResource;
use App\Models\Stock;
use App\Services\StockService;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    private $uploadService;
    private $stockService;
    /**
     * ProductController constructor.
     * @param UploadService $uploadService
     */
    public function __construct(StockService $stockService,UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
        $this->stockService = $stockService;
    }
    public function ajaxStore(Request $request){
        try {

            // Validate the request data
            $validatedData = $request->validate([
                'product_id' => 'required|exists:products,id',
                'combinations' => 'required|array',
                'combinations.*' => 'required|exists:product_to_variations,id',
                'price' => 'required|numeric',
                'quantity' => 'required|integer|min:1',
                'sku' => 'required|string|unique:stocks,sku',
                'auto_generate_sku' => 'nullable|in:on',
            ]);

            // Attempt to store the data
            $stock = $this->stockService->store($validatedData);
            if (isset($request['image']) && is_array($request['image'])) {
                foreach ($request['image'] as $fileUuid) {
                    $cacheUpload = $this->uploadService->getByUuid($fileUuid);
                    // dd($cacheUpload);
                    $mediaItem = $cacheUpload->getMedia('image')->first();
                    $mediaItem->copy($stock, 'image');

                }
            }

            // If the storage operation is successful, return a success response
            return response()->json([
                'success' => true,
                'message' => 'Stock stored successfully',
                'data' => $stock
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
                'message' => 'Failed to store stock',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    public function ajaxEdit($sku){
        try {
            $stock = $this->stockService->getBySku($sku,["productPrice","combinations"]);
            return response()->json([
                'success' => true,
                'message' => 'Stock fetched successfully',
                'data' => new StockResource($stock)
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetched stock',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    public function ajaxUpdate(Request $request,$sku){
        try {
            $validatedData = $request->validate([
                'product_id' => 'required|exists:products,id',
                'sku' => 'required|string|exists:stocks,sku',
            ]);
            $stock = $this->stockService->update($request->all(),$sku);
            return response()->json([
                'success' => true,
                'message' => 'Stock updated successfully',
                'data' => $stock
            ], 200);
        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return response()->json([
                'success' => false,
                'message' => 'Validation error, please check inputs.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // If an error occurs during the storage operation, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    public function ajaxGet(Request $request){
        try {
            $stocks = $this->stockService->getStocksByProductId($request->product_id,["productPrice","combinations"]);
            return response()->json([
                'success' => true,
                'message' => 'Stock fetched successfully',
                'data' => $stocks
            ], 200);
        } catch (\Exception $e) {
            // If an error occurs during the storage operation, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetched stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function ajaxSetDefaultSKU(Request $request){
        try {
            $validatedData = $request->validate([
                'product_id' => 'required|exists:products,id',
                'sku' => 'required|string|exists:stocks,sku',
            ]);
            $stock = $this->stockService->setDefaultSKU($request->sku,$request->product_id);
            return response()->json([
                'success' => true,
                'message' => 'Default stock set successfully',
                'data' => $stock
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
                'message' => 'Failed to set default stock',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        try {
            $salon = Stock::find($input['id']);
            if ($salon->hasMedia($input['collection'])) {
                $salon->getFirstMedia($input['collection'])->delete();
            }
            $this->response(200,'success','Media removed',1);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->response(400,'error','Failed to remove media',0);
        }
    }
}

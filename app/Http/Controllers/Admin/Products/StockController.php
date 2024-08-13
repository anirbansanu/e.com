<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\Stocks\SetDefaultSKURequest;
use App\Http\Requests\Products\Stocks\StoreStockRequest;
use App\Http\Requests\Products\Stocks\UpdateStockRequest;
use App\Http\Resources\Product\StockResource;
use App\Models\Stock;
use App\Services\Products\StockService;
use App\Services\Medias\UploadService;
use App\Services\Products\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    private $productService;
    private $uploadService;
    private $stockService;

    /**
     * ProductController constructor.
     * @param UploadService $uploadService
     */
    public function __construct(ProductService $productService,StockService $stockService,UploadService $uploadService)
    {
        $this->productService = $productService;
        $this->uploadService = $uploadService;
        $this->stockService = $stockService;
    }
    public function store(StoreStockRequest $request){
        try {

            $validatedData = $request->validated();
            $stock = $this->stockService->store($validatedData);

            if (isset($request['image']) && is_array($request['image'])) {
                foreach ($request['image'] as $fileUuid) {
                    $cacheUpload = $this->uploadService->getByUuid($fileUuid);
                    // dd($cacheUpload);
                    $mediaItem = $cacheUpload->getMedia('image')->first();
                    $mediaItem->copy($stock, 'image');

                }
            }

            return $this->response(200, 'Stock stored successfully', new StockResource($stock), null);
        } catch (ValidationException $e) {
            return $this->response(422, 'Validation error', [], $e->errors());
        } catch (\Exception $e) {
            return $this->response(500, 'Failed to store stock', [], $e->getMessage());
        }
    }
    public function show($sku){
        try {
            $stock = $this->stockService->getBySku($sku,["productPrice","combinations"]);
            return $this->response(200, 'Stock fetched successfully', new StockResource($stock), null);
        }catch (\Exception $e) {
            return $this->response(500, 'Failed to fetch stock', [], $e->getMessage());
        }
    }
    public function update(UpdateStockRequest $request, $sku){
        try {
            $stock = $this->stockService->update($request->all(), $sku);
            return $this->response(200, 'Stock updated successfully', new StockResource($stock), null);

        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return $this->response(422, 'Validation error, please check inputs.', [], $e->errors());

        } catch (\Exception $e) {
            // If an error occurs during the storage operation, return an error response
            return $this->response(500, 'Failed to update stock', [], $e->getMessage());

        }
    }
    public function getByProduct(Request $request,$slug){
        try {

            $product = $this->productService->getBySlug($slug);
            if($product)
            {
                $stocks = $this->stockService->getStocksByProduct($request, $product->id,["combinations"]);
                $current_page = $stocks->currentPage(); // Current page number
                $last_page = $stocks->lastPage(); // Total number of pages
                return $this->response(200, 'Stock fetched successfully', StockResource::collection($stocks), [],[],["current_page"=>$current_page,"last_page"=>$last_page,"request"=>$request->all()]);
            }
            else
            {
                return $this->response(404, 'Product not found', [],'Failed to retrieve product');
            }

        } catch (\Exception $e) {
            // If an error occurs during the storage operation, return an error response
            return $this->response(500, 'Failed to fetch stock', [], $e->getMessage());

        }
    }
    public function setDefaultSKU(SetDefaultSKURequest $request)
    {
        try {
            $stock = $this->stockService->setDefaultSKU($request->sku, $request->product_id);
            return $this->response(200, 'Default stock set successfully', new StockResource($stock), null);
        } catch (ValidationException $e) {
            // If validation fails, return a response with validation error messages
            return $this->response(422, 'Validation error', [], $e->errors());
        } catch (\Exception $e) {
            // If an error occurs during the update operation, return an error response
            return $this->response(500, 'Failed to set default stock', [], $e->getMessage());
        }
    }

    public function removeMedia(Request $request)
    {
        $input = $request->all();
        try {
            $stock = Stock::find($input['id']);
            if ($stock->hasMedia($input['collection'])) {
                $stock->getFirstMedia($input['collection'])->delete();
            }
            return $this->response(200, 'Media removed successfully', [], null);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->response(400, 'Failed to remove media', [], $e->getMessage());
        }
    }
}

<?php

namespace App\Services\Products;

use App\Models\Combination;
use App\Models\Price;
use App\Models\Product;
use App\Models\Stock;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class StockService.
 */
class StockService
{
    public function store($data)
    {

        // Use DB transaction closure for better readability and error handling
        return DB::transaction(function () use ($data) {
            // Create the stock record
            $stock = Stock::create([
                'product_id' => $data['product_id'],
                'sku' => $data['sku'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
            ]);

            // Create the combinations using the belongsToMany relationship
            $combinations = [];
            foreach ($data['combinations'] as $combinationId) {
                $combinations[$combinationId] = []; // You can add any pivot table data here if needed
            }

            // Attach combinations to the stock
            $stock->combinations()->attach($combinations);

            return $stock;
        });


    }

     /**
     * Get all stocks by product ID.
     *
     * @param int $product_id
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getStocksByProduct($request,$productId, array $relations = [])
    {
        $search = $request->input('search');
        $sort_by = $request->input('sort_by', 'updated_at');
        $sort_order = $request->input('sort_order', 'desc');
        $entries = $request->input('entries', config('app.pagination_limit'));
        if($sort_by == "" )
        {
            $sort_by = "updated_at";
            $sort_order = "desc";
        }
        return Stock::with($relations)->where('product_id', $productId)
        ->where(function ($q) use ($search) {
            $q->where('price', 'like', '%' . $search . '%')
                ->orWhere('sku', 'like', '%' . $search . '%')
                ->orWhere('quantity', 'like', '%' . $search . '%');
        })
        ->orderBy($sort_by, $sort_order)
        ->paginate($entries);
    }

    /**
     * Get a product by its ID with optional relations.
     *
     * @param int $id
     * @param array $relations
     * @return Product
     */
    public function getProductById(int $id, array $relations = []): Product
    {
        $query = count($relations) > 0 ? Product::with($relations) : new Product;
        return $query->findOrFail($id);
    }

    /**
     * Set a specific SKU as the default for a product.
     *
     * @param string $sku
     * @param int $product_id
     * @return int
     */
    public function setDefaultSKU(string $sku, int $product_id): int
    {
        // Set all stocks for the product to not default
        Stock::where('product_id', $product_id)->update(['is_default' => 0]);

        // Set the specified SKU as default
        return Stock::where('sku', $sku)->where('product_id', $product_id)->update(['is_default' => 1]);
    }

    /**
     * Get stock by its SKU with optional relations.
     *
     * @param string $sku
     * @param array $relations
     * @return Stock
     * @throws Exception
     */
    public function getBySku(string $sku, array $relations = []): Stock
    {
        $stock = Stock::with($relations)->where('sku', $sku)->first();

        if (!$stock) {
            throw new Exception("Stock with SKU $sku not found.");
        }

        return $stock;
    }

    /**
     * Update stock and its combinations by SKU.
     *
     * @param array $data
     * @param string $sku
     * @return Stock
     * @throws Exception
    */
    public function update($data,$sku)
    {
        return DB::transaction(function () use ($data, $sku) {
            // Get the existing stock record
            $stock = $this->getBySku($sku);
            if (!$stock) {
                throw new Exception("Stock with SKU $sku not found.");
            }

            $stock->update([
                'sku' => $data['sku'],
                'price' => $data['price'],
                'quantity' => $data['quantity'],
            ]);

            // Prepare combinations for syncing
            $combinations = [];
            foreach ($data['combinations'] as $combinationId) {
                $combinations[$combinationId] = [];
            }

            // Sync the combinations using the belongsToMany relationship
            $stock->combinations()->sync($combinations);

            return $stock;
        });

    }

    /**
     * Get stock by its ID with optional relations.
     *
     * @param int $id
     * @param array $relations
     * @return Stock
     */
    public function getStockById($id,$relations=[]){
        $query = count($relations) > 0 ? Stock::with($relations) : new Stock;
        return $query->findOrFail($id);
    }

    /**
     * Delete stock by its ID.
     *
     * @param int $id
     * @return Stock
     */
    public function delete($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return $stock;
    }

    /**
     * Delete stock by its SKU.
     *
     * @param string $sku
     * @return void
     */
    public function deleteBySku($sku)
    {
        $query = Stock::where('sku', $sku);
        // Additional condition for vendor role
        if (auth()->user()->hasRole("vendor")) {
            $query->where("added_by", auth()->id());
        }

        $query->delete();
    }
}

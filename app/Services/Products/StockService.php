<?php

namespace App\Services\Products;

use App\Models\Combination;
use App\Models\Price;
use App\Models\Product;
use App\Models\Stock;
use Exception;

/**
 * Class StockService.
 */
class StockService
{
    public function store($data)
    {

        // SKU
        $sku = $data['sku'];

        // Create price
        $price = Price::create([
            'price' => $data['price'],
        ]);
        // Create stock
        $stock = Stock::create([
            'product_id' => $data["product_id"],
            'sku' => $sku,
            'quantity' => $data['quantity'],
            'product_price_id' => $price->id
        ]);
        $stock->save();

        // Create combination
        foreach ($data['combinations'] as $key => $value) {

            // Create combination
            $combinationData = [
                'product_to_variation_id' => $value,
                'stock_id' => $stock->id,
            ];

            Combination::create($combinationData);
        }

        return $stock;
    }

    public function getStocksByProductId($product_id,$relations=[]){
        return $stock = Stock::with($relations)->where('product_id',$product_id)->get();
    }
    public function getProductById($id,$relations=[]){
        if(count($relations)>0)
        $p = Product::with($relations);
        else
        $p = new Product;
        $p = $p->findOrFail($id);
        return $p;
    }
    public function setDefaultSKU($sku, $product_id)
    {
        // Set all stocks for the product to not default
        Stock::where('product_id', $product_id)->update(['is_default' => 0]);

        // Set the specified SKU as default
        $setDefault = Stock::where('sku', $sku)->where('product_id', $product_id)->update(['is_default' => 1]);

        // Return the number of updated records
        return $setDefault;
    }
    public function getBySku($sku,$relations=[]){
        $stock = Stock::with($relations)->where('sku', $sku)->first();
        if (!$stock) {
            throw new Exception("Stock with SKU $sku not found.");
        }
        return $stock;
    }
    public function update($data,$sku)
    {
        // Get the existing stock record
        $stock = $this->getBySku($sku);
        if (!$stock) {
            // If the stock doesn't exist, return null
            throw new Exception("Stock with SKU $sku not found.");
        }
        // Update the price
        $stock = Stock::with('productPrice')->find($stock->id);
        $stock->productPrice->update(['price' => $data['price']]);

        // Update the stock
        $stock->update([
            'sku' => $data['sku'],
            'quantity' => $data['quantity'],
        ]);

        // Update or create combinations
        $combinationIds = [];
        foreach ($data['combinations'] as $combination) {
            $combinationData = [
                'product_to_variation_id' => $combination,
                'stock_id' => $stock->id,
            ];

            // Update or create combination
            $existingCombination = Combination::where('product_to_variation_id', $combination)
                                            ->where('stock_id', $stock->id)
                                            ->first();

            if ($existingCombination) {
                $existingCombination->update($combinationData);
                $combinationIds[] = $existingCombination->id;
            } else {
                $newCombination = Combination::create($combinationData);
                $combinationIds[] = $newCombination->id;
            }
        }

        return $stock;
    }
    public function getStockById($id,$relations=[]){
        if(count($relations)>0)
        $p = Stock::with($relations);
        else
        $p = new Stock;
        $p = $p->findOrFail($id);
        return $p;
    }
    public function delete($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return $stock;
    }
    public function deleteBySku($sku)
    {
        $stock = Stock::where('sku', $sku);
        if(auth()->user()->hasRole("vendor"))
        $stock = $stock->where("added_by",auth()->id());
        $stock->delete();

        return $stock;
    }
}

<?php

namespace App\Services;

use App\Models\ProductVariant;

class ProductVariantService
{
    public function create($data)
    {
        return ProductVariant::create($data);
    }

    public function update($id, $data)
    {
        $productVariation = ProductVariant::findOrFail($id);
        $productVariation->fill($data);
        $productVariation->save();

        return $productVariation;
    }

    public function delete($id)
    {

        $productVariation = ProductVariant::findOrFail($id);
        $productVariation->delete();

        return $productVariation;
    }

    public function getById($id)
    {
        return ProductVariant::findOrFail($id);
    }

    public function getByProductId($productId)
    {
        return ProductVariant::where('product_id', $productId)->get();
    }
    public function getByVariationId($variationId)
    {
        return ProductVariant::where('variation_id', $variationId)->get();
    }

    public function getByProductIdAndVariationId($productId, $variationId)
    {
        return ProductVariant::where('product_id', $productId)
            ->where('variation_id', $variationId)
            ->first();
    }

    public function deleteByProductId($productId)
    {
        return ProductVariant::where('product_id', $productId)->delete();
    }
    public function getAll()
    {
        return ProductVariant::all();
    }

    public function getByUnitId($unitId)
    {
        return ProductVariant::where('unit_id', $unitId)->get();
    }

    public function getByVariantValue($variantValue)
    {
        return ProductVariant::where('variant_value', $variantValue)->get();
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        return ProductVariant::updateOrCreate($attributes, $values);
    }
}

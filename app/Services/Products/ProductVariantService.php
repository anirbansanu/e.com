<?php

namespace App\Services\Products;

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

    public function getByProductId($request,$productId)
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

        return ProductVariant::where('product_id', $productId)
        ->where(function ($q) use ($search) {
            $q->where('attribute_name', 'like', '%' . $search . '%')
                ->orWhere('unit_name', 'like', '%' . $search . '%')
                ->orWhere('attribute_value', 'like', '%' . $search . '%');
        })
        ->orderBy($sort_by, $sort_order)
        ->paginate($entries);
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

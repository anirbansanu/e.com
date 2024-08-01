<?php

namespace App\Http\Requests\Products\Stocks;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'combinations' => 'required|array',
            'combinations.*' => 'required|exists:product_to_variations,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'sku' => 'required|string|unique:stocks,sku',
            'auto_generate_sku' => 'nullable|in:on',
        ];
    }
}

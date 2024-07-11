<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:product_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'gender' => 'required|string|in:Male,Female,Male & Female',
            'feature' => 'nullable|string|max:255',
            'is_active' => 'in:on',
        ];
    }
}

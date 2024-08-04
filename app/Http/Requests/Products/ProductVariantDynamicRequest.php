<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantDynamicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Change this if you need authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'with' => 'array',
            'with.*' => 'string|in:product', // specify allowed relations
            'where' => 'array',
            'where.*' => 'string',
            'group_by' => 'array',
            'group_by.*' => 'string',
            'having_clause' => 'string|nullable',
            'search' => 'string|nullable',
            'sort_by' => 'string|in:created_at,updated_at,attribute_name', // specify allowed sort fields
            'sort_order' => 'string|in:asc,desc',
            'entries' => 'integer|min:1|max:100',
        ];
    }
}

<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Change as per your authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name',
            'perm' => 'required|array',
        ];
    }
}

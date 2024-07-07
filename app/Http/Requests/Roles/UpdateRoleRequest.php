<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change as per your authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'perm' => 'required|array',
        ];
    }
}

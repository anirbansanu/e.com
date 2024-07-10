<?php

namespace App\Http\Requests\Permissions;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'name' => 'required_if:enable_bulk_update,false|max:255|unique:permissions,name,' . ($this->permission ? $this->permission->id : ''),
            'permission_names' => 'required_if:enable_bulk_update,true',
            'roles' => 'array',
            'guard_name' => 'required|string|max:255',
            'group_name' => 'required|string|max:255',
            'group_order' => 'required|integer',
        ];
    }
}

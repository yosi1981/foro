<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class NewRoleRequest extends Request {

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
            'name'                  => 'required|unique:roles,name,' . @$this->route('role')->id,
            'display_name'          => 'required',
            'description'           => 'max:150',
            'copy_permissions_role' => 'valid_role:allow_none',
        ];
    }
}
<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class NewPermissionRequest extends Request {

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
            'name'                   => 'required|alpha_dash',
            'display_name'           => 'required|max:255',
            'description'            => 'max:255',
            'order'                  => 'numeric',
            'permission_settings_id' => 'required|valid_permission_settings',
        ];
    }
}

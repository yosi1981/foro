<?php

namespace App\Http\Requests\Admin;

use App\Core;
use App\Http\Requests\Request;
use App\User\Role;

class NewUserCreateSettingsRequest extends Request {

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
            'username'     => site('user-validation-username') . '|unique:users,username',
            'email'        => site('user-validation-email') . '|unique:users,email',
            'password'     => site('user-validation-password'),
            'primary_role' => 'required|valid_role',
            'roles' => 'valid_role:allow_multiple',
        ];
    }
}

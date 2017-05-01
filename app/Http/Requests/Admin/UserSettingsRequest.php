<?php

namespace App\Http\Requests\Admin;

use App\Core\Core;
use App\Http\Requests\Request;

class UserSettingsRequest extends Request {

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
            'username'         => site('user-validation-username') . '|unique:users,username,' . $this->route('user')->id,
            'email'            => site('user-validation-email') . '|unique:users,email,' . $this->route('user')->id,
            'about_me'         => site('user-validation-about-me'),
            'primary_role'     => 'required|valid_role',
            'roles'            => 'valid_role:allow_multiple',
            'per_page_threads' => 'numeric|in:' . implode(Core::per_page(), ','),
            'per_page_posts'   => 'numeric|in:' . implode(Core::per_page(), ','),
            'timezone'         => 'required|timezone',
            'password'     => site('user-validation-password'),
        ];
    }
}

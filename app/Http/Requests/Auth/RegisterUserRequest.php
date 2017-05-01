<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class RegisterUserRequest extends Request {

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
            'username' => site('user-validation-username') . '|unique:users,username',
            'email'    => site('user-validation-email') . '|unique:users,email',
            'timezone' => 'required|timezone',
            'password' => site('user-validation-password'),
            'terms'    => 'accepted',
        ];
    }
}

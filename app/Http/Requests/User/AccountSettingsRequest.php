<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class AccountSettingsRequest extends Request {

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
        $rules = [
            'current_password' => 'min:6|required_with:password',
            'password'         => site('user-validation-password'),
        ];

        if (user()->can('editUsername', user())) {
            $rules['username'] = 'required|min:3|max:15|unique:users,username,' . user()->id;
        }
        if (user()->can('editEmail', user())) {
            $rules['email'] = 'required|email|unique:users,email,' . user()->id;
        }

        return $rules;

    }
}

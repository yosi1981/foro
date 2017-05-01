<?php

namespace App\Http\Requests\Mod;

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
        $rules = [];
        if (user()->can('moderateEditAccountInfo', user())) {
            $rules = [
                'username' => site('user-validation-username') . '|unique:users,username,' . $this->route('user')->id,
                'email'    => site('user-validation-email') . '|unique:users,email,' . $this->route('user')->id,
            ];
        }
        if (user()->can('moderateEditGeneralInfo', user())) {
            $rules += [
                'about_me' => site('user-validation-about-me'),
                'timezone' => 'required|timezone',
            ];
        }
        return $rules;
    }
}

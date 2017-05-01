<?php

namespace App\Http\Requests\Mod;

use App\Http\Requests\Request;

class BanUserRequest extends Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'length' => 'required_unless:length,custom',
            'custom' => 'required_if:length,custom',
            'reason' => 'required:min:3:max:255',
        ];
    }
}

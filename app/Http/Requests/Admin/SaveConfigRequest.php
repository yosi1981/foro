<?php

namespace App\Http\Requests\Admin;

use App\Core\Setting;
use App\Http\Requests\Request;

class SaveConfigRequest extends Request {

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
        foreach ($this->request->all() as $key => $request) {
            $setting = Setting::where('name', $key)->first();
            if ($setting) {
                $rules[$setting->name] = $setting->validationRules();
            }
        }
        return $rules;
    }

}

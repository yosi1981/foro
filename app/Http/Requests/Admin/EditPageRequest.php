<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class EditPageRequest extends Request {

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
            'slug'  => 'required|alpha_dash|unique:pages,slug,' . request()->route('page')->id,
            'title' => 'required|max:255',
            'body'  => 'required',
        ];
    }
}

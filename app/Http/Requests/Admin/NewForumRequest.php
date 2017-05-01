<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class NewForumRequest extends Request {

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
        $not_in_validation = request()->route('forum') ? '|not_in:'. request()->route('forum')->id : '';
        return [
            'name'              => 'required|max:175',
            'description'       => 'max:500',
            'parent_forum'      => 'required|valid_forum:allow_none'. $not_in_validation,
            'visible'           => 'boolean',
            'closed'            => 'boolean',
            'allow_new_threads' => 'boolean',
            'enable_rules'      => 'boolean',
            'rules_title'       => 'required_if:enable_rules,1',
            'rules_description' => 'required_if:enable_rules,1',
        ];
    }
}

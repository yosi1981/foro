<?php

namespace App\Http\Requests\User;

use App\Core\Core;
use App\Http\Requests\Request;

class ForumSettingsRequest extends Request {

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
            'per_page_posts' => 'required|numeric|in:' . implode(Core::per_page(), ','),
            'per_page_threads' => 'required|numeric|in:' . implode(Core::per_page(), ','),
            'signature' => sprintf('max:%s|min:%s', site('signature-max-characters'), site('signature-min-characters'))
        ];
    }
}

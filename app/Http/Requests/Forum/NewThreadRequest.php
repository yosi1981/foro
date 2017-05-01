<?php

namespace App\Http\Requests\Forum;

use App\Forum\Forum;
use App\Http\Requests\Request;

class NewThreadRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        if (user()->can('createThread', Forum::findOrFail($this->get('forum')))) {
            return true;
        }
        abort(403);
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'title'   => site('thread-validation-title'),
            'message' => site('thread-validation-body'),
        ];
    }
}

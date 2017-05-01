<?php

namespace App\Http\Requests\Forum;

use App\Http\Requests\Request;

class PostReplyRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (user()->cannot('postReply', $this->route('thread')))
            abort(403, trans('forum.thread.cannot_reply'));
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
            'message' => site('thread-validation-body'),
        ];
    }
}

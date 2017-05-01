<?php

namespace App\Http\Requests\Forum;

use App\Http\Requests\Request;

class EditPostRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (user()->can('editPost', $this->route('post')))
            return true;
        return abort(403);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $title_validation = site('thread-validation-title');
        // If there is a title, validate accordingly.
        $title = ($this->route('post')->isFirstPost() && user()->can('editThread', $this->route('post')->thread))
            ? $title_validation
            : str_replace('required', '', $title_validation);
        return [
            'message' => site('thread-validation-body'),
            'title'   => $title,
        ];
    }
}

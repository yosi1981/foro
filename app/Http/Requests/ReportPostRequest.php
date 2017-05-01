<?php

namespace App\Http\Requests;

use App\Forum\ReportedPost;
use App\Http\Requests\Request;

class ReportPostRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (user()->can('forum-report-post')) {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reason'       => 'required_without:other-reason|in:' . implode(",", ReportedPost::reasons()),
            'other_reason' => 'required_if:reason,Other|min:5',
        ];
    }

    public function messages()
    {
        return [
            'other_reason.required_if' => trans('forum.report.valid_reason_specify'),
            'reason.required_without'  => trans('forum.report.valid_reason_specify'),
        ];
    }

    public function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        return $url->previous() . '#report';
    }
}

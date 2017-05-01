@include('layouts.errors',
[
    'error_code'        => 404,
    'error_title'       => trans('site.errors.404.title'),
    'error_description' =>  trans('site.errors.404.desc'),
])
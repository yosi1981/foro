@include('layouts.errors',
[
    'error_code'        => 500,
    'error_title'       => trans('site.errors.500.title'),
    'error_description' =>  trans('site.errors.500.desc'),
])
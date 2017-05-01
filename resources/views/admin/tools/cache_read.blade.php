{{ trans('admin.tools.cache.name') }}: <code>{{ $identifier }}</code>
<div class="margin-top-10">
    <pre>@if ($cache){{ print_r($cache, true) }}@else {{ trans('admin.tools.cache.not_found') }} @endif</pre>
</div>
@if ($forum->hasRules('create'))
    <b>{{ $forum->rules_title }}</b>
    <span class="help-block">
        {!! nl2br(e($forum->rules_description)) !!}
    </span>
@endif
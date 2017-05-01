{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">{{ trans('site.name') }}</label>
            <div class="col-sm-10">
                <input value="{{ old('name', @$forum->name) }}" name="name" id="name" placeholder="{{ trans('site.name') }}" type="text" class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">{{ trans('site.description') }}</label>
            <div class="col-sm-10">
                <textarea rows="" name="description" id="description" placeholder="{{ trans('site.description') }}" class="form-control">{{ old('name', @$forum->description) }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="order">{{ trans('site.order') }}</label>
            <div class="col-sm-10">
                <input value="{{ old('order', @$forum->order) }}" name="order" id="order" type="number" class="form-control"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="order">{{ trans('forum.parent') }}</label>
            <div class="col-sm-10">
                {!! $select_input->name('parent_forum')->allowNone()->selected(@$forum->parent_id)->forums()->get() !!}
                <span class="help-block">
                    {{ trans('forum.parent_helper') }}
                </span>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="hidden" value="0" name="enable_rules">
                        <input value="1" @if(@$forum->enable_rules) checked="checked" @endif name="enable_rules" id="enable_rules" type="checkbox"/>
                        {{ trans('forum.rules.enable') }}
                    </label>
                </div>
            </div>
        </div>
        <div id="rules">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="rules_title">{{ trans('forum.rules.title') }}</label>
                <div class="col-sm-10">
                    <input value="{{ old('rules_title', @$forum->rules_title) }}" name="rules_title" id="rules_title" placeholder="{{ trans('forum.rules.title') }}" type="text" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="rules_description">{{ trans('forum.rules.description') }}</label>
                <div class="col-sm-10">
                    <textarea rows="" name="rules_description" id="rules_description" placeholder="{{ trans('forum.rules.description') }}" class="form-control">{{ old('rules_title', @$forum->rules_description) }}</textarea>
                    <span class="help-block">{{ trans('site.html_supported') }}</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input name="allow_new_threads" type="hidden" value="0">
                        {{-- Check the allow new threads checkbox by default.. Check if $forum is isset,
                        if not, check it because the user is creating a new thread not editing one... --}}
                        <input value="1" @if(@$forum->allow_new_threads || !isset($forum)) checked="checked" @endif name="allow_new_threads" type="checkbox"/>
                        {{ trans('forum.allow_new') }}
                    </label>
                </div>
            </div>
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input name="closed" type="hidden" value="0">
                        <input value="1" @if(@$forum->closed) checked="checked" @endif name="closed" type="checkbox"/>
                        {{ trans('forum.close') }}
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        checkboxHideElement($('#enable_rules'), $('#rules'));
    </script>
@endpush
<div class="form-group">
    <label class="col-sm-2 control-label" for="avatar">{{ trans('user.avatar.url') }}</label>
    <div class="col-sm-10">
        <input value="{{ old('avatar', $member->avatar) }}" name="avatar" id="avatar" placeholder="{{ trans('user.avatar.desc') }}" type="text" class="form-control"/>
    </div>
</div>

{{-- Timezone field --}}
<div class="form-group">
    <label class="col-sm-2 control-label" for="timezone">{{ trans('user.timezone') }}</label>
    <div class="col-sm-10">
        {!! (new \App\Timezone())->dropdownMenu($member->timezone) !!}
    </div>
</div>

@can('editAboutMe')
{{-- About me field --}}
<div class="form-group">
    <label class="col-sm-2 control-label" for="about_me">{{ trans('user.about_me') }}</label>
    <div class="col-sm-10">
        <textarea rows="2" name="about_me" id="about_me" placeholder="{{ trans('user.about_me') }}" class="form-control">{{ old('about_me', $member->about_me) }}</textarea>
    </div>
</div>
@endcan
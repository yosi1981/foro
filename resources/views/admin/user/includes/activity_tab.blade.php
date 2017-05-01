<strong><i class="fa fa-user margin-r-5"></i>
    {{ trans_choice('user.role.label', 2) }}
</strong>

<div class="margin-top-10 margin-bottom-10">{{ trans('user.role.primary') }}:
    <b>{{ $member->primaryRole->display_name or strtoupper(trans('site.none')) }}</b>
</div>

{{--View additional roles--}}
{{ trans('user.role.additional') }}:
@if (count($member->additionalRoles))
    <ul>
        @foreach ($member->additionalRoles as $role)
            <li>
                <a href="{{ route('admin.role.show', $role->name) }}">{{ $role->display_name }}</a>
            </li>
        @endforeach
    </ul>
@else
    <span class="text-muted">{{ trans('site.none') }}</span>
@endif

{{-- If user has signature show it --}}
@if ($member->hasSignature())
    <hr>
    <strong><i class="fa fa-font margin-r-5"></i>
        {{ trans('user.signature.label') }}
    </strong>
    <p>{!! $member->signature !!}</p>
@endif
<hr>

{{-- View user's about me --}}
<strong><i class="fa fa-file-text-o margin-r-5"></i> {{ trans('user.about_me') }}
</strong>
<p class="text-muted">
    {{ $member->about_me or trans('site.n_a') }}
</p>

<hr>
{{-- Activate User and Confirm Email --}}

<div class="checkbox">
    <label for="email_verify" class=text-normal>

        <input {{ $user->emailVerified() ? 'disabled="disabled checked="checked"' : '' }} value="1" type="checkbox" name="email_verify" id="email_verify">
        {{ trans('admin.user.email.verify') }}
        @if ($user->emailVerified())
            <span class="help-block">{{ trans('admin.user.email.verified') }}</span>
        @endif

    </label>
</div>

<div class="checkbox">
    <label for="activate" class=text-normal>
        <input type="hidden" value="0" name="activate">
        <input value="1" {{ $user->activated ? 'checked="checked"' : '' }} type="checkbox" name="activate" id="activate"> {{ trans('admin.user.activate_account') }}
    </label>
</div>
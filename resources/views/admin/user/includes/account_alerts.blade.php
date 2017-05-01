@if (!$user->primaryRole)
    <div class="callout callout-danger margin-bottom-10">
        {{ trans('user.role.primary_not_found') }}
    </div>
@endif
@if (!$user->emailVerified())
    <div class="callout callout-warning margin-bottom-10">
        {{ trans('admin.user.email.not_verified') }}
    </div>
@endif
@if (!$user->activated)
    <div class="callout callout-warning margin-bottom-10">
        {{ trans('admin.user.deactivated') }}
    </div>
@endif
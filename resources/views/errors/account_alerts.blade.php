@if (@$signed_in)
    @if ($user->isBanned())
        <div class="callout callout-warning margin-bottom-0 margin-top-10">
            {{ trans('user.alert.banned', ['date' => $user->ban->expires_at ]) }}
            <br>
            {{ trans('mod.banned.reason') }}: {{ $user->ban->reason }}
        </div>
    @endif
    @if ($user->hasPrivateAnnouncement())
        <div class="callout callout-info margin-bottom-0 margin-top-10">
            <b>{{ trans('mod.user.private_announcement.label') }}:</b>
            {!! Core::purifyHTML($user->private_announcement) !!}
        </div>
    @endif
    {{-- If forum is not enabled but user can still access --}}
    @if ($user->isAdmin() && !site('forum-enable'))
        @if (Route::getCurrentRoute()->getPrefix() == '/'. site('forum-prefix'))
            <div class="callout callout-warning margin-bottom-0 margin-top-10">
                <b>{{ trans('site.please_note') }}</b>
                {{ trans('forum.not_enabled_but_access') }}
            </div>
        @endif
    @endif
@endif
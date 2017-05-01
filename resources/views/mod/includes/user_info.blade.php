<div class="mod-user-info">
    <div class="row">
        <div class="col-md-3 col-lg-3 text-center">
            <p class="padding-10">
                <img style="" alt="{{ trans('user.avatar.label') }}" src="{{ $member->avatar }}" class="img-circle img-responsive">
            </p>

            {{ trans('user.role.primary') }}

            <div class="bold">
                @if ($member->primaryRole)
                    {!! $member->primaryRole->info !!}
                @else
                    <span class="help-block"> {{  trans('site.none') }}</span>
                @endif
            </div>
            @if (count($member->roles) > 0)
                <hr>
                {{ trans('user.role.other') }}
                <div class="bold">
                    @foreach ($member->roles as $role)
                        <ul class="list-unstyled">
                            <li>{!! $role->info !!}</li>
                        </ul>
                    @endforeach
                </div>
            @endif

        </div>
        <div class=" col-md-9 col-lg-9">
            <table class="table table-user-information">
                <tbody>
                <tr>
                    <td>{{ trans('user.id') }}</td>
                    <td>{{ $member->id }}</td>
                </tr>
                <tr>
                    <td>{{ trans('user.username.label') }}</td>
                    <td>{{ $member->username }}</td>
                </tr>
                <tr>
                    <td>{{ trans('user.email.label') }}</td>
                    <td>{{ $member->email }}</td>
                </tr>
                <tr>
                    <td>{{ trans('user.about_me') }}</td>
                    <td>{{ $member->about_me }}</td>
                </tr>
                <tr>
                    <td>{{ trans('user.last_active') }}</td>
                    <td>{{ $member->active_at }}</td>
                </tr>
                <tr>
                    <td>{{ trans('user.registered') }}</td>
                    <td>{{ $member->created_at  }}</td>
                </tr>
                <tr>
                    <td>{{ trans('user.status') }}</td>
                    <td>{{ $member->status }}</td>
                </tr>
                <tr>
                    <td>{{ trans('admin.user.ip.registration') }}</td>
                    <td>{{ $member->registration_ip_address }}</td>
                </tr>
                </tbody>
            </table>

            <div class="padding-10">
                <a href="{{ $member->profileUrl() }}" class="btn btn-default">
                    <i class="fa fa-user"></i>
                    {{ trans('user.view_profile') }}
                </a>
                <a href="{{ route('mod.user.edit', $member->info) }}" class="btn btn-success">
                    <i class="fa fa-pencil"></i>
                    {{ trans('user.edit') }}
                </a>
                <a href="{{ route('mod.banned.create', ['user' => $member->info]) }}" class="btn btn-danger">
                    <i class="fa fa-ban"></i>
                    {{ trans('mod.banned.ban') }}
                </a>
            </div>
        </div>
    </div>
</div>
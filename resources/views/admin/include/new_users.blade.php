<div class="box box-danger">

    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('user.latest') }}</h3>
    </div>

    <div class="box-body no-padding">
        <ul class="users-list clearfix">
            @foreach ($new_users as $new_user)
                <li>
                    <img width="50px" src="{{ $new_user->avatar }}" alt="{{ trans('user.avatar.label') }}">
                    <a class="users-list-name" href="#">{{ $new_user->username }}</a>
                    <span class="users-list-date">{{ $new_user->created_at }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="box-footer text-center">
        <a href="{{ route('admin.user.index') }}" class="uppercase">{{ trans('user.all') }}</a>
    </div>

</div>
@include('errors.alert')

<div class="login-box-body">
    <h3 class="login-box-msg">{{ trans('site.auth.login') }}</h3>

    <form role="form" class="use-ajax" method="POST" action="{{ route('auth.login')  }}">

        {{ csrf_field() }}

        <div class="form-group has-feedback">
            <input name="username" type="text" class="form-control" placeholder="{{ trans('user.username.or_email') }}">
            <span class="fa fa-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <input name="password" type="password" class="form-control" placeholder="{{ trans('user.password.label') }}">
            <span class="fa fa-lock form-control-feedback"></span>
        </div>

        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox">
                    <label>
                        <input checked="checked" type="checkbox" name="remember"> {{ trans('site.auth.remember_me') }}
                    </label>
                </div>
            </div>

            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">
                    <i class="fa fa-arrow-circle-right"></i> {{ trans('site.auth.login') }}
                </button>
            </div>
        </div>

    </form>

    <a href="{{ route('auth.password.reset') }}">{{ trans('site.auth.forgot_password') }}</a>
    <br>
    <a href="{{ route('auth.register') }}" class="text-center">{{ trans('user.register.new_account') }}</a>

</div>
@extends('layouts.main')
@section('title', trans('site.auth.register'))
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('errors.alert')
                <div class="box box-flat">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('site.auth.register') }}</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal use-ajax" role="form" method="POST" action="{{ route('auth.register.post') }}">
                            {!! csrf_field() !!}

                            <span class="help-block col-md-offset-2">
                                {{ trans('user.settings.account') }}
                            </span>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="username">{{ trans('user.username.label') }}</label>
                                <div class="col-sm-10">
                                    <input value="{{ old('username') }}" name="username" id="username" placeholder="{{ trans('user.username.desc') }}" type="text" class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="email">{{ trans('user.email.label') }}</label>
                                <div class="col-sm-10">
                                    <input value="{{ old('email') }}" name="email" id="email" placeholder="{{ trans('user.email.desc') }}" type="text" class="form-control"/>
                                </div>
                            </div>

                            @include('user.account.includes.new_password_inputs')

                            <span class="help-block col-md-offset-2">
                                {{ trans('user.settings.general') }}
                            </span>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="timezone">{{ trans('user.timezone') }}</label>
                                <div class="col-sm-10">
                                    {!! (new \App\Timezone())->dropdownMenu() !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-offset-2 text-normal control-label">
                                    <input type="checkbox" name="terms" value="1">&nbsp {!! trans('user.register.accept_terms_conditions') !!}
                                </label>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="col-sm-offset-2 btn btn-primary">
                                    <i class="fa fa-user-plus"></i> {{ trans('site.auth.register') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

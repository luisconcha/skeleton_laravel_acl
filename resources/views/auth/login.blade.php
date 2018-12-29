@extends('layouts.admin.login')

@section('content-login')

    <div class="login-box">
        <div class="login-logo">
            {{ config('app.name', 'Skeleton-Laravel-ACL') }}
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ __('lacc.sign_in_to_start_your_session') }}</p>

            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('lacc.login') }}">
                @csrf
                <div class="form-group has-feedback">
                    <input id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" value="{{ old('email') }}" required autofocus
                           placeholder="{{ __('lacc.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback">
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           name="password" required placeholder="{{ __('lacc.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
                </span>
                    @endif

                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('lacc.remember_me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('lacc.login') }}
                        </button>
                    </div>
                </div>

            </form>

            <a href="{{ route('password.request') }}"> {{ __('lacc.forgot_your_password') }} </a> <br/>
            <a href="{{ route('register') }}" class="text-center">{{ __('lacc.register') }}</a>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection

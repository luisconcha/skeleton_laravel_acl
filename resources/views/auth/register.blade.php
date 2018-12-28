@extends('layouts.login')

@section('content-login')

    <div class="register-box">
        <div class="register-logo">
            {{ config('app.name', 'Skeleton-Laravel-ACL') }}
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">{{ __('lacc.register') }}</p>

            <form method="POST" action="{{ route('register') }}" aria-label="{{ __('lacc.register') }}">
                @csrf

                <div class="form-group has-feedback">
                    <input type="text" class="form-control{{ $errors-> has('name') ? ' is-invalid' : '' }}"
                           placeholder="{{ __('lacc.name') }}"
                           name="name" value="{{ old('name') }}" required autofocus>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback">
                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           placeholder="{{ __('lacc.email') }}"
                           name="email" value="{{ old('email') }}" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           placeholder="{{ __('lacc.password') }}"
                           name="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>


                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="{{ __('lacc.confirmation_password') }}"
                           id="password-confirm" name="password_confirmation" required>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="agree_to_the_terms"
                                   id="agree_to_the_terms" {{ old('agree_to_the_terms') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('lacc.i_agree_to_the_terms') }}
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-4">
                        <button type="submit"
                                class="btn btn-primary btn-block btn-flat"> {{ __('lacc.register') }}</button>
                    </div>
                </div>
                
            </form>

            <a href="{{ route('login') }}" class="text-center">{{ __('lacc.i_already_have_a_membership') }}</a>
        </div>

    </div>
@endsection

<?php
/**
 * File: form.blade.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 23/12/18
 * Time: 22:02
 * Project: laravel_bolao
 * Copyright: 2018
 */
?>


<div class="form-group col-md-6">
    <label for="name">{{ __('lacc.name') }}</label>
    <input type="text" name="name"
           placeholder="{{ __('lacc.name') }}"
           value="{{ old('name') ?? ($register->name ?? '') }}"
           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">

    @if ($errors->has('name'))
        <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
    @endif
</div>
<div class="form-group col-md-6">
    <label for="email">{{ __('lacc.email') }}</label>
    <input type="email" name="email"
           placeholder="{{ __('lacc.email') }}"
           value="{{ old('email') ?? ($register->email ?? '')}}"
           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}">

    @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
    @endif
</div>

<div class="form-group col-md-6">
    <label for="password">{{ __('lacc.password') }}</label>
    <input type="password" name="password" placeholder="{{ __('lacc.password') }}" value=""
           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">

    @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
    @endif
</div>
<div class="form-group col-md-6">
    <label for="password_confirmation">{{ __('lacc.confirmation_password') }}</label>
    <input type="password" name="password_confirmation" placeholder="{{ __('lacc.confirmation_password') }}"
           value=""
           class="form-control">
</div>

<div class="form-group col-md-12">
    <label for="roles">{{ __('lacc.role_list') }}</label>
    <select multiple name="roles[]" id="" class="form-control">
        @foreach($roles as $key => $value)
            @php
                $select = '';
                if(old('roles') ?? false){
                    foreach (old('roles') as $key => $id):
                        if($id == $value->id) {
                            $select = 'selected';
                        }
                    endforeach;
                }else{
                    if($register ?? false) {
                       foreach ($register->roles as $key => $role):
                            if($role->id == $value->id) {
                                $select = 'selected';
                            }
                       endforeach;
                    }
                }
            @endphp

            <option {{ $select }} value="{{ $value->id }}">{{ $value->name }}</option>
        @endforeach
    </select>
</div>


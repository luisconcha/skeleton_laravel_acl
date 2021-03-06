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
    <label for="description">{{ __('lacc.description') }}</label>
    <input type="text" name="description"
           placeholder="{{ __('lacc.name') }}"
           value="{{ old('description') ?? ($register->description ?? '') }}"
           class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">

    @if ($errors->has('description'))
        <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
    @endif
</div>
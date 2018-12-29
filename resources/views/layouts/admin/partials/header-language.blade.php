<?php
/**
 * File: header-language.blade.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 29/12/18
 * Time: 00:50
 * Project: skeleton_laravel_acl
 * Copyright: 2018
 */
?>

<li class="dropdown tasks-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-flag-o"></i>
        <span class="label label-danger">3</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">{{__('lacc.change_language')}}</li>
        <li>
            <ul class="menu">
                <li>
                    <a href="{{route('lang',['pt-br'])}}">
                        <h3>
                            {{ __('lacc.language_pt') }}
                            <small class="pull-right">Pt-BR</small>
                        </h3>
                    </a>
                </li>
                <li>
                    <a href="{{route('lang',['en'])}}">
                        <h3>
                            {{ __('lacc.language_en') }}
                            <small class="pull-right">EN</small>
                        </h3>
                    </a>
                </li>
                <li>
                    <a href="{{route('lang',['es'])}}">
                        <h3>
                            {{ __('lacc.language_es') }}
                            <small class="pull-right">ES</small>
                        </h3>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>

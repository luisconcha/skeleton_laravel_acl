<?php
/**
 * File: header-user.blade.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 29/12/18
 * Time: 00:51
 * Project: skeleton_laravel_acl
 * Copyright: 2018
 */
?>

<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="https://adminlte.io/themes/AdminLTE/dist/img/user2-160x160.jpg" class="user-image"
             alt="User Image">
        <span class="hidden-xs">{{ Auth::user()->name }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="user-header">
            <img src="https://adminlte.io/themes/AdminLTE/dist/img/user2-160x160.jpg"
                 class="img-circle" alt="User Image">

            <p>
                {{ Auth::user()->name }}
                <small>Member since Nov. {{ Auth::user()->created_at }}</small>
            </p>
        </li>

        <li class="user-footer">
            <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
                <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    {{ __('lacc.logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</li>

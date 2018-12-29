<?php
/**
 * File: header.blade.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 29/12/18
 * Time: 00:48
 * Project: skeleton_laravel_acl
 * Copyright: 2018
 */
?>

<header class="main-header">
    <a href="{{ route('home') }}" class="logo">
        {{ config('app.name', 'Laravel') }}
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                @include('layouts.admin.partials.header-user')

                @include('layouts.admin.partials.header-language')

            </ul>
        </div>
    </nav>
</header>

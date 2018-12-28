<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Skeleton-Laravel-ACL') }}</title>
    
    <link rel="stylesheet" href="http://localhost/AdminLTE/plugins/iCheck/square/blue.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="hold-transition skin-blue layout-top-nav">

<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ route('home') }}" class="navbar-brand">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">

                    <li class="dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('lacc.change_language')}}
                            <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu pr-4" role="menu">
                            <li><a class="dropdown-item"
                                   href="{{route('lang',['pt-br'])}}">{{ __('lacc.language_pt') }}</a>
                            </li>
                            <li><a class="dropdown-item"
                                   href="{{route('lang',['es'])}}">{{ __('lacc.language_es') }}</a>
                            </li>
                            <li><a class="dropdown-item"
                                   href="{{route('lang',['en'])}}">{{ __('lacc.language_en') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>

<div class="content-wrapper">
    <div class="container">

        <section class="content">
            <main class="py-4">
                @yield('content-login')
            </main>
        </section>

    </div>

</div>

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>

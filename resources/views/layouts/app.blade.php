<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Skeleton-Laravel-ACL') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
        {{ config('app.name', 'Laravel') }}
    </a>
    <nav class="navbar navbar-static-top">
        @guest
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <ul class="nav navbar-nav pull-right">
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('lacc.change_language')}} <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu pr-4" role="menu">
                        <li><a class="dropdown-item" href="{{route('lang',['pt-br'])}}">{{ __('lacc.language_pt') }}</a>
                        </li>
                        <li><a class="dropdown-item" href="{{route('lang',['es'])}}">{{ __('lacc.language_es') }}</a>
                        </li>
                        <li><a class="dropdown-item" href="{{route('lang',['en'])}}">{{ __('lacc.language_en') }}</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('login') }}">Login</a>
                </li>
            </ul>

        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Usuários</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('roles.index') }}">Papeis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('permissions.index') }}">Permissões</a>
            </li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
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
        @endguest
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</header>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>

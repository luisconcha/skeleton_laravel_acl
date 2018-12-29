<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Skeleton-Laravel-ACL') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="hold-transition skin-blue fixed sidebar-mini">

<div class="wrapper">

    @include('layouts.admin.partials.header')

    @include('layouts.admin.partials.sidebar')

    <div class="content-wrapper">
        {{--<section class="content-header">--}}
            {{--<h1>{{ __('lacc.dashboard') }}</h1>--}}
            {{--<ol class="breadcrumb">--}}
                {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
                {{--<li><a href="#">Layout</a></li>--}}
                {{--<li class="active">Fixed</li>--}}
            {{--</ol>--}}
        {{--</section>--}}

        <section class="content">

            @yield('content')

        </section>
    </div>

    @include('layouts.admin.partials.footer')

</div>


@yield('pre-script')

<script src="{{ asset('js/app.js') }}"></script>

@yield('pos-script')

</body>
</html>

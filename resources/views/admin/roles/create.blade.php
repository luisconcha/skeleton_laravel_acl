<?php
/**
 * Created by PhpStorm.
 * User: Luis Alberto Concha Curay
 * Date: 18/12/18
 * Time: 23:29
 */

?>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-{{ $col ?? 12  }}">
                <div class="card">
                    <div class="card-header">{{ $page  }}</div>

                    <div class="card-body">

                        @if (session('msg'))
                            <div class="alert alert-{{ session('status') }}" role="alert">
                                {{ session('msg') }}
                            </div>
                        @endif

                        @if($breadcrumb)

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">

                                    @foreach($breadcrumb as $key => $value)
                                        @if($value->url)
                                            <li class="breadcrumb-item"><a
                                                        href="{{route($value->url)}}">{{ $value->title }}</a></li>

                                        @else
                                            <li class="breadcrumb-item active"
                                                aria-current="page">{{ $value->title }}</li>
                                        @endif
                                    @endforeach
                                </ol>
                            </nav>

                        @endif

                        <form action="{{route('roles.store')}}" method="POST">
                            @csrf

                            @include('admin.'.$routeName.'.form')

                            <button class="btn btn-primary btn-lg float-right">{{ __('lacc.add') }}</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection

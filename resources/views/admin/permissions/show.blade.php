<?php
/**
 * Created by PhpStorm.
 * User: Luis Alberto Concha Curay
 * Date: 18/12/18
 * Time: 23:29
 */

?>

@extends('layouts.admin.app')

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


                        <p>{{ __('lacc.name') }}: {{ $register->name }}</p>
                        <p>{{ __('lacc.description') }}: {{ $register->description }}</p>
                        <p>{{ __('lacc.description') }}: {{ $register->description }}</p>
                        <p>{{ __('lacc.resource_description') }}: {{ $register->resource_name }}</p>


                        @if($delete)
                            <form action="{{ route($routeName.'.destroy', $register->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-lg float-left">{{ __('lacc.delete') }}</button>
                            </form>
                        @endif


                    </div>
                </div>
            </div>
        </div>
@endsection

<?php
/**
 * File: index.blade.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 30/12/18
 * Time: 00:43
 * Project: skeleton_laravel_acl
 * Copyright: 2018
 */
?>

@extends('layouts.admin.app')

@push('styles')
    <style type="text/css">
        table > thead > tr > th:nth-child(2) {
            width: 30%;
        }

        table > thead > tr > th:nth-child(4) {
            width: 10%;
        }
    </style>
@endpush

@section('content')

    @if (session('msg'))
        <div class="alert alert-{{ session('status') }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            {{ session('msg') }}
        </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div>
                        @if($breadcrumb)
                            <section class="content-header">
                                <h1>{{ $page }}</h1>
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
                            </section>

                        @endif
                    </div>
                </div>
                <div class="box-body">

                    <h1>Index Page RH</h1>
                </div>
            </div>

        </div>
    </div>

@endsection

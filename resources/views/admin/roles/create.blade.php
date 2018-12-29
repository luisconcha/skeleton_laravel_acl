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

    <div class="row">
        <div class="col-md-{{ $col ?? 12  }}">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $page  }}</h3>
                </div>

                @if (session('msg'))
                    <div class="alert alert-{{ session('status') }} alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
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


                <form action="{{route('roles.store')}}" method="POST" role="form">
                    <div class="box-body">
                        @csrf

                        @include('admin.'.$routeName.'.form')

                        <div class="box-footer">
                            <button class="btn btn-primary float-right">{{ __('lacc.add') }}</button>
                        </div>
                    </div>

                </form>

            </div>
            <!-- /.box -->
        </div>
    </div>

@endsection

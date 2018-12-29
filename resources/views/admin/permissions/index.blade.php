<?php
/**
 * File: index.blade.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 15:44
 * Project: lacc_acl
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
            width: 20%;
        }

        table > thead > tr > th:nth-child(5) {
            width: 15%;
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
                <!-- /.box-header -->
                <div class="box-body">

                    @if($list)
                        <div>
                            <form class="form-inline" method="GET" action="{{route($routeName.'.index')}}">

                                <div class="form-group mb-2">
                                    <a href="{{ route($routeName.'.create')  }}">@lang('lacc.new_record')</a>
                                </div>

                                <div class="form-group mx-sm-3">
                                    <input type="search" name="search" value="{{$search}}" class="form-control"
                                           placeholder="@lang('lacc.search')">
                                </div>
                                <button type="submit" class="btn btn-primary">@lang('lacc.search')</button>
                                <a href="{{ route($routeName.'.index') }}"
                                   class="btn btn-info">@lang('lacc.clear')</a>
                            </form>
                        </div>
                    @endif
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            @foreach($columnList as $key => $value)
                                <th scope="col">{{ $value  }}</th>
                            @endforeach
                            <th scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $key => $value)
                            <tr>
                                @foreach($columnList as $key2 => $value2)
                                    @if($key2 == 'id')
                                        <th scope="row"> @php  echo $value->{$key2} @endphp </th>
                                    @else
                                        <td>  @php  echo $value->{$key2} @endphp  </td>
                                    @endif

                                @endforeach


                                <td>
                                    <a href="{{ route($routeName.'.show',$value->id) }}">
                                        <i style="color: #ff851b;" class="fa fa-eye" aria-hidden="true"></i>
                                    </a>

                                    <a href="{{ route($routeName.'.edit',$value->id) }}">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>

                                    <a href="{{ route($routeName.'.show',[$value->id, 'delete=1']) }}"
                                       title="Delete Role">
                                        <i style="color: #900;" class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
                    @if(!$search && $list)
                        <div class="paginate">
                            {{$list->links()}}
                        </div>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col -->
    </div>
@endsection

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
            width: 30%;
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
                            @foreach($columnList as $key => $v)
                                <th scope="col">{{ $v }}</th>
                            @endforeach
                            <th scope="col">@lang('lacc.actions')</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($list as $k => $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>

                                    @foreach ($user->roles as $role)
                                        @php $isAdmin = $role->name == config('acl_annotations.user.admin'); @endphp
                                        <small class="label {{$isAdmin ? 'bg-red': 'bg-light-blue-gradient'}}">
                                            {{ $role->name }}
                                        </small>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route($routeName.'.show',$user->id) }}">
                                        <i style="color: #ff851b;" class="fa fa-eye" aria-hidden="true"></i>
                                    </a>

                                    <a href="{{ route($routeName.'.edit',$user->id) }}">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>

                                    @if ($user->id == \Auth::user()->id)
                                        <a href="#"
                                           class="disabled">
                                            <strong>{{ __('lacc.can_not_auto_delete') }}</strong>
                                        </a>
                                    @else
                                        <a href="{{ route($routeName.'.show',[$user->id, 'delete=1']) }}">
                                            <i style="color: #990000;" class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4">
                                    <span class="label label-warning">{{ __('lacc.there_are_no_records') }}</span>
                                </td>
                            </tr>
                        @endforelse
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

@push('styles')

@endpush


@section('pos-script')

@endsection

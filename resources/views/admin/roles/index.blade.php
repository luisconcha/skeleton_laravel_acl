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

@extends('layouts.app')

@section('content')
    <h1>{{ __('lacc.role_list') }}</h1>

    @if($breadcrumb)

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                @foreach($breadcrumb as $key => $value)
                    @if($value->url)
                        <li class="breadcrumb-item"><a href="{{route($value->url)}}">{{ $value->title }}</a></li>

                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ $value->title }}</li>
                    @endif
                @endforeach
            </ol>
        </nav>

    @endif

    @if (session('msg'))
        <div class="alert alert-{{ session('status') }}" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <form class="form-inline" method="GET" action="{{route($routeName.'.index')}}">

        <div class="form-group mb-2">
            <a href="{{ route($routeName.'.create')  }}">@lang('lacc.new_record')</a>
        </div>

        <div class="form-group mx-sm-3 mb-2">
            <input type="search" name="search" value="{{$search}}" class="form-control"
                   placeholder="@lang('lacc.search')">
        </div>
        <button type="submit" class="btn btn-primary mb-2">@lang('lacc.search')</button>
        <a href="{{ route($routeName.'.index') }}"
           class="btn btn-warning mb-2 ml-2">@lang('lacc.clear')</a>
    </form>


    <table class="table">
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
                    <a href="{{ route($routeName.'.show',$value->id) }}" title="Role detail">
                        <i style="color:black" class="material-icons">pageview</i>
                    </a>

                    <a href="{{ route($routeName.'.edit',$value->id) }}" title="Edit Role">
                        <i style="color:orange" class="material-icons">edit</i>
                    </a>

                    <a href="{{ route($routeName.'.show',[$value->id, 'delete=1']) }}" title="Delete Role">
                        <i style="color:red" class="material-icons">delete_forever</i>
                    </a>
                    <a href="{{ route($routeName.'.permissions.edit',$value->id ) }}" title="Edit Permission">
                        <i style="color:blue" class="material-icons">security</i>
                    </a>
            </tr>
        @endforeach


        </tbody>
    </table>

    @if(!$search && $list)
        <div class="paginate">
            {{$list->links()}}
        </div>
    @endif
@endsection

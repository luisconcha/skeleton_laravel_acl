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
    <h1>{{ $page }}</h1>

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

    <table class="table table-striped">
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
                        <span class="badge badge-{{$isAdmin ? 'danger': 'secondary'}}">
                        {{ $role->name }}
                    </span>
                    @endforeach


                </td>
                <td>
                    <a href="{{ route($routeName.'.show',$user->id) }}">
                        <i style="color:black" class="material-icons">pageview</i>
                    </a>

                    <a href="{{ route($routeName.'.edit',$user->id) }}">
                        <i style="color:orange" class="material-icons">edit</i>
                    </a>

                    @if ($user->id == \Auth::user()->id)
                        <a href="#"
                           class="btn btn-default btn-outline btn-xs disabled">
                            <strong>{{ __('lacc.can_not_auto_delete') }}</strong>
                        </a>
                    @else
                        <a href="{{ route($routeName.'.show',[$user->id, 'delete=1']) }}">
                            <i style="color:red" class="material-icons">delete_forever</i>
                        </a>
                    @endif
                </td>
            </tr>
        @empty
            <tr class="text-center">
                <td colspan="4"><span class="label label-warning">There are no registered users</span></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @if(!$search && $list)
        <div class="paginate">
            {{$list->links()}}
        </div>
    @endif


@endsection

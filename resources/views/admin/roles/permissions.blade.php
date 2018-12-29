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
        @if (session('msg'))
            <div class="alert alert-{{ session('status') }} alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {{ session('msg') }}
            </div>
        @endif
        <div class="col-md-{{ $col ?? 12  }}">
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

                <div class="card-body">


                    @php $isAdmin = $role->name == config('acl_annotations.user.admin'); @endphp
                    <h3>
                        <small class="label {{$isAdmin ? 'bg-red': 'bg-light-blue-gradient'}}">
                            {{ $page2  }} {{ $role->name }}
                        </small>
                    </h3>


                    <form action="{{route('roles.permissions.update', $role->id)}}" method="POST" role="form">
                        @csrf
                        @method('PUT')

                        <ul class="list-group">
                            @foreach($permissionsGroup as $pg)
                                <li class="list-group-item">
                                    <h4 class="list-group-item-secondary">
                                        <small class="label bg-gray">
                                            {{ $pg->description }}
                                        </small>
                                    </h4>
                                    <p class="list-group-item">
                                    <ul class="list-inline">
                                        @php
                                            $permissionsSubGroup = $permissions->filter(function ($value) use($pg){
                                               return $value->name == $pg->name;
                                            });
                                        @endphp
                                        @foreach($permissionsSubGroup as $permission)
                                            <li class="list-inline-item">
                                                <div class="form-check form-check-inline">
                                                    <label>
                                                        <input type="checkbox" name="permissions[]"
                                                               {{ $role->permissions->contains('id',$permission->id) ? 'checked="checked"':'' }}
                                                               value="{{ $permission->id }}"
                                                               class="form-check-input">{{ $permission->resource_description }}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    </p>
                                </li>
                            @endforeach
                        </ul>


                        <button class="btn btn-primary btn-group-lg">Adicionar Permissão</button>
                    </form>


                </div>
            </div>
        </div>
    </div>


@endsection

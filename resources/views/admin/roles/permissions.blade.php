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

                        @php $isAdmin = $role->name == config('acl_annotations.user.admin'); @endphp
                        <h3>
                            <span class="badge badge-{{$isAdmin ? 'danger': 'secondary'}}">Permissões de {{ $role->name }}</span>
                        </h3>


                        <form action="{{route('roles.permissions.update', $role->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            <ul class="list-group">
                                @foreach($permissionsGroup as $pg)
                                    <li class="list-group-item">
                                        <h4 class="list-group-item-secondary">{{ $pg->description }}</h4>
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
    </div>





@endsection

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
                
               <p>
                   <small class="label bg-light-blue-gradient">
                       {{ __('lacc.name') }}:
                   </small>
                   <span>{{ $register->name }}</span>
               </p>

                <p>
                    <small class="label bg-light-blue-gradient">
                        {{ __('lacc.email') }}:
                    </small>
                    <span>{{ $register->email }}</span>
                </p>

            @if($delete && $register->id != \Auth::user()->id)
                    <form action="{{ route($routeName.'.destroy', $register->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger float-left">{{ __('lacc.delete') }}</button>
                    </form>

                @else
                    <a href="#"
                       class="btn btn-default btn-outline btn-xs disabled">
                        <strong>Can not Delete user</strong>
                    </a>
                @endif

            </div>
        </div>
    </div>

@endsection

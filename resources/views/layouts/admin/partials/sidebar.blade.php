<?php
/**
 * File: sidebar.blade.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 29/12/18
 * Time: 00:43
 * Project: skeleton_laravel_acl
 * Copyright: 2018
 */
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://adminlte.io/themes/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle"
                     alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">{{ __('lacc.system_menus') }}</li>

            @php $links = NavbarAuthorization::getLinksAuthorized(); @endphp

            @foreach($links as $link)

                @can($link['permission'])
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-{{ $link['icon'] }}"></i>
                            <span>{{ $link['title'] }}</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>

                        @if (isset($link['sub_menus']) && count($link['sub_menus']))
                            <ul class="treeview-menu">
                                @foreach($link['sub_menus'] as $submenu)

                                    @can($submenu['permission'])
                                        <li>
                                            <a href="{{ $submenu['link'] }}">
                                                <i class="fa fa-circle-o"></i> {{ $submenu['title'] }}</a>
                                        </li>
                                    @endcan
                                @endforeach
                            </ul>
                        @else
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ $link['link'] }}"><i class="fa fa-circle-o"></i> List</a>
                                </li>
                            </ul>

                        @endif

                    </li>
                @endcan
            @endforeach
        </ul>
    </section>
</aside>


<?php
/**
 * File: NavBar.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 30/12/18
 * Time: 21:50
 * Project: skeleton_laravel_acl
 * Copyright: 2018
 */

namespace App\Menu;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class NavBar
{
    public function getLinksAuthorized( $links = null )
    {
//        $routeCollection = Route::getRoutes();
//
//        foreach ( $routeCollection as $routes ):
//            dump( $routes->getName() );
//        endforeach;
//
        //TODO: CRIAR COMPONENTE DE MENU
        $arrayLink = [
            [
                'link'       => '#',
                'title'      => 'Dashboard',
                'permission' => 'home/list',
                'icon'       => 'dashboard',
                'sub_menus'  => [
                    [
                        'link'       => route( 'home' ),
                        'title'      => 'Reports',
                        'permission' => 'home/list',
                    ],
                ],
            ],
            [
                'link'       => '#',
                'title'      => 'Security',
                'permission' => 'user-admin',
                'icon'       => 'lock',
                'sub_menus'  => [
                    [
                        'link'       => route( 'permissions.index' ),
                        'title'      => 'Permissions',
                        'permission' => 'user-admin',
                    ],
                    [
                        'link'       => route( 'roles.index' ),
                        'title'      => 'Roles',
                        'permission' => 'user-admin',
                    ],
                ],
            ],
            [
                'link'       => route( 'users.index' ),
                'title'      => 'Users',
                'permission' => 'user-admin/list',
                'icon'       => 'users',
            ],
            [
                'link'       => route( 'rh.index' ),
                'title'      => 'Recursos Humanos',
                'permission' => 'rh-admin/list',
                'icon'       => 'apple',
                'sub_menus'  => [
                    [
                        'link'       => route( 'rh.index' ),
                        'title'      => 'Lista de RH',
                        'permission' => 'rh-admin/list',
                    ],
                    [
                        'link'       => route( 'rh.index' ),
                        'title'      => 'Folha de pagamento',
                        'permission' => 'rh-admin/list',
                    ],
                ],
            ],
            [
                'link'       => route( 'armazem.index' ),
                'title'      => 'Armazem',
                'permission' => 'armazem-admin/list',
                'icon'       => 'laptop',
            ],
        ];

        $linksAuthorized = [];
        foreach ( $arrayLink as $link ):

            if ( isset( $link[ 0 ] ) ) {
                $l = $this->getLinksAuthorized( $link[ 1 ] );
                if ( count( $l ) ) {
                    $linksAuthorized[] = [
                        $link[ 0 ],
                        $l,
                    ];
                }
            } elseif ( Auth::user()->can( $link[ 'permission' ] ) ) {
                $linksAuthorized[] = $link;
            }
        endforeach;

        return $linksAuthorized;
    }
}
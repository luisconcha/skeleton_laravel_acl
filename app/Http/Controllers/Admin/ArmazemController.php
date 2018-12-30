<?php
/**
 * File: ArmazemController.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 14:46
 * Project: skeleton_laravel_acl
 * Copyright: 2018
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Annotations\Mapping as Permission;

/**
 * Class ArmazemController
 * @package App\Http\Controllers\Admin
 * @Permission\Controller(name="armazem-admin", description="Adminstração de Armazém")
 */
class ArmazemController extends Controller
{
    private $route = 'armazem';

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @Permission\Action(name="list", description="Ver listagem de Armazém")
     */
    public function index( Request $request )
    {
        $page      = 'Lista Armazém';
        $routeName = $this->route;

        $breadcrumb = [
            [ 'home', trans( 'lacc.home' ) ],
            [ '', trans( 'lacc.list', [ 'page' => $page ] ) ],
        ];
        $breadcrumb = create_breadcrumb( $breadcrumb );

        return view( 'admin.' . $routeName . '.index', compact( 'page', 'routeName', 'breadcrumb' ) );
    }
}

<?php
/**
 * File: RhController.php
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
 * Class RhController
 * @package App\Http\Controllers\Admin
 * @Permission\Controller(name="rh-admin", description="Adminstração de RH")
 */
class RhController extends Controller
{
    private $route = 'rh';

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @Permission\Action(name="list", description="Ver listagem de RH")
     */
    public function index( Request $request )
    {
        $page      = 'Lista RH';
        $routeName = $this->route;

        $breadcrumb = [
            [ 'home', trans( 'lacc.home' ) ],
            [ '', trans( 'lacc.list', [ 'page' => $page ] ) ],
        ];
        $breadcrumb = create_breadcrumb( $breadcrumb );

        return view( 'admin.' . $routeName . '.index', compact( 'page', 'routeName', 'breadcrumb' ) );
    }
}

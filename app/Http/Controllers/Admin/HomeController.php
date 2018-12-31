<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Annotations\Mapping as Permission;

/**
 * Class HomeController
 * @package App\Http\Controllers
 * @Permission\Controller(name="home", description="Pagina home do sistema")
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware( 'auth' );
    }

    /**
     * Show the application dashboard.
     * @Permission\Action(name="list", description="Ver página home")
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'home' );
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Validator;
use App\Annotations\Mapping as Permission;

/**
 * Class PermissionController
 * @package App\Http\Controllers
 * @Permission\Controller(name="permissions-admin", description="Adminstração de permissões")
 */
class PermissionController extends Controller
{
    private $route = 'permissions';
    private $paginate = 10;
    private $search = [ 'name', 'description', 'resource_name' ];
    private $model;

    public function __construct( PermissionRepositoryInterface $modelRepository )
    {
        $this->model = $modelRepository;
    }

    /**
     * @param Request $request
     * @Permission\Action(name="list", description="Ver listagem de permissoes")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index( Request $request )
    {
        $search     = "";
        $page       = 'Lista de Permissões';
        $routeName  = $this->route;
        $columnList = [
            'id'            => '#',
            'name'          => 'name',
            'resource_name' => 'resource',
            'description'   => 'description',
        ];

        if ( isset( $request->search ) ) {
            $search = $request->search;
            $list   = $this->model->findWhereLike( $this->search, $search, 'id', 'DESC' );

        } else {
            $list = $this->model->paginate( $this->paginate, 'id', 'DESC' );
        }


        $breadcrumb = [
            [ 'home', 'Pagina Home' ],
            [ '', 'Lista de permissoes' ],
        ];
        $breadcrumb = create_breadcrumb( $breadcrumb );

        return view( 'admin.' . $routeName . '.index', compact( 'list', 'search', 'page', 'routeName', 'columnList', 'breadcrumb' ) );
    }

    /**
     * @Permission\Action(name="store", description="Criar permissões")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $routeName   = $this->route;
        $page        = 'FRM de cadastro de permissions';
        $page_create = 'permissions';

        $breadcrumb = [
            [ 'home', 'Pagina Home' ],
            [ $routeName . '.index', 'Lista de permissions' ],
            [ '', 'Cadastro de permissions' ],
        ];
        $breadcrumb = create_breadcrumb( $breadcrumb );

        return view( 'admin.' . $routeName . '.create', compact( 'page', 'page_create', 'routeName', 'breadcrumb' ) );

    }

    /**
     * @Permission\Action(name="store", description="Criar permissões")
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( Request $request )
    {
        $data = $request->all();

        $this->model->rules( $data );

        if ( $this->model->create( $data ) ) {
            createMessage( 'msg', 'success', 'Cadastro salvo com sucesso!' );

            return redirect()->back();

        } else {
            createMessage( 'msg', 'danger', 'Error ao tentar salvar o registro!' );

            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @Permission\Action(name="show", description="Visualizar detalhe da permissão")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show( $id, Request $request )
    {
        $routeName = $this->route;
        $register  = $this->model->find( $id );
        if ( $register ) {
            $page  = 'Lista de permissões';
            $page2 = 'permission';


            $breadcrumb = [
                [ 'home', 'Pagina Home' ],
                [ $routeName . '.index', 'Lista de permission' ],
                [ '', 'Detalhe de permissions' ],
            ];
            $breadcrumb = create_breadcrumb( $breadcrumb );

            $delete = false;

            if ( $request->delete ?? false ) {
                createMessage( 'msg', 'danger', 'Deseja deletar o registro?' );
                $delete = true;
            }

            return view( 'admin.' . $routeName . '.show', compact( 'register', 'page', 'page2', 'routeName', 'breadcrumb', 'delete' ) );
        }

        return redirect()->route( $routeName . '.index' );
    }

    /**
     * Show the form for editing the specified resource.
     * @Permission\Action(name="edit", description="Editar permissões")
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $routeName = $this->route;
        $register  = $this->model->find( $id );

        if ( $register ) {
            $page  = 'Lista de permissões';
            $page2 = 'permission';

            $breadcrumb = [
                [ 'home', 'Pagina Home' ],
                [ $routeName . '.index', 'Lista de permissions' ],
                [ '', 'Editar permissions' ],
            ];
            $breadcrumb = create_breadcrumb( $breadcrumb );


            return view( 'admin.' . $routeName . '.edit', compact( 'register', 'page', 'page2', 'routeName', 'breadcrumb' ) );
        }

        return redirect()->route( $routeName . '.index' );
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @Permission\Action(name="edit", description="Editar permissões")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( Request $request, $id )
    {
        $data = $request->all();

        $this->model->rules( $data );

        if ( $this->model->update( $data, $id ) ) {
            createMessage( 'msg', 'success', 'Editado com sucesso!' );

            return redirect()->back();
        } else {
            createMessage( 'msg', 'danger', 'Error ao editar o registro!' );

            return redirect()->back();
        }
    }

    /**
     * @param $id
     *
     * @Permission\Action(name="destroy", description="Excluir permissões")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy( $id )
    {
        if ( $this->model->delete( $id ) ) {
            createMessage( 'msg', 'success', 'Deletado com sucesso!' );
        } else {
            createMessage( 'msg', 'danger', 'Error ao deletar!' );
        }
        $routeName = $this->route;

        return redirect()->route( $routeName . '.index' );
    }
}
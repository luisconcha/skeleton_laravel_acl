<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Validator;
use App\Annotations\Mapping as Permission;


/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 * @Permission\Controller(name="users-admin", description="Adminstração de usuários")
 */
class UserController extends Controller
{
    private $route = 'users';
    private $paginate = 10;
    private $search = [ 'name', 'email' ];
    private $model;
    private $modelRole;

    public function __construct( UserRepositoryInterface $modelRepository, RoleRepositoryInterface $modelRole )
    {
        $this->model     = $modelRepository;
        $this->modelRole = $modelRole;
    }

    /**
     * @param Request $request
     * @Permission\Action(name="list", description="Ver listagem de usuarios")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index( Request $request )
    {
        $search     = "";
        $page       = trans( 'lacc.user_list' );
        $routeName  = $this->route;
        $columnList = [
            'id'    => '#',
            'name'  => trans( 'lacc.name' ),
            'email' => trans( 'lacc.email' ),
            'role'  => trans( 'lacc.role' ),
        ];

        if ( isset( $request->search ) ) {
            $search = $request->search;
            $list   = $this->model->findWhereLike( $this->search, $search, 'id', 'DESC' );

        } else {
            $list = $this->model->paginate( $this->paginate, 'id', 'DESC' );
        }

        $breadcrumb = [
            [ 'home', trans( 'lacc.home' ) ],
            [ '', trans( 'lacc.list', [ 'page' => $page ] ) ],
        ];
        $breadcrumb = create_breadcrumb( $breadcrumb );

        return view( 'admin.' . $routeName . '.index', compact( 'list', 'search', 'page', 'routeName', 'columnList', 'breadcrumb' ) );
    }

    /**
     * @Permission\Action(name="store", description="Criar usuários")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $routeName   = $this->route;
        $page        = trans( 'lacc.user_list' );
        $page_create = trans( 'lacc.user' );
        $roles       = $this->modelRole->all( 'name' );

        $breadcrumb = [
            [ 'home', trans( 'lacc.home' ) ],
            [ $routeName . '.index', trans( 'lacc.list', [ 'page' => $page ] ) ],
            [ '', trans( 'lacc.create_crud', [ 'page' => $page_create ] ) ],
        ];
        $breadcrumb = create_breadcrumb( $breadcrumb );

        return view( 'admin.' . $routeName . '.create', compact( 'page', 'page_create', 'routeName', 'breadcrumb', 'roles' ) );

    }

    /**
     * @Permission\Action(name="store", description="Criar usuários")
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( Request $request )
    {
        $data = $request->all();

        $this->model->rules( $data );

        if ( $this->model->create( $data ) ) {
            createMessage( 'msg', 'success', trans( 'lacc.record_added_successfully' ) );

            return redirect()->back();

        } else {
            createMessage( 'msg', 'danger', trans( 'lacc.record_adding_record' ) );

            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @Permission\Action(name="show", description="Visualizar detalhe do usuário")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show( $id, Request $request )
    {
        $routeName = $this->route;
        $register  = $this->model->find( $id );
        if ( $register ) {
            $page  = trans( 'lacc.user_list' );
            $page2 = trans( 'lacc.user' );

            $breadcrumb = [
                [ 'home', trans( 'lacc.home' ) ],
                [ $routeName . '.index', trans( 'lacc.list', [ 'page' => $page ] ) ],
                [ '', trans( 'lacc.show_crud', [ 'page' => $page2 ] ) ],
            ];
            $breadcrumb = create_breadcrumb( $breadcrumb );

            $delete = false;

            if ( $request->delete ?? false ) {
                createMessage( 'msg', 'danger', trans( 'lacc.delete_this_record' ) );
                $delete = true;
            }

            return view( 'admin.' . $routeName . '.show', compact( 'register', 'page', 'page2', 'routeName', 'breadcrumb', 'delete' ) );
        }

        return redirect()->route( $routeName . '.index' );
    }

    /**
     * Show the form for editing the specified resource.
     * @Permission\Action(name="update", description="Atualizar usuários")
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $routeName = $this->route;
        $register  = $this->model->find( $id );
        $roles     = $this->modelRole->all( 'name' );

        if ( $register ) {
            $page  = trans( 'lacc.user_list' );
            $page2 = trans( 'lacc.user' );

            $breadcrumb = [
                [ 'home', trans( 'lacc.home' ) ],
                [ $routeName . '.index', trans( 'lacc.list', [ 'page' => $page ] ) ],
                [ '', trans( 'lacc.edit_crud', [ 'page' => $page2 ] ) ],
            ];
            $breadcrumb = create_breadcrumb( $breadcrumb );


            return view( 'admin.' . $routeName . '.edit', compact( 'register', 'page', 'page2', 'routeName', 'breadcrumb', 'roles' ) );
        }

        return redirect()->route( $routeName . '.index' );
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @Permission\Action(name="update", description="Atualizar usuários")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( Request $request, $id )
    {

        if ( $this->model->isUserAdmin( $id ) ) {
            $txtMsg = "Não é possivel alterar o usuário: " . config( 'acl_annotations.user.admin' );
            createMessage( 'msg', 'danger', $txtMsg );

        } else {
            $data = $request->all();
            if ( !$data[ 'password' ] ) {
                unset( $data[ 'password' ] );
            }

            $this->model->rules( $data );

            $this->model->update( $data, $id ) ?
                createMessage( 'msg', 'success', trans( 'lacc.successfully_edited_record' ) )
                :
                createMessage( 'msg', 'danger', trans( 'lacc.error_while_changing_register' ) );

        }

        return redirect()->back();
    }

    /**
     * @param $id
     *
     * @Permission\Action(name="destroy", description="Excluir usuários")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy( $id )
    {
        try {

            if ( $this->model->isUserAdmin( $id ) ) {
                $txtMsg = trans( 'lacc.unable_to_delete_administrator_role', [ 'role_name' => config( 'acl_annotations.user.admin' ) ] );
                createMessage( 'msg', 'danger', $txtMsg );

            } else {
                $this->model->delete( $id );
                createMessage( 'msg', 'success', trans( 'lacc.registration_deleted_successfully' ) );
            }


        } catch ( QueryException $e ) {
            createMessage( 'msg', 'danger', trans( 'lacc.impossible_delete_the_record' ) );
            createMessage( 'msg', 'danger', $txtMsg );
        }

        $routeName = $this->route;

        return redirect()->route( $routeName . '.index' );
    }
}
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
 * @package App\Http\Controllers
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
            [ '', trans( 'lacc.list', [ 'page' => $page ] )  ],
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
        $page        = 'FRM de cadastro de usuarios';
        $page_create = 'usuarios';
        $roles       = $this->modelRole->all( 'name' );

        $breadcrumb = [
            [ 'home', 'Pagina Home' ],
            [ $routeName . '.index', 'Lista de usuarios' ],
            [ '', 'Cadastro de usuarios' ],
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
            createMessage( 'msg', 'success', 'Cadastro salvo com sucesso!' );

            return redirect()->back();

        } else {
            createMessage( 'msg', 'danger', 'Error ao tentar salvar o registro!' );

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
            $page  = 'Lista de usuários';
            $page2 = 'usuario';


            $breadcrumb = [
                [ 'home', 'Pagina Home' ],
                [ $routeName . '.index', 'Lista de usuario' ],
                [ '', 'Detalhe de usuarios' ],
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
            $page  = 'Lista de usuários';
            $page2 = 'usuario';

            $breadcrumb = [
                [ 'home', 'Pagina Home' ],
                [ $routeName . '.index', 'Lista de usuarios' ],
                [ '', 'Editar usuarios' ],
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
                createMessage( 'msg', 'success', 'Editado com sucesso!' )
                :
                createMessage( 'msg', 'danger', 'Error ao editar o registro!' );

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
                $txtMsg = "Não é possivel deletar o usuário: " . config( 'acl_annotations.user.admin' );
                createMessage( 'msg', 'danger', $txtMsg );

            } else {
                $this->model->delete( $id );
                createMessage( 'msg', 'success', 'Deletado com sucesso!' );
            }


        } catch ( QueryException $e ) {
            $txtMsg = 'Não é possivel deletar a role por que ela esta relacionada com outros registros!';
            createMessage( 'msg', 'danger', $txtMsg );
        }

        $routeName = $this->route;

        return redirect()->route( $routeName . '.index' );
    }
}
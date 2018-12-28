<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Validator;
use App\Annotations\Mapping as Permission;

/**
 * Class RoleController
 * @package App\Http\Controllers
 * @Permission\Controller(name="roles-admin", description="Adminstração de papeis de usuário")
 */
class RoleController extends Controller
{
    private $route = 'roles';
    private $paginate = 10;
    private $search = [ 'name', 'description' ];
    private $model;
    /**
     * @var PermissionRepositoryInterface
     */
    private $modelPermissionRepository;

    public function __construct( RoleRepositoryInterface $modelRoleRepository, PermissionRepositoryInterface $modelPermissionRepository )
    {
        $this->model                     = $modelRoleRepository;
        $this->modelPermissionRepository = $modelPermissionRepository;
    }

    /**
     * @param Request $request
     * @Permission\Action(name="list", description="Ver listagem de papeis")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index( Request $request )
    {
        $search     = "";
        $page       = 'Lista de Roles';
        $routeName  = $this->route;
        $columnList = [
            'id'          => '#',
            'name'        => 'nome',
            'description' => 'description',
        ];

        if ( isset( $request->search ) ) {
            $search = $request->search;
            $list   = $this->model->findWhereLike( $this->search, $search, 'id', 'DESC' );

        } else {
            $list = $this->model->paginate( $this->paginate, 'id', 'DESC' );
        }


        $breadcrumb = [
            [ 'home', 'Pagina Home' ],
            [ '', 'Lista de roles' ],
        ];
        $breadcrumb = create_breadcrumb( $breadcrumb );

        return view( 'admin.' . $routeName . '.index', compact( 'list', 'search', 'page', 'routeName', 'columnList', 'breadcrumb' ) );
    }

    /**
     * @Permission\Action(name="store", description="Criar papeis")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $routeName   = $this->route;
        $page        = 'FRM de cadastro de roles';
        $page_create = 'roles';

        $breadcrumb = [
            [ 'home', 'Pagina Home' ],
            [ $routeName . '.index', 'Lista de roles' ],
            [ '', 'Cadastro de roles' ],
        ];
        $breadcrumb = create_breadcrumb( $breadcrumb );

        return view( 'admin.' . $routeName . '.create', compact( 'page', 'page_create', 'routeName', 'breadcrumb' ) );

    }

    /**
     * @Permission\Action(name="store", description="Criar papeis")
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
     * @Permission\Action(name="show", description="Visualizar detalhe do papel")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show( $id, Request $request )
    {
        $routeName = $this->route;
        $register  = $this->model->find( $id );
        if ( $register ) {
            $page  = 'Lista de roles';
            $page2 = 'role';


            $breadcrumb = [
                [ 'home', 'Pagina Home' ],
                [ $routeName . '.index', 'Lista de role' ],
                [ '', 'Detalhe de roles' ],
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
     * @Permission\Action(name="edit", description="Editar papel")
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
            $page  = 'Lista de roles';
            $page2 = 'role';

            $breadcrumb = [
                [ 'home', 'Pagina Home' ],
                [ $routeName . '.index', 'Lista de roles' ],
                [ '', 'Editar roles' ],
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
     * @Permission\Action(name="edit", description="Editar papel")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( Request $request, $id )
    {
        $data = $request->all();

        $this->model->rules( $data );

        if ( $this->model->isRoleAdmin( $id ) ) {
            $txtMsg = "Não é possivel alterar o usuário: " . config( 'acl_annotations.user.admin' );
            createMessage( 'msg', 'danger', $txtMsg );
            $routeName = $this->route;

            return redirect()->route( $routeName . '.index' );

        } else {
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
     * @Permission\Action(name="destroy", description="Excluir papel")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy( $id )
    {
        try {

            if ( $this->model->isRoleAdmin( $id ) ) {
                $txtMsg = "Não é possivel deletar o perfil: " . config( 'acl_annotations.user.admin' );
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

    /**
     * @param $id
     *
     * @Permission\Action(name="edit-permissions-role", description="Editar as permissoes atreladas nas roles")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPermissions( $id )
    {
        $role        = $this->model->find( $id );
        $routeName   = $this->route;
        $page        = 'FRM de cadastro de roles';
        $page_create = 'roles';

        $permissions      = $this->modelPermissionRepository->findPermissionsResources();
        $permissionsGroup = $this->modelPermissionRepository->findPermissionsGroup();

        $breadcrumb = [
            [ 'home', 'Pagina Home' ],
            [ $routeName . '.index', 'Lista de roles' ],
            [ '', 'Editar Permissions' ],
        ];
        $breadcrumb = create_breadcrumb( $breadcrumb );

        return view( 'admin.' . $routeName . '.permissions', compact( 'page', 'page_create', 'routeName', 'breadcrumb', 'role', 'permissions', 'permissionsGroup' ) );

    }

    /**
     * @param Request $request
     * @param $id
     * @Permission\Action(name="edit-permissions-role", description="Editar as permissoes atreladas nas roles")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePermissions( Request $request, $id )
    {
        $data = $request->only( 'permissions' );

        $this->model->rulesPermissions( $data );

        $this->model->updatePermissions( $data, $id ) ?
            createMessage( 'msg', 'success', 'Permissões atribuidas com sucesso!' )
            :
            createMessage( 'msg', 'danger', 'Não foi possivel atribuir as permissões!' );


        return redirect()->back();
    }
}
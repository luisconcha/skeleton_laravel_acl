<?php /** @noinspection PhpSuperClassIncompatibleWithInterfaceInspection */

/**
 * File: RoleRepository.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 14:46
 * Project: lacc_acl
 * Copyright: 2018
 */

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Validator;

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    protected $model = Role::class;

    public function rules( $data )
    {
        $idRole = ( \Request::segment( 3 ) ) ? : null;

        return Validator::make( $data, [
            'name'        => "required|string|max:255|min:3|unique:roles,name,$idRole",
            'description' => 'string|max:255|min:3',
        ] )->validate();
    }

    public function rulesPermissions( $data )
    {
        return Validator::make( $data, [
            'permissions'   => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ] )->validate();
    }

    public function isRoleAdmin( $id ): Bool
    {
        $result = $this->find( $id );

        if ( $result ) {
            return $result->name == config( 'acl_annotations.user.admin' ) ? true : false;
        }
    }

    public function updatePermissions( array $data, int $id )
    {
        $model = $this->model->find( $id );

        if ( isset( $data[ 'permissions' ] ) && $model ) {
            $model->permissions()->sync( $data[ 'permissions' ] );
        } elseif ( !isset( $data[ 'permissions' ] ) && $model ) {
            $model->permissions()->sync( $data );
        }


        return $model;
    }
}
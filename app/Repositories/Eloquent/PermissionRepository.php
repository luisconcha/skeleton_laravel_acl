<?php /** @noinspection PhpSuperClassIncompatibleWithInterfaceInspection */

/**
 * File: PermissionRepository.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 14:46
 * Project: lacc_acl
 * Copyright: 2018
 */

namespace App\Repositories\Eloquent;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Validator;

class PermissionRepository extends AbstractRepository implements PermissionRepositoryInterface
{
    protected $model = Permission::class;

    public function rules( $data )
    {
        $idPermission = ( \Request::segment( 3 ) ) ? : null;

        return Validator::make( $data, [
            'name'                 => 'required|string|max:255|min:3',
            'description'          => 'string|max:255',
            'resource_description' => 'string|max:255',
        ] )->validate();
    }

    public function findPermissionsResources(): Collection
    {
        return $this->model->whereNotNull( 'resource_name' )->get();
    }

    public function findPermissionsGroup(): Collection
    {
        return $this->model
            ->select( 'name', 'description' )
            ->groupBy( 'name', 'description' )
            ->get();
    }
}
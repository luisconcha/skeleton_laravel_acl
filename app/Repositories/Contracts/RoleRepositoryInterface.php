<?php
/**
 * File: RoleRepositoryInterface.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 14:29
 * Project: lacc_acl
 * Copyright: 2018
 */

namespace App\Repositories\Contracts;


interface RoleRepositoryInterface extends AbstracRepositoryInterface
{
    public function isRoleAdmin( $id ): Bool;
}
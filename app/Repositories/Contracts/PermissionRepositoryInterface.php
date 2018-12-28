<?php
/**
 * File: PermissionRepositoryInterface.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 14:17
 * Project: lacc_acl
 * Copyright: 2018
 */

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface extends AbstracRepositoryInterface
{
    public function findPermissionsResources(): Collection;

    public function findPermissionsGroup(): Collection;
}
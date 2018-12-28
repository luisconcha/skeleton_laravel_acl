<?php
/**
 * File: UserRepositoryInterface.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 14:09
 * Project: lacc_acl
 * Copyright: 2018
 */

namespace App\Repositories\Contracts;

interface UserRepositoryInterface extends AbstracRepositoryInterface
{
    public function isUserAdmin( $id ): Bool;
}
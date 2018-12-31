<?php
/**
 * File: NavbarAuthorization.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 30/12/18
 * Time: 22:22
 * Project: skeleton_laravel_acl
 * Copyright: 2018
 */

namespace App\Facade;

use App\Menu\NavBar;
use Illuminate\Support\Facades\Facade;

class NavbarAuthorization extends Facade
{
    protected static function getFacadeAccessor()
    {
        return NavBar::class;
    }
}
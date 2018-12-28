<?php
/**
 * File: Controller.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 01:05
 * Project: laravel56_acl
 * Copyright: 2018
 */

namespace App\Annotations\Mapping;

/**
 * Class Controller
 * @package App\Annotations\Mapping
 * @Annotation
 * @Target("CLASS")
 */
class Controller
{
    public $name;
    public $description;
}
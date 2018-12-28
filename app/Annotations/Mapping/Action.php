<?php
/**
 * File: Action.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 11:50
 * Project: laravel56_acl
 * Copyright: 2018
 */

namespace App\Annotations\Mapping;


/**
 * Class Action
 * @package App\Annotations\Mapping
 * @Annotation
 * @Target("METHOD")
 */
class Action
{
    public $name;
    public $description;
}
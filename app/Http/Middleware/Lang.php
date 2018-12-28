<?php
/**
 * File: Lang.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 28/12/18
 * Time: 01:09
 * Project: skeleton_laravel_acl
 * Copyright: 2018
 */

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\App;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle( $request, Closure $next )
    {
        $lang = session( 'lang', 'pt-br' );
        App::setLocale( $lang );

        return $next( $request );
    }
}

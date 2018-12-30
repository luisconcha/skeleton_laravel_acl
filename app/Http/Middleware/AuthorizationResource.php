<?php
/**
 * File: AuthorizationResource.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 29/12/18
 * Time: 22:08
 * Project: skeleton_laravel_acl
 * Copyright: 2018
 */


namespace App\Http\Middleware;

use App\Annotations\PermissionReader;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;

//use Illuminate\Support\Facades\Gate;

class AuthorizationResource
{
    /**
     * @var PermissionReader
     */
    private $reader;

    public function __construct( PermissionReader $reader )
    {

        $this->reader = $reader;
    }

    /**
     * @param $request
     * @param Closure $next
     *
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle( $request, Closure $next )
    {
        $currentAction = \Route::currentRouteAction();
        list( $controller, $action ) = explode( '@', $currentAction );

        $permission = $this->reader->getPermission( $controller, $action );
        if ( count( $permission ) ) {
            $permission = $permission[ 0 ];

            if ( !\Gate::allows( "{$permission['name']}/{$permission['resource_name']}" ) ) {
                throw new AuthorizationException( trans( 'lacc.not_authorized' ) );
            }
        }

        return $next( $request );
    }
}

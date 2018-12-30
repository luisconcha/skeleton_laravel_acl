<?php

namespace App\Providers;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::before( function ( $user, $aility ) {
            //return true - autorizado
            //return false - não autorizado
            //return void - vai executar a habilidade em questão
            if ( $user->isAdmin() ) {
                return true;
            }
        } );

        if ( !app()->runningInConsole() || app()->runningUnitTests() ) {
            /** $var PermissionRepositoryInterface $permissionRepository */
            $permissionRepository = app( PermissionRepositoryInterface::class );
            $permissions          = $permissionRepository->findPermissionsResources();
            foreach ( $permissions as $p ):
                Gate::define( "{$p->name}/{$p->resource_name}", function ( $user ) use ( $p ) {
                    return $user->hasRole( $p->roles );
                } );
            endforeach;
        }
    }
}

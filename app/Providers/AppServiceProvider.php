<?php

namespace App\Providers;

use App\Annotations\Mapping\Controller;
use App\Annotations\PermissionReader;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\FilesystemCache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @throws \ReflectionException
     */
    public function boot()
    {
        /** @var PermissionReader $reader */
        $reader = app( PermissionReader::class );

        // dd( $reader->getPermissions() );

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAnnotations();

        $this->app->bind( Reader::class, function () {
            return new CachedReader(
                new AnnotationReader(),
                new FilesystemCache( storage_path( 'framework/cache/doctrine-annotations' ) ),
                $debug = env( 'APP_DEBUG' )
            );
        } );

        $this->app->bind( UserRepositoryInterface::class, UserRepository::class );
        $this->app->bind( PermissionRepositoryInterface::class, PermissionRepository::class );
        $this->app->bind( RoleRepositoryInterface::class, RoleRepository::class );
    }

    public function registerAnnotations()
    {
        $loader = require __DIR__ . '/../../vendor/autoload.php';
        AnnotationRegistry::registerLoader( [ $loader, 'loadClass' ] );
    }
}

<?php
/**
 * File: PermissionReader.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 11:35
 * Project: laravel56_acl
 * Copyright: 2018
 */

namespace App\Annotations;


use App\Annotations\Mapping\Action;
use App\Annotations\Mapping\Controller;
use Doctrine\Common\Annotations\Reader;
use Illuminate\Support\Facades\File;

class PermissionReader
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * PermissionReader constructor.
     *
     * @param Reader $reader
     */
    public function __construct( Reader $reader )
    {
        $this->reader = $reader;
    }

    /**
     * Recupera as permissoes de todos os controllers
     */
    public function getPermissions()
    {
        $controllersClasses = $this->getControllers();
        $declared           = get_declared_classes();
        $permissions        = [];
        foreach ( $declared as $className ):
            $rc = new \ReflectionClass( $className );

            if ( in_array( $rc->getFileName(), $controllersClasses ) ) {
                $permission = $this->getPermission( $className );

                if ( count( $permission ) ) {
                    $permissions = array_merge( $permissions, $permission );
                }
            }
        endforeach;

        return $permissions;
    }

    /**
     * Recupera as permissões relativas a um controller
     */
    public function getPermission( $controllerClass )
    {
        $rc = new \ReflectionClass( $controllerClass );
        /** @var Controller $controllerAnnotation */
        $controllerAnnotation = $this->reader->getClassAnnotation( $rc, Controller::class );
        $permissions          = [];
        if ( $controllerAnnotation ) {
            $permission = [
                'name'        => $controllerAnnotation->name,
                'description' => $controllerAnnotation->description,
            ];

            $rcMethods = $rc->getMethods();

            foreach ( $rcMethods as $rcMethod ):
                /** @var Action $actionAnnotation */
                $actionAnnotation = $this->reader->getMethodAnnotation( $rcMethod, Action::class );

                if ( $actionAnnotation ) {
                    $permission[ 'resource_name' ]        = $actionAnnotation->name;
                    $permission[ 'resource_description' ] = $actionAnnotation->description;
                    $permissions[]                        = ( new \ArrayIterator( $permission ) )->getArrayCopy();
                }
            endforeach;
        }

        return $permissions;
    }

    private function getControllers()
    {
        $dirs  = config( 'acl_annotations.acl.controllers_annotations' );
        $files = [];
        foreach ( $dirs as $dir ):
            foreach ( File::allFiles( $dir ) as $file ):
                $files[] = $file->getRealPath();
                require_once $file->getRealPath();
            endforeach;
        endforeach;

        return $files;
    }
}
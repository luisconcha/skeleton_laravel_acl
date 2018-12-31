<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roleAdmin = \App\Models\Role::create( [
            'name'        => env( 'ROLE_ADMIN', 'Admin' ),
            'description' => 'Papel do usuário mestre do sistema',
        ] );

        $userAdmin = \App\Models\User::where( 'email', env( 'USER_ADMIN_EMAIL', 'admin@user.com' ) )->first();
        $userAdmin->roles()->save( $roleAdmin );

        $roleVisitor = \App\Models\Role::create( [
            'name'        => env( 'ROLE_VISITOR', 'Visitor' ),
            'description' => 'Papel do usuário visitante do sistema',
        ] );

        $userVisitor = \App\Models\User::where( 'email', env( 'USER_VISITOR_EMAIL', 'visitor@user.com' ) )->first();
        $userVisitor->roles()->save( $roleVisitor );

        $roleManager = \App\Models\Role::create( [
            'name'        => env( 'ROLE_MANGER', 'Manager' ),
            'description' => 'Papel do usuário gerente do sistema',
        ] );

        $userManager = \App\Models\User::where( 'email', env( 'USER_MANGER_EMAIL', 'manager@user.com' ) )->first();
        $userManager->roles()->save( $roleManager );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $roleAdmin = \App\Models\Role::where( 'name', env( 'ROLE_ADMIN', 'Admin' ) )->first();
        $admin     = \App\Models\User::where( 'email', env( 'USER_ADMIN_EMAIL', 'admin@user.com' ) )->first();
        $admin->roles()->detach( $roleAdmin->id );
        $roleAdmin->permissions()->detach();
        $roleAdmin->users()->detach();
        $roleAdmin->delete();


        $roleVisitor = \App\Models\Role::where( 'name', env( 'ROLE_VISITOR', 'Visitor' ) )->first();
        $visitor     = \App\Models\User::where( 'email', env( 'USER_VISITOR_EMAIL', 'visitor@user.com' ) )->first();
        $visitor->roles()->detach( $roleVisitor->id );
        $roleVisitor->permissions()->detach();
        $roleVisitor->users()->detach();
        $roleVisitor->delete();

        $roleManager = \App\Models\Role::where( 'name', env( 'ROLE_MANAGER', 'Manager' ) )->first();
        $manager     = \App\Models\User::where( 'email', env( 'USER_MANAGER_EMAIL', 'manager@user.com' ) )->first();
        $manager->roles()->detach( $roleManager->id );
        $roleManager->permissions()->detach();
        $roleManager->users()->detach();
        $roleManager->delete();
    }
}

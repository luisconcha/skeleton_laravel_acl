<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

class CreateUsersData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\User::create( [
            'name'     => env( 'USER_ADMIN_NAME', 'Administrator' ),
            'email'    => env( 'USER_ADMIN_EMAIL', 'administrator@user.com' ),
            'password' => env( Hash::make( 'USER_ADMIN_PASSWORD' ), Hash::make( '123456' ) ),
        ] );

        \App\Models\User::create( [
            'name'     => env( 'USER_MANAGER_NAME', 'Manager' ),
            'email'    => env( 'USER_MANAGER_EMAIL', 'manager@user.com' ),
            'password' => env( Hash::make( 'USER_MANAGER_PASSWORD' ), Hash::make( '123456' ) ),
        ] );

        \App\Models\User::create( [
            'name'     => env( 'USER_VISITOR_NAME', 'Visitor' ),
            'email'    => env( 'USER_VISITOR_EMAIL', 'visitor@user.com' ),
            'password' => env( Hash::make( 'USER_VISITOR_PASSWORD' ), Hash::make( '123456' ) ),
        ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $admin = \App\Models\User::where( 'email', env( 'USER_ADMIN_EMAIL', 'administrator@user.com' ) )->first();
        $admin->delete();

        $gerente = \App\Models\User::where( 'email', env( 'USER_MANAGER_EMAIL', 'manager@user.com' ) )->first();
        $gerente->delete();

        $visitante = \App\Models\User::where( 'email', env( 'USER_VISITOR_EMAIL', 'visitor@user.com' ) )->first();
        $visitante->delete();

    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'permission_role', function ( Blueprint $table ) {
            $table->integer( 'permission_id' )->unsigned();
            $table->foreign( 'permission_id' )->references( 'id' )->on( 'permissions' );
            $table->integer( 'role_id' )->unsigned();
            $table->foreign( 'role_id' )->references( 'id' )->on( 'roles' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'permission_role', function ( Blueprint $table ) {
            $table->dropForeign( 'permission_role_role_id_foreign' );
            $table->dropForeign( 'permission_role_permission_id_foreign' );
        } );
        Schema::dropIfExists( 'permission_role' );
    }
}

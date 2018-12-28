<?php

Route::get( 'lang/{param?}', function ( $param ) {

    $lang = session( 'lang', 'pt-br' );

    switch ( $param ):
        case 'es':
            $lang = 'es';
            break;
        case 'pt-br':
            $lang = 'pt-br';
            break;
        case 'en':
            $lang = 'en';
            break;
    endswitch;

    session( [ 'lang' => $lang ] );

    return redirect()->back();

} )->name( 'lang' );

Route::get( '/', function () {
    return view( 'welcome' );
} );

Auth::routes();

Route::middleware( 'auth' )->group( function () {
    Route::get( '/home', 'HomeController@index' )->name( 'home' );
} );

//Route::group( [ 'prefix' => 'admin', 'middleware' => 'can:user-admin' ], function () {
//    Route::resource( 'users', 'UserController' );
//} );

/*************************
 * ROUTAS PARA ADMIN
 *************************/
Route::prefix( 'admin' )->middleware( 'auth' )->namespace( 'Admin' )->group( function () {

    Route::resource( 'users', 'UserController' );
    Route::resource( 'permissions', 'PermissionController' );

    Route::resource( 'roles', 'RoleController' );
    Route::get( '/roles/{id}/permissions', 'RoleController@editPermissions' )->name( 'roles.permissions.edit' );
    Route::put( '/roles/{id}/permissions', 'RoleController@updatePermissions' )->name( 'roles.permissions.update' );
} );

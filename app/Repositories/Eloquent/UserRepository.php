<?php /** @noinspection PhpSuperClassIncompatibleWithInterfaceInspection */

/**
 * File: UserRepository.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 26/12/18
 * Time: 14:46
 * Project: lacc_acl
 * Copyright: 2018
 */

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\UserRepositoryInterface;
use Validator;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    protected $model = User::class;

    public function create( array $data ): Bool
    {

        $data[ 'password' ] = Hash::make( $data[ 'password' ] );
        $register           = $this->model->create( $data );

        if ( isset( $data[ 'roles' ] ) && count( $data[ 'roles' ] ) ) {
            foreach ( $data[ 'roles' ] as $key => $value ) {
                $register->roles()->attach( $value );
            }
        }

        return (bool)$register;
    }

    public function update( array $data, int $id ): Bool
    {
        $register = $this->find( $id );
        if ( $register ) {
            if ( $data[ 'password' ] ?? false ) {
                $data[ 'password' ] = Hash::make( $data[ 'password' ] );
            }

            $roles = $register->roles;

            if ( count( $roles ) ) {
                foreach ( $roles as $key => $value ) {
                    $register->roles()->detach( $value->id );
                }
            }

            if ( isset( $data[ 'roles' ] ) && count( $data[ 'roles' ] ) ) {
                foreach ( $data[ 'roles' ] as $key => $value ) {
                    $register->roles()->attach( $value );
                }
            }

            return (bool)$register->update( $data );
        } else {
            return false;
        }
    }

    public function isUserAdmin( $id ): Bool
    {
        $result = $this->find( $id );
        if ( $result ) {
            return $result->name == config( 'acl_annotations.user.admin' ) ? true : false;
        }
    }

    public function rules( $data )
    {
        $idUser = ( \Request::segment( 3 ) ) ? : null;

        $emailRules = $idUser ? '' : 'unique:users|';
        $passRules  = $idUser ? 'sometimes|' : '';

        return Validator::make( $data, [
            'name'     => 'required|string|max:255|min:3',
            'email'    => $emailRules . 'required|string|email|max:255',
            'password' => $passRules . 'required|string|min:6|confirmed',
        ] )->validate();
    }
}
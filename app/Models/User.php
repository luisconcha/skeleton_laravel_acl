<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Validator;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    protected $dates = [ 'deleted_at' ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany( Role::class );
    }

    public function hasRoles( $roles )
    {
        $userRoles = $this->roles();

        return $roles->intersect( $userRoles )->count();
    }

    public function isAdmin()
    {
        return $this->hasRole( env( 'USER_ADMIN_NAME', 'Administrator' ) );
    }

    public function hasRole( $role )
    {
        return is_string( $role ) ?
            $this->roles->contains( 'name', $role ) :
            (boolean)$role->intersect( $this->roles )->count();
    }

    public function getColumnsFillable()
    {
        return $this->fillable;
    }
}

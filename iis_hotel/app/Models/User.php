<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/*
    0 ... Admin
    10 ... Owner
    20 ... Receptionist (Clerk)
    30 ... Customer
*/


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const role_admin = 0;
    const role_owner = 10;
    const role_clerk = 20;
    const role_customer = 30;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function isAtLeast($role) {
        return $this->user_role <= $role;
    }

    function roleString() {
        switch($this->user_role) {
            case User::role_admin:
                return 'administrator';
            case User::role_owner:
                return 'hotel owner';
            case User::role_clerk:
                return 'hotel receptionist';
            case User::role_customer:
                return 'customer';
        }
    }
}


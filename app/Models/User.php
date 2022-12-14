<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'id_role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->hasOne(role::class, 'role_id', 'id_role');
    }

    public function aksesMenu()
    {
        return $this->hasMany(aksesMenu::class, 'id_user', 'id');
    }

    public function aksesSitus()
    {
        return $this->hasMany(aksesSitus::class, 'id_user', 'id');
    }
}

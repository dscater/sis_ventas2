<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'tipo',
        'foto',
        'status'
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

    /* =================================================== 
                            RELACIONES
    ====================================================== */
    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'user_id', 'id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'user_id', 'id');
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'user_id', 'id');
    }
}

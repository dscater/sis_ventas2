<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombre',
        'ci',
        'ci_exp',
        'cel',
        "estado"
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cliente_id', 'id');
    }
}

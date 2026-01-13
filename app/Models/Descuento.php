<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $fillable = [
        'nom',
        'descuento',
        'tipo',
        'descripcion'
    ];

    protected $appends = ['txt_tipo', 'simbolo_tipo'];

    public function getTxtTipoAttribute()
    {
        return $this->tipo == 'BS' ? 'Bolivianos' : 'Porcentaje';
    }

    public function getSimboloTipoAttribute()
    {
        return $this->tipo == 'BS' ? 'Bs' : '%';
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'descuento_id', 'id');
    }

    public function promociones()
    {
        return $this->hasMany(Promocion::class, 'descuento_id', 'id');
    }
}

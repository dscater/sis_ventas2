<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $fillable = [
        'producto_id',
        'cantidad',
        'costo',
        'descuento',
        'tipo',
        'total'
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

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id', 'id');
    }
}

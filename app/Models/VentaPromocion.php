<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaPromocion extends Model
{
    protected $table = "venta_promociones";

    protected $fillable = [
        'venta_id',
        'promocion_id'
    ];

    public function ventas()
    {
        return $this->belongsTo(Venta::class, 'venta_id', 'id');
    }

    public function promocion()
    {
        return $this->belongsTo(Promocion::class, 'promocion_id', 'id');
    }
}

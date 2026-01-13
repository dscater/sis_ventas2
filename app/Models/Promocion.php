<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $table = "promociones";

    protected $fillable = [
        'nom',
        'producto_id',
        'inicio',
        'fin',
        'descuento_id',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $append = ["estado"];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }

    public function ventas()
    {
        return $this->hasMany(VentaPromocion::class, 'promocion_id', 'id');
    }

    public function descuento()
    {
        return $this->belongsTo(Descuento::class, 'descuento_id', 'id');
    }

    public function getEstadoAttribute()
    {
        if ($this->fecha_fin >= date("Y-m-d")) {
            return "VIGENTE";
        }
        return "CADUCADO";
    }
}

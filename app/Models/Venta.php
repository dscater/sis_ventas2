<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'empleado_id',
        'cliente',
        'nit',
        'fecha_venta',
        'nro_factura',
        'total',
        'total_final',
        'qr',
        'codigo_control'
    ];

    protected $appends = ["fecha_venta_txt"];

    public function getFechaVentaTxtAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_venta));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id', 'id');
    }

    public function promociones()
    {
        return $this->hasMany(VentaPromocion::class, 'venta_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nom',
        'costo',
        'disponible',
        'ingresos',
        'salidas',
        'descripcion'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id', 'id');
    }

    public function promociones()
    {
        return $this->hasMany(Promocion::class, 'producto_id', 'id');
    }

    // CORREGIR SALIDAS SEGUN VENTAS
    public static function corrigeSalidas()
    {
        $productos = Producto::all();
        foreach ($productos as $producto) {
            $detalles = DetalleVenta::where('producto_id', $producto->id)->get();
            if (count($detalles) > 0) {
                $cantidad = DetalleVenta::where('producto_id', $producto->id)->get()->sum('cantidad');
                $producto->salidas = $cantidad;
            } else {
                $producto->salidas = 0;
            }
            $producto->save();
        }
    }
}

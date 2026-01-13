<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descuento;
use App\Models\Producto;
use App\Models\Promocion;
use App\Models\VentaPromocion;

class PromocionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            $promociones = Promocion::all();
            $promociones_vigentes = Promocion::where("fecha_fin", ">=", date("Y-m-d"))->get();
            return view('promociones.index', compact('promociones', "promociones_vigentes"));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function create(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            $productos = Producto::all();
            $array_productos = [];
            foreach ($productos as $producto) {
                $array_productos[$producto->id] = $producto->nom;
            }

            $descuentos = Descuento::all();
            $array_descuentos[''] = 'Seleccione';
            foreach ($descuentos as $descuento) {
                $array_descuentos[$descuento->id] = $descuento->nom . ' - ' . $descuento->descuento . ' ' . $descuento->simbolo_tipo;
            }
            return view('promociones.create', compact('array_productos', 'array_descuentos'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function store(Request $request)
    {
        $productos = $request->producto_id;
        foreach ($productos as $p) {
            $request["producto_id"] = $p;
            $promocion = Promocion::create(array_map('mb_strtoupper', $request->except("fin")));
            if (!$request->fin) {
                $promocion->fin = null;
                $promocion->save();
            }
        }
        return redirect()->route('promociones.index')->with('bien', 'Promoción registrado con éxito');
    }

    public function edit(Promocion $promocion, Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            $productos = Producto::all();
            $array_productos = [];
            foreach ($productos as $producto) {
                $array_productos[$producto->id] = $producto->nom;
            }

            $descuentos = Descuento::all();
            $array_descuentos[''] = 'Seleccione';
            foreach ($descuentos as $descuento) {
                $array_descuentos[$descuento->id] = $descuento->nom . ' - ' . $descuento->descuento . ' ' . $descuento->simbolo_tipo;
            }
            return view('promociones.edit', compact('promocion', 'array_productos', 'array_descuentos'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function update(Request $request, Promocion $promocion)
    {
        $promocion->update(array_map('mb_strtoupper', $request->except("fin")));
        if (!$request->fin) {
            $promocion->fin = null;
            $promocion->save();
        }
        return redirect()->route('promociones.index')->with('bien', 'Promoción modificado con éxito');
    }

    public function show(Promocion $promocion) {}

    public function destroy(Promocion $promocion)
    {
        $comprueba = VentaPromocion::where('promocion_id', $promocion->id)->get()->first();
        if ($comprueba) {
            return redirect()->route('promociones.index')->with('uso', 'No se puede eliminar el registro porque esta siendo utilizado');
        } else {
            $promocion->delete();
            return redirect()->route('promociones.index')->with('bien', 'Registro elimnado');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descuento;
use App\Models\DetalleVenta;

class DescuentoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            $descuentos = Descuento::all();
            return view('descuentos.index', compact('descuentos'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function create(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            return view('descuentos.create');
        }
        abort(401, 'Acceso no autorizado');
    }

    public function store(Request $request)
    {
        Descuento::create(array_map('mb_strtoupper', $request->all()));
        return redirect()->route('descuentos.index')->with('bien', 'Descuento registrado con éxito');
    }

    public function edit(Descuento $descuento, Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            return view('descuentos.edit', compact('descuento'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function update(Request $request, Descuento $descuento)
    {
        $descuento->update(array_map('mb_strtoupper', $request->all()));
        return redirect()->route('descuentos.index')->with('bien', 'descuento modificado con éxito');
    }

    public function show(Descuento $descuento) {}

    public function destroy(Descuento $descuento)
    {
        $comprueba = DetalleVenta::where('descuento_id', $descuento->id)->get()->first();
        if ($comprueba) {
            return redirect()->route('descuentos.index')->with('uso', 'No se puede eliminar el registro porque esta siendo utilizado');
        } else {
            $descuento->delete();
            return redirect()->route('descuentos.index')->with('bien', 'Registro elimnado');
        }
    }

    public function info(Request $request)
    {
        $descuento = Descuento::find($request->id);
        return response()->JSON($descuento);
    }
}

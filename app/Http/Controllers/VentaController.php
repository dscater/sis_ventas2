<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaPromocion;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\Descuento;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {

            if ($request->ajax()) {
                if (isset($request->per_page) && $request->per_page != '') {
                    $per_page = $request->per_page;
                }

                $ventas = Venta::select("ventas.*")
                    ->leftjoin("clientes", "clientes.id", "=", "ventas.cliente_id")
                    ->leftjoin("users", "users.id", "=", "ventas.user_id")
                    ->leftjoin("empleados", "empleados.user_id", "=", "users.id");

                $search = "";
                if (isset($request->txt_fecha) && $request->txt_fecha != '') {
                    $ventas->where("ventas.fecha_venta", $request->txt_fecha);
                }
                if (isset($request->search) && $request->search != '') {
                    $search = $request->search;
                    $ventas->where(function ($query) use ($search) {
                        $query->where("clientes.nombre", "LIKE", "%$search%")
                            ->orWhere(DB::raw("CONCAT(empleados.nombre,' ',empleados.paterno,' ',empleados.materno)"), "LIKE", "%$search%");
                    });
                }
                $ventas = $ventas->orderBy("created_at", "desc")->paginate($per_page);
                $html = view("ventas.parcial.lista_ventas", compact("ventas"))->render();
                return response()->JSON([
                    "html" => $html
                ]);
            }

            return view('ventas.index');
        }
        abort(401, 'Acceso no autorizado');
    }

    public function create(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            $productos = Producto::all();
            $clientes = Cliente::where('estado', 1)->get();
            $array_clientes[''] = 'Seleccione';
            foreach ($clientes as $cliente) {
                $array_clientes[$cliente->id] = $cliente->nombre;
            }
            return view('ventas.create', compact('productos', 'array_clientes'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $comprueba = Venta::get()->last();
            if ($comprueba) {
                $nro_fac = $comprueba->nro_factura + 1;
            } else {
                $nro_fac = '10001';
            }

            $venta = new Venta();
            $venta->user_id = $request->user()->id;
            $venta->cliente_id = $request->cliente_id;

            $b_cliente = Cliente::find($request->cliente_id);

            $venta->nit = $b_cliente->ci;
            $venta->fecha_venta = $request->fecha_venta;
            $venta->total = $request->total;
            $venta->total_final = $request->total_final;
            $venta->nro_factura = $nro_fac;
            $codigo_qr = 'QR_' . $venta->nit . time() . '.png'; //NOMBRE DE LA IMAGEN QR
            // generando codigo QRinfo_qr
            $info_qr = $venta->nit . '|' . $venta->fecha_venta . '|' . $venta->codigo_control . '|' . $venta->total_final;
            $base_64 = base64_encode(\QrCode::format('png')->size(400)->generate($info_qr));
            // $imagen_codigo_qr = base64_decode($base_64);
            // file_put_contents(public_path() . '/imgs/ventas/qr/' . $codigo_qr, $imagen_codigo_qr);

            // generando codigo de control
            // crear un array
            $array_codigo = [];
            for ($i = 1; $i <= 9; $i++) {
                $array_codigo[] = $i; //agregar los números del 1 al 9
            }
            array_push($array_codigo, 'A', 'B', 'C', 'D', 'E', 'F'); //agregar las letras para poder generar un # hexadecimal
            //generar el código
            $codigo_control = '';
            for ($i = 1; $i <= 10; $i++) {
                $indice = mt_rand(0, 14);
                $codigo_control .= $array_codigo[$indice];
                if ($i % 2 == 0) {
                    $codigo_control .= '-';
                }
            }

            $codigo_control = substr($codigo_control, 0, strlen($codigo_control) - 1); //quitar el ultimo guión

            $venta->qr = $codigo_qr;
            $venta->codigo_control = $codigo_control;
            $venta->save();


            // REGISTRAR LOS PRODUCTOS VENDIDOS - DETALLE VENTA
            $productos = $request->productos;
            $precios = $request->precios;
            $descuentos = $request->descuentos;
            $cantidades = $request->cantidades;
            $totales = $request->totales;
            for ($i = 0; $i < count($productos); $i++) {
                $detalle = new DetalleVenta();
                $detalle->venta_id = $venta->id;
                $detalle->producto_id = $productos[$i];
                $detalle->cantidad = $cantidades[$i];
                $detalle->costo = $precios[$i];
                $descuento = Descuento::find($descuentos[$i]);
                $detalle->descuento_id = $descuento->id;
                $detalle->descuento = $descuento->descuento;
                $detalle->tipo = $descuento->tipo;
                $detalle->total = $totales[$i];
                $detalle->save();

                $producto = Producto::find($productos[$i]);
                // actualizar el stock del producto
                $producto->disponible = $producto->disponible - $cantidades[$i];
                // actualizar salidas
                $producto->salidas = $producto->salidas + $cantidades[$i];
                $producto->save();
            }

            // REGISTRAR LAS PROMOCIONES
            if (isset($request->promociones)) {
                $promociones = $request->promociones;
                for ($i = 0; $i < count($promociones); $i++) {
                    $promocion = new VentaPromocion();
                    $promocion->venta_id = $venta->id;
                    $promocion->promocion_id = $promociones[$i];
                    $promocion->save();
                }
            }

            DB::commit();
            return response()->JSON([
                'msj' => true,
                'ruta' => route('ventas.show', $venta->id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'msj' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Venta $venta, Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            $productos = Producto::all();
            $clientes = Cliente::where('estado', 1)->get();
            $array_clientes[''] = 'Seleccione';
            foreach ($clientes as $cliente) {
                $array_clientes[$cliente->id] = $cliente->nombre;
            }
            return view('ventas.edit', compact('venta', 'productos', 'array_clientes'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function update(Request $request, Venta $venta)
    {
        DB::beginTransaction();
        try {
            $venta->update(array_map('mb_strtoupper', $request->only("total", "total_final", "cliente_id")));

            // REGISTRAR LOS PRODUCTOS VENDIDOS - DETALLE VENTA
            $productos = $request->productos;
            $precios = $request->precios;
            $descuentos = $request->descuentos;
            $cantidades = $request->cantidades;
            $totales = $request->totales;
            if (isset($productos)) {
                for ($i = 0; $i < count($productos); $i++) {
                    $detalle = new DetalleVenta();
                    $detalle->venta_id = $venta->id;
                    $detalle->producto_id = $productos[$i];
                    $detalle->cantidad = $cantidades[$i];
                    $detalle->costo = $precios[$i];
                    $descuento = Descuento::find($descuentos[$i]);
                    $detalle->descuento_id = $descuento->id;
                    $detalle->descuento = $descuento->descuento;
                    $detalle->tipo = $descuento->tipo;
                    $detalle->total = $totales[$i];
                    $detalle->save();

                    $producto = Producto::find($productos[$i]);
                    // actualizar el stock del producto
                    $producto->disponible = $producto->disponible - $cantidades[$i];
                    // actualizar salidas
                    $producto->salidas = $producto->salidas + $cantidades[$i];
                    $producto->save();
                }
            }

            // ELIMINAR LO QUE SE ELIMINO
            $eliminados = $request->eliminados;
            if (isset($eliminados)) {
                foreach ($eliminados as $eliminado) {
                    $d = DetalleVenta::find($eliminado);
                    $producto = $d->producto;
                    $producto->disponible = (float)$producto->disponible + (float)$d->cantidad;
                    $producto->ingresos = (float)$producto->ingresos + (float)$d->cantidad;
                    $producto->salidas = (float)$producto->salidas - (float)$d->cantidad;
                    $producto->save();
                    $d->delete();
                }
            }

            // REGISTRAR LAS PROMOCIONES
            if (isset($request->promociones)) {
                $promociones = $request->promociones;
                for ($i = 0; $i < count($promociones); $i++) {
                    $promocion = new VentaPromocion();
                    $promocion->venta_id = $venta->id;
                    $promocion->promocion_id = $promociones[$i];
                    $promocion->save();
                }
            }
            DB::commit();
            return response()->JSON([
                'msj' => true,
                'ruta' => route('ventas.show', $venta->id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                'msj' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Venta $venta)
    {
        return view('ventas.show', compact('venta'));
    }

    public function destroy(Venta $venta)
    {
        if (Auth::user()->tipo != "ADMINISTRADOR") {
            return redirect()->route('ventas.index')->with('error', 'No tienes permisos para eliminar ventas');
        }

        // ELIMINAR DETALLE DE VENTA Y RESTAURAR STOCK DE PRODUCTOS
        foreach ($venta->detalles as $d) {
            $producto = $d->producto;
            $producto->disponible = (float)$producto->disponible + (float)$d->cantidad;
            $producto->ingresos = (float)$producto->ingresos + (float)$d->cantidad;
            $producto->salidas = (float)$producto->salidas - (float)$d->cantidad;
            $producto->save();
            $d->delete();
        }
        DB::delete("DELETE FROM venta_promociones WHERE venta_id = $venta->id");
        $venta->delete();
        return redirect()->route('ventas.index')->with('bien', 'Registro elimnado');
    }

    public function factura(Venta $venta)
    {
        $date = date('d/m/Y');
        $customPaper = array(0, 0, 360, 600);
        // $pdf = PDF::loadView('ventas.pdf', compact('venta', 'date'))->setPaper($customPaper, 'portrait');
        $pdf = PDF::loadView('ventas.pdf', compact('venta', 'date'));
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 45, $alto - 20, "Pág. {PAGE_NUM}/{PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('Factura.pdf');
    }


    // UTILIZAR ESTA FUNCIÓN DESPUES DE HACER TODOS LOS CAMBIOS EN LA BD (descuento_id => descuento)
    public function reasignarDescuentos()
    {
        $ventas = Venta::all();
        foreach ($ventas as $v) {
            foreach ($v->detalles as $d) {
                $descuento = Descuento::find((int)$d->descuento);
                $d->descuento = $descuento->descuento;
                $d->save();
            }
        }

        return "La reasignación se completó exitosamente";
    }
}

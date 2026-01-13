<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descuento;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Promocion;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            $per_page = 10;

            if ($request->ajax()) {
                if (isset($request->per_page) && $request->per_page != '') {
                    $per_page = $request->per_page;
                }

                $productos = Producto::select("productos.*");

                $search = "";
                if (isset($request->search) && $request->search != '') {
                    $search = $request->search;
                    $productos->where("nom", "LIKE", "%$search%");
                    $productos->orWhere("descripcion", "LIKE", "%$search%");
                }

                $productos = $productos->paginate($per_page);
                $html = view("productos.parcial.lista_productos", compact("productos"))->render();
                return response()->JSON([
                    "html" => $html
                ]);
            }
            return view('productos.index');
        }
        abort(401, 'Acceso no autorizado');
    }

    public function listadoParaVentas(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            $per_page = 10;

            if (isset($request->per_page) && $request->per_page != '') {
                $per_page = $request->per_page;
            }

            $productos = Producto::select("productos.*");

            $search = "";
            if (isset($request->search) && $request->search != '') {
                $search = $request->search;
                $productos->where("nom", "LIKE", "%$search%");
                $productos->orWhere("descripcion", "LIKE", "%$search%");
            }

            $productos = $productos->paginate($per_page);
            $html = view("productos.parcial.lista_ventas", compact("productos"))->render();
            return response()->JSON([
                "html" => $html
            ]);
        }
        return response()->JSON("");
    }

    public function create(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            return view('productos.create');
        }
        abort(401, 'Acceso no autorizado');
    }

    public function store(Request $request)
    {
        $request["disponible"] = 0;
        $request["salidas"] = 0;
        $producto = Producto::create(array_map('mb_strtoupper', $request->all()));
        $producto->ingresos = $request->ingresos ?? 0;
        $producto->disponible = $request->ingresos ?? 0;
        $producto->salidas = 0;
        $producto->save();
        return redirect()->route('productos.index')->with('bien', 'Producto registrado con éxito');
    }

    public function edit(Producto $producto, Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            return view('productos.edit', compact('producto'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function update(Request $request, Producto $producto)
    {
        $comprueba = DetalleVenta::where('producto_id', $producto->id)->get();
        if (count($comprueba) > 0) {
            $producto->update(array_map('mb_strtoupper', $request->except('ingresos')));
            $producto->save();
            return redirect()->route('productos.index')->with('noActualizable', 'El producto que desea actualizar ya tiene ventas realizadas por lo que los cambios solo tendran efecto sobre el nombre y descripción.')
                ->with('bien', 'Producto modificado con éxito');
        } else {
            $producto->update(array_map('mb_strtoupper', $request->all()));
            $producto->disponible = $request->ingresos;
            $producto->save();
            return redirect()->route('productos.index')->with('bien', 'Producto modificado con éxito');
        }
    }

    public function show(Producto $producto) {}

    public function destroy(Producto $producto)
    {
        $comprueba = DetalleVenta::where('producto_id', $producto->id)->get()->first();
        if ($comprueba) {
            return redirect()->route('productos.index')->with('uso', 'No se puede eliminar el registro porque esta siendo utilizado');
        } else {
            $producto->delete();
            return redirect()->route('productos.index')->with('bien', 'Registro elimnado');
        }
    }

    public function ingreso(Request $request, Producto $producto)
    {
        $producto->ingresos = $request->cantidad + $producto->ingresos;
        $producto->disponible = $request->cantidad + $producto->disponible;
        $producto->save();
        return redirect()->route('productos.index')->with('bienIngreso', 'Ingreso del producto ' . $producto->nom . ' registrado con éxito');
    }

    public function infoProducto(Producto $producto, Request $request)
    {
        // COMPROBAR SI EL PRODUCTO TIENE ALGUNA PROMOCIÓN VIGENTE
        $promocion = Promocion::where('producto_id', $producto->id)
            ->where('fecha_fin', '>=', date('Y-m-d'))
            ->get()
            ->first();
        $promocion_id = '';

        $select_descuentos = '<select class="form-control">';
        $descuentos = Descuento::all();
        if (count($descuentos) > 0) {
            foreach ($descuentos as $descuento) {
                // si existe una promocion y ademas cumple la cantidad que se indica para seleccionar el descuento
                if ($promocion && $request->cantidad >= $promocion->inicio) {
                    if ($promocion->fin == null) {
                        if ($descuento->id == $promocion->descuento_id) {
                            $select_descuentos .= '<option value="' . $descuento->id . '" selected>' . number_format($descuento->descuento, 2) . ' ' . $descuento->simbolo_tipo . '</option>';
                        } else {
                            $select_descuentos .= '<option value="' . $descuento->id . '">' . number_format($descuento->descuento, 2) . ' ' . $descuento->simbolo_tipo . '</option>';
                        }
                        $promocion_id = $promocion->id;
                    } else {
                        if ($request->cantidad <= $promocion->fin) {
                            if ($descuento->id == $promocion->descuento_id) {
                                $select_descuentos .= '<option value="' . $descuento->id . '" selected>' . number_format($descuento->descuento, 2) . ' ' . $descuento->simbolo_tipo . '</option>';
                            } else {
                                $select_descuentos .= '<option value="' . $descuento->id . '">' . number_format($descuento->descuento, 2) . ' ' . $descuento->simbolo_tipo . '</option>';
                            }
                            $promocion_id = $promocion->id;
                        } else {
                            if ($descuento->descuento == 0.00) {
                                $select_descuentos .= '<option value="' . $descuento->id . '" selected>' . number_format($descuento->descuento, 2) . ' ' . $descuento->simbolo_tipo . '</option>';
                            } else {
                                $select_descuentos .= '<option value="' . $descuento->id . '">' . number_format($descuento->descuento, 2) . ' ' . $descuento->simbolo_tipo . '</option>';
                            }
                        }
                    }
                } else {
                    if ($descuento->descuento == 0.00) {
                        $select_descuentos .= '<option value="' . $descuento->id . '" selected>' . number_format($descuento->descuento, 2) . ' ' . $descuento->simbolo_tipo . '</option>';
                    } else {
                        $select_descuentos .= '<option value="' . $descuento->id . '">' . number_format($descuento->descuento, 2) . ' ' . $descuento->simbolo_tipo . '</option>';
                    }
                }
            }
        } else {
            $select_descuentos .= '<option value="0" selected disabled>0.00</option>';
        }

        $select_descuentos .= '</select>';

        return response()->JSON([
            'nombre' => $producto->nom,
            'costo' => $producto->costo,
            'select_descuentos' => $select_descuentos,
            'promocion_id' => $promocion_id
        ]);
    }

    public function masVendidos(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            $productos = Producto::all();
            return view('productos.masVendidos', compact("productos"));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function inventario(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            $productos = Producto::all();
            return view('productos.inventario', compact("productos"));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function estadisticas(Request $request)
    {
        Producto::corrigeSalidas();
        $filtro = $request->filtro;
        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;
        $filtro_vendidos = $request->filtro_vendidos;
        $cantidad_filtro = $request->cantidad_filtro;
        $filtro_productos = $request->filtro_productos;

        $asc_desc = "asc";
        if ($filtro_vendidos == "mas") {
            $asc_desc = "desc";
        }

        if (!isset($cantidad_filtro) && !is_numeric($cantidad_filtro)) {
            $cantidad_filtro = 10;
        }

        $productos = [];

        if (isset($filtro_productos)) {
            $not_in = "(";
            for ($i = 0; $i < count($filtro_productos); $i++) {
                $not_in .= $filtro_productos[$i];
                if ($i < count($filtro_productos) - 1) {
                    $not_in .= ",";
                } else {
                    $not_in .= ")";
                }
            }

            $productos = DB::select("SELECT p.*,SUM(dv.cantidad) AS cantidad_vendida FROM productos p 
            LEFT JOIN detalle_ventas dv ON p.id = dv.producto_id 
            WHERE p.id NOT IN $not_in
            GROUP BY p.id 
            ORDER BY cantidad_vendida $asc_desc
            LIMIT 0, $cantidad_filtro");
            if ($filtro != 1) {
                $productos = DB::select("SELECT p.id, p.nom, SUM(dv.cantidad) as cantidad_vendida FROM ventas v
                RIGHT JOIN detalle_ventas dv ON dv.venta_id = v.id
                RIGHT JOIN productos p ON p.id = dv.producto_id
                WHERE p.id NOT IN $not_in
                AND v.fecha_venta BETWEEN '$fecha_ini' AND '$fecha_fin'
                GROUP BY p.id 
                ORDER BY cantidad_vendida $asc_desc
                LIMIT 0, $cantidad_filtro");
            }
        } else {
            $productos = DB::select("SELECT p.*,SUM(dv.cantidad) AS cantidad_vendida FROM productos p 
            LEFT JOIN detalle_ventas dv ON p.id = dv.producto_id 
            GROUP BY p.id 
            ORDER BY cantidad_vendida $asc_desc
            LIMIT 0, $cantidad_filtro");
            if ($filtro != 1) {
                $productos = DB::select("SELECT p.id, p.nom, SUM(dv.cantidad) as cantidad_vendida FROM ventas v
                RIGHT JOIN detalle_ventas dv ON dv.venta_id = v.id
                RIGHT JOIN productos p ON p.id = dv.producto_id
                WHERE v.fecha_venta BETWEEN '$fecha_ini' AND '$fecha_fin'
                GROUP BY p.id 
                ORDER BY cantidad_vendida $asc_desc
                LIMIT 0, $cantidad_filtro");
            }
        }

        $datos = [];
        $array_productos = [];
        foreach ($productos as $producto) {
            $datos[] = ["name" => $producto->nom, "data" => [(int)$producto->cantidad_vendida]];
            $array_productos[] = ["id" => $producto->id, "nom" => $producto->nom];
        }
        return response()->JSON([
            'datos' => $datos,
            "array_productos" => $array_productos
        ]);
    }

    public function getInventario(Request $request)
    {
        $filtro = $request->filtro;
        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;
        $filtro_vendidos = $request->filtro_vendidos;
        $cantidad_filtro = $request->cantidad_filtro;
        $filtro_productos = $request->filtro_productos;
        $precio_total = $request->precio_total;

        if (isset($request->filtro_productos)) {
            $productos = Producto::orderBy("nom", "asc")
                ->whereNotIn("id", $filtro_productos)->get();
        } else {
            $productos = Producto::orderBy("nom", "asc")->get();
        }

        $html = vieW("productos.parcial.tabla_inventario", compact("productos", "precio_total"))->render();

        return response()->JSON($html);
    }

    public function getInventarioPdf(Request $request)
    {
        $filtro = $request->filtro;
        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;
        $filtro_vendidos = $request->filtro_vendidos;
        $cantidad_filtro = $request->cantidad_filtro;
        $filtro_productos = $request->filtro_productos;
        $precio_total = $request->precio_total;

        if (isset($request->filtro_productos)) {
            $productos = Producto::orderBy("nom", "asc")
                ->whereNotIn("id", $filtro_productos)->get();
        } else {
            $productos = Producto::orderBy("nom", "asc")->get();
        }

        $html = vieW("productos.parcial.tabla_inventario", compact("productos", "precio_total"))->render();

        $pdf = PDF::loadView('productos.inventario_pdf', compact('html'));
        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 45, $alto - 20, "Pág. {PAGE_NUM}/{PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('Inventario.pdf');
    }
}

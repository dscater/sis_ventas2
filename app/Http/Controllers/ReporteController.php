<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\User;
use App\Models\Venta;
use PDF;

class ReporteController extends Controller
{
    public function ventas()
    {
        $empleados = User::where("estado", 1)->get();

        $clientes = Cliente::orderBy("nombre", "asc")->get();

        return view("reportes.ventas", compact("empleados", "clientes"));
    }

    public function ventas_pdf(Request $request)
    {
        $date = date('d/m/Y');

        $filtro = $request->filtro;
        $empleado = $request->empleado;
        $cliente = $request->cliente;
        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;

        $ventas = [];
        try {
            if ($filtro == 'todos') {
                $ventas = Venta::orderBy('created_at', 'desc');
            } else {
                switch ($filtro) {
                    case 'empleado':
                        $ventas = Venta::where("user_id", $empleado)
                            ->orderBy('created_at', 'desc');
                        break;
                    case 'cliente':
                        $ventas = Venta::where("cliente_id", $cliente)
                            ->orderBy('created_at', 'desc');
                        break;
                }
            }
            $ventas = $ventas->whereBetween("fecha_venta", [$fecha_ini, $fecha_fin])->get();
        } catch (\Exception $e) {
            $ventas = [];
        }

        if ($request->ajax()) {
            try {
                $html = view("reportes.parcial.ventas", compact("ventas"))->render();
                return response()->JSON($html);
            } catch (\Exception $e) {
                return response()->JSON($e->getMessage());
            }
        }

        $pdf = PDF::loadView('reportes.ventas_pdf', compact('ventas'));

        // ENUMERAR LAS PÁGINAS USANDO CANVAS
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $alto = $canvas->get_height();
        $ancho = $canvas->get_width();
        $canvas->page_text($ancho - 45, $alto - 20, "Pág. {PAGE_NUM}/{PAGE_COUNT}", null, 10, array(0, 0, 0));

        return $pdf->stream('Ventas.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Empresa;
use App\Models\Solicitud;
use App\Models\User;
use Mail;
use Illuminate\Support\Facades\Hash;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            $solicitudes = Solicitud::all();
            return view('solicitudes.index', compact('solicitudes'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function create()
    {
        $empresa = Empresa::first();
        return view('solicitudes.create', compact('empresa'));
    }

    public function store(Request $request)
    {
        $comprueba = Empleado::where('ci', $request->ci)->get()->first();

        if ($comprueba) {
            $solicitud = new Solicitud(array_map('mb_strtoupper', $request->all()));
            $solicitud->user_id = $comprueba->user->id;
            $solicitud->estado = 'PENDIENTE';
            $solicitud->save();
            return redirect()->route('solicitudes.create')->with('bien', 'Tú solicitud se envío correctamente. Te asiganaremos una nueva contraseña y se la enviaremos a su correo electronico.');
        }
        return redirect()->route('solicitudes.create')->with('noExiste', 'No se encontró a ningun empleado con ese número de carnet en nuestro registros.');
    }

    public function asignar(Solicitud $solicitud, Request $request)
    {

        $solicitud->user->password = Hash::make($request->password);
        $solicitud->user->save();

        $empresa = Empresa::first();
        $usuarios['emisor'] = [
            'email' => $empresa->email,
            'empleado' => 'Hola ' . $solicitud->user->empleado->nombre . ' ' . $solicitud->user->empleado->paterno . ' ' . $solicitud->user->empleado->materno . ', te asignamos la siguiente contraseña: ',
            'contrasenia' => $request->password
        ];
        $usuarios['receptor'] = [
            'email' => $solicitud->user->empleado->correo,
        ];

        Mail::send('mail.mensaje', $usuarios['emisor'], function ($msj) use ($usuarios) {
            $msj->from($usuarios['emisor']['email'], 'Administrador');
            $msj->subject('Asignación de nueva contraseña');
            $msj->to($usuarios['receptor']['email']);
        });

        $solicitud->estado = 'ENVIADO';
        $solicitud->save();
        return redirect()->route('solicitudes.index')->with('bien', 'Envío exitoso. Se asignó la nueva contraseñá correctamente.');
    }
}

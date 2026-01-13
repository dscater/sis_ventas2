<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Empleado;
use App\Models\User;

use PDF;
use App\Models\Empresa;

use App\Http\Requests\EmpleadoStoreRequest;
use App\Http\Requests\EmpleadoUpdateRequest;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            $empleados = Empleado::select('users.name as usuario', 'users.tipo', 'empleados.*')
                ->join('users', 'users.id', '=', 'empleados.user_id')
                ->where('users.estado', 1)
                ->orderBy('empleados.nombre', 'asc')
                ->get();
            return view('empleados.index', compact('empleados'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function create(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            return view('empleados.create');
        }
        abort(401, 'Acceso no autorizado');
    }

    public function store(EmpleadoStoreRequest $request)
    {
        $empleadoC = new EmpleadoController();
        $nombre_usuario = $empleadoC->nombreUsuario($request->nombre, $request->paterno);
        $comprueba = User::where('name', $nombre_usuario)->get()->first();
        $cont = 1;
        while ($comprueba) {
            $nombre_usuario = $nombre_usuario . $cont;
            $comprueba = User::where('name', $nombre_usuario)->get()->first();
            $cont++;
        }

        $nuevo_usuario = new User();
        $nuevo_usuario->name = $nombre_usuario;
        $nuevo_usuario->password = Hash::make($request->ci);
        $nuevo_usuario->tipo = $request->tipo;
        $nuevo_usuario->foto = "user_default.png";
        $nuevo_usuario->estado = 1;
        $nuevo_usuario->save();

        // CREANDO LOS DATOS DEL USUARIO
        $datos_empleado = new Empleado(array_map('mb_strtoupper', $request->except('foto', 'correo')));
        $datos_empleado->correo = $request->correo;
        $nom_foto = 'user_default.png';
        if ($request->hasFile('foto')) {
            //obtener el archivo
            $file_foto = $request->file('foto');
            $extension = "." . $file_foto->getClientOriginalExtension();
            $nom_foto = $nombre_usuario . str_replace(' ', '_', $datos_empleado->nombre) . time() . $extension;
            $file_foto->move(public_path() . "/imgs/empleado/", $nom_foto);
            //completar los campos foto y fecha registro del empleadol
        }
        $datos_empleado->foto = $nom_foto;
        $nuevo_usuario->empleado()->save($datos_empleado);

        return redirect()->route('users.index')->with('bien', 'Empleado registrado con éxito');
    }

    public function edit(Empleado $empleado, Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            return view('empleados.edit', compact('empleado'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function update(EmpleadoUpdateRequest $request, Empleado $empleado)
    {
        $empleado->update(array_map('mb_strtoupper', $request->except('foto', 'correo')));
        $empleado->correo = $request->correo;
        $empleado->save();
        if ($request->hasFile('foto')) {
            // ELIMINAR FOTO ANTIGUA
            $foto_antigua = $empleado->foto;
            if ($foto_antigua != 'user_default.png') {
                \File::delete(public_path() . "/imgs/empleado/" . $foto_antigua);
            }
            // SUBIR NUEVA FOTO
            $file_foto = $request->file('foto');
            $extension = "." . $file_foto->getClientOriginalExtension();
            $nom_foto = $empleado->user->name . str_replace(' ', '_', $empleado->nom) . time() . $extension;
            $file_foto->move(public_path() . "/imgs/empleado/", $nom_foto);
            $empleado->foto = $nom_foto;
            $empleado->save();
        }
        return redirect()->route('users.index')->with('bien', 'Registro modificado con éxito');
    }

    public function show(Empleado $empleado) {}

    public function destroy(Empleado $empleado, Request $request)
    {
        $empleado->user->estado = 0;
        $empleado->user->save();
        //redireccionar a la vista index
        return redirect()->route('users.index')->with('bien', 'Registro elimnado');
    }

    public function nombreUsuario($nom, $apep)
    {
        //determinando el nombre de usuario inicial del 1er_nombre+apep+tipoUser
        $nombre_user = substr(mb_strtoupper($nom), 0, 1); //inicial 1er_nombre
        $nombre_user .= mb_strtoupper($apep);

        return $nombre_user;
    }

    public function informacionEmpleado(Empleado $empleado)
    {
        $empresa = Empresa::first();
        $date = date('d/m/Y');
        $pdf = PDF::loadView('empleados.pdf', compact('empleado', 'date', 'empresa'));
        return $pdf->stream('Empelado.pdf');
    }


    /* CONFIGURACIÓN DE CUENTAS */
    // FUNCIONES PARA CONFIGURAR LA CUENTA DEL USUARIO
    public function config_cuenta(User $user)
    {
        $empresa = Empresa::first();
        return view('empleados.config', compact('empresa', 'user'));
    }

    public function cuenta_update(Request $request, User $user)
    {
        if ($request->oldPassword) {
            if (Hash::check($request->oldPassword, $user->password)) {
                if ($request->newPassword == $request->password_confirm) {
                    $user->password = Hash::make($request->newPassword);
                    $user->save();
                    return redirect()->route('users.config', $user->id)->with('password', 'Contraseña actualizada con éxito');
                } else {
                    return redirect()->route('users.config', $user->id)->with('contra_error', 'comfirm');
                }
            } else {
                return redirect()->route('users.config', $user->id)->with('contra_error', 'old_password');
            }
        }
    }

    public function cuenta_update_foto(Request $request, User $user)
    {
        if ($request->hasFile('foto')) {
            $archivo_img = $request->file('foto');
            $extension = '.' . $archivo_img->getClientOriginalExtension();
            $codigo = $user->name;
            $path = public_path() . '/imgs/users/' . $user->foto;
            if ($user->foto != 'user_default.png') {
                \File::delete($path);
            }
            // SUBIENDO FOTO AL SERVIDOR
            if ($user->datosUsuario) {
                $name_foto = $codigo . $user->datosUsuario->nom_u . time() . $extension; //determinar el nombre de la imagen y su extesion
            } else {
                $name_foto = $codigo . time() . $extension; //determinar el nombre de la imagen y su extesion
            }
            $name_foto = str_replace(' ', '_', $name_foto);
            $archivo_img->move(public_path() . '/imgs/users/', $name_foto); //mover el archivo a la carpeta de destino

            $user->foto = $name_foto;
            $user->save();
        }
        return redirect()->route('users.config', $request->user()->id)->with('foto', 'Foto actualizado con éxito');
    }
}

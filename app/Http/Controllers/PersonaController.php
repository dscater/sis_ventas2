<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\Persona;
use App\Models\User;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            $personas = Persona::select('users.name as usuario', 'users.tipo', 'personas.*')
                ->join('users', 'users.id', '=', 'personas.user_id')
                ->whereIn('users.tipo', ['ADMINISTRADOR', 'NUTRICIONISTA'])
                ->where('users.estado', 1)
                ->orderBy('personas.nombre', 'asc')
                ->get();
            return view('usuarios.index', compact('personas'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function create(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            return view('usuarios.create');
        }
        abort(401, 'Acceso no autorizado');
    }

    public function store(Request $request)
    {
        $personaC = new PersonaController();
        $nombre_usuario = $personaC->nombreUsuario($request->nombre, $request->paterno);
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
        $datosUsuario = new Persona(array_map('mb_strtoupper', $request->except('foto', 'correo')));
        $datosUsuario->correo = $request->correo;
        $nom_foto = 'user_default.png';
        if ($request->hasFile('foto')) {
            //obtener el archivo
            $file_foto = $request->file('foto');
            $extension = "." . $file_foto->getClientOriginalExtension();
            $nom_foto = $nombre_usuario . str_replace(' ', '_', $datosUsuario->nombre) . time() . $extension;
            $file_foto->move(public_path() . "/imgs/persona/", $nom_foto);
            //completar los campos foto y fecha registro del personal
        }
        $datosUsuario->foto = $nom_foto;
        $nuevo_usuario->persona()->save($datosUsuario);

        return redirect()->route('users.index')->with('bien', 'Usuario registrado con éxito');
    }

    public function edit(Persona $persona, Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR') {
            return view('usuarios.edit', compact('persona'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function update(Request $request, Persona $persona)
    {
        $persona->update(array_map('mb_strtoupper', $request->except('foto', 'correo')));
        $persona->correo = $request->correo;
        $persona->save();
        if ($request->hasFile('foto')) {
            // ELIMINAR FOTO ANTIGUA
            $foto_antigua = $persona->foto;
            if ($foto_antigua != 'user_default.png') {
                \File::delete(public_path() . "/imgs/persona/" . $foto_antigua);
            }
            // SUBIR NUEVA FOTO
            $file_foto = $request->file('foto');
            $extension = "." . $file_foto->getClientOriginalExtension();
            $nom_foto = $persona->user->name . str_replace(' ', '_', $persona->nom) . time() . $extension;
            $file_foto->move(public_path() . "/imgs/persona/", $nom_foto);
            $persona->foto = $nom_foto;
            $persona->save();
        }
        return redirect()->route('users.index')->with('bien', 'Registro modificado con éxito');
    }

    public function show(Persona $persona) {}

    public function destroy(Persona $persona, Request $request)
    {
        $persona->user->estado = 0;
        $persona->user->save();
        return redirect()->route('users.index')->with('bien', 'Registro elimnado');
    }

    public function nombreUsuario($nom, $apep)
    {
        //determinando el nombre de usuario inicial del 1er_nombre+apep+tipoUser
        $nombre_user = substr(mb_strtoupper($nom), 0, 1); //inicial 1er_nombre
        $nombre_user .= mb_strtoupper($apep);

        return $nombre_user;
    }
}

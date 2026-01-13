<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresa = Empresa::first();
        return view('empresa.index', compact('empresa'));
    }

    public function edit()
    {
        $empresa = Empresa::first();
        return view('empresa.edit', compact('empresa'));
    }

    public function update(Request $request)
    {
        $empresa = Empresa::first();
        $empresa->update(array_map('mb_strtoupper', $request->except('email', 'foto')));
        $empresa->email = $request->email;

        if ($request->hasFile('foto')) {
            // ELIMINAR FOTO ANTIGUA
            $foto_antigua = $empresa->logo;
            if ($foto_antigua != 'user_default.png') {
                \File::delete(public_path() . "/imgs/empresa/" . $foto_antigua);
            }
            // SUBIR NUEVA FOTO
            $file_foto = $request->file('foto');
            $extension = "." . $file_foto->getClientOriginalExtension();
            $nom_foto = str_replace([' ', '"'], ['_', ''], $empresa->name) . time() . $extension;
            $file_foto->move(public_path() . "/imgs/empresa/", $nom_foto);
            $empresa->logo = $nom_foto;
            $empresa->save();
        }

        $empresa->save();
        return redirect()->route('empresa.index')->with('bien', 'Información actualizada con éxito');
    }
}

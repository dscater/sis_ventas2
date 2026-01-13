<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Http\Requests\ClienteStoreRequest;
use App\Http\Requests\ClienteUpdateRequest;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            $clientes = Cliente::all();
            return view('clientes.index', compact('clientes'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function create(Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            return view('clientes.create');
        }
        abort(401, 'Acceso no autorizado');
    }

    public function store(ClienteStoreRequest $request)
    {
        $cliente = Cliente::create(array_map('mb_strtoupper', $request->all()));
        $cliente->estado = 1;
        $cliente->save();
        return redirect()->route('clientes.index')->with('bien', 'Cliente registrado con éxito');
    }

    public function edit(Cliente $cliente, Request $request)
    {
        if ($request->user()->tipo == 'ADMINISTRADOR' || $request->user()->tipo == 'EMPLEADO') {
            return view('clientes.edit', compact('cliente'));
        }
        abort(401, 'Acceso no autorizado');
    }

    public function update(ClienteUpdateRequest $request, Cliente $cliente)
    {
        $cliente->update(array_map('mb_strtoupper', $request->all()));
        return redirect()->route('clientes.index')->with('bien', 'Cliente modificado con éxito');
    }

    public function show(Cliente $cliente) {}

    public function destroy(Cliente $cliente)
    {
        $cliente->estado = 0;
        $cliente->save();
        return redirect()->route('clientes.index')->with('bien', 'Baja registrada correctamente');
    }

    public function habilitar(Cliente $cliente)
    {
        $cliente->estado = 1;
        $cliente->save();
        return redirect()->route('clientes.index')->with('bien', 'Cliente habilitado correctamente');
    }
}

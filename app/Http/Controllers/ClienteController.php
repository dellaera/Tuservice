<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Negocio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index()
    {
        $negocio = $this->negocio();
        $clientes = $negocio->clientes()->latest()->paginate(10);

        return view('clientes.index', compact('negocio', 'clientes'));
    }

    public function create()
    {
        $negocio = $this->negocio();
        $cliente = new Cliente();

        return view('clientes.create', compact('negocio', 'cliente'));
    }

    public function store(Request $request)
    {
        $negocio = $this->negocio();
        $data = $this->validateData($request);

        $negocio->clientes()->create($data);

        return redirect()->route('clientes.index')->with('status', 'Cliente creado correctamente');
    }

    public function edit(Cliente $cliente)
    {
        $negocio = $this->negocio();
        $this->authorizeCliente($cliente, $negocio);

        return view('clientes.edit', compact('negocio', 'cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $negocio = $this->negocio();
        $this->authorizeCliente($cliente, $negocio);

        $data = $this->validateData($request, $cliente->id);
        $cliente->update($data);

        return redirect()->route('clientes.index')->with('status', 'Cliente actualizado');
    }

    public function destroy(Cliente $cliente)
    {
        $negocio = $this->negocio();
        $this->authorizeCliente($cliente, $negocio);

        $cliente->delete();

        return redirect()->route('clientes.index')->with('status', 'Cliente eliminado');
    }

    protected function validateData(Request $request, ?int $clienteId = null): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255', 'unique:clientes,email,'.($clienteId ?? 'null')],
            'notas' => ['nullable', 'string'],
        ]);
    }

    protected function negocio(): Negocio
    {
        $negocio = Negocio::where('usuario_id', Auth::id())->first();

        abort_if(is_null($negocio), 403, 'Debes registrar un negocio para gestionar clientes.');

        return $negocio;
    }

    protected function authorizeCliente(Cliente $cliente, Negocio $negocio): void
    {
        abort_if($cliente->negocio_id !== $negocio->id, 403);
    }
}

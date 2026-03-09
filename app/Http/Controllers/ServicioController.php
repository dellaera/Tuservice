<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    public function index()
    {
        $negocio = $this->negocio();
        $servicios = $negocio->servicios()->latest()->paginate(10);

        return view('servicios.index', compact('negocio', 'servicios'));
    }

    public function create()
    {
        $negocio = $this->negocio();
        $servicio = new Servicio();

        return view('servicios.create', compact('negocio', 'servicio'));
    }

    public function store(Request $request)
    {
        $negocio = $this->negocio();
        $data = $this->validateData($request);

        $negocio->servicios()->create($data);

        return redirect()->route('servicios.index')->with('status', 'Servicio creado correctamente');
    }

    public function edit(Servicio $servicio)
    {
        $negocio = $this->negocio();
        $this->authorizeServicio($servicio, $negocio);

        return view('servicios.edit', compact('negocio', 'servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $negocio = $this->negocio();
        $this->authorizeServicio($servicio, $negocio);

        $data = $this->validateData($request, $servicio->id);
        $servicio->update($data);

        return redirect()->route('servicios.index')->with('status', 'Servicio actualizado');
    }

    public function destroy(Servicio $servicio)
    {
        $negocio = $this->negocio();
        $this->authorizeServicio($servicio, $negocio);

        $servicio->delete();

        return redirect()->route('servicios.index')->with('status', 'Servicio eliminado');
    }

    protected function validateData(Request $request, ?int $servicioId = null): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'duracion_minutos' => ['required', 'integer', 'min:5', 'max:480'],
            'activo' => ['nullable', 'boolean'],
        ]);
    }

    protected function negocio(): Negocio
    {
        $negocio = Negocio::where('usuario_id', Auth::id())->first();

        abort_if(is_null($negocio), 403, 'Debes registrar un negocio para gestionar servicios.');

        return $negocio;
    }

    protected function authorizeServicio(Servicio $servicio, Negocio $negocio): void
    {
        abort_if($servicio->negocio_id !== $negocio->id, 403);
    }
}

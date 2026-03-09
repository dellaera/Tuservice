<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Negocio;
use App\Models\Profesional;
use App\Models\Servicio;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TurnoController extends Controller
{
    public function index(Request $request)
    {
        $negocio = $this->negocio();
        $fecha = $request->input('fecha', now()->toDateString());

        $turnos = $negocio->turnos()
            ->with(['cliente', 'servicio', 'profesional'])
            ->whereDate('fecha', $fecha)
            ->orderBy('hora_inicio')
            ->paginate(15)
            ->appends(['fecha' => $fecha]);

        return view('turnos.index', compact('negocio', 'turnos', 'fecha'));
    }

    public function create()
    {
        $negocio = $this->negocio();
        $data = $this->formData($negocio);
        $turno = new Turno([
            'fecha' => now()->toDateString(),
            'hora_inicio' => '09:00',
            'hora_fin' => '10:00',
        ]);

        return view('turnos.create', compact('negocio', 'turno') + $data);
    }

    public function store(Request $request)
    {
        $negocio = $this->negocio();
        $data = $this->validateData($request, $negocio);

        $negocio->turnos()->create($data);

        return redirect()->route('turnos.index')->with('status', 'Turno creado correctamente');
    }

    public function edit(Turno $turno)
    {
        $negocio = $this->negocio();
        $this->authorizeTurno($turno, $negocio);

        $data = $this->formData($negocio);

        return view('turnos.edit', compact('negocio', 'turno') + $data);
    }

    public function update(Request $request, Turno $turno)
    {
        $negocio = $this->negocio();
        $this->authorizeTurno($turno, $negocio);

        $data = $this->validateData($request, $negocio);
        $turno->update($data);

        return redirect()->route('turnos.index')->with('status', 'Turno actualizado');
    }

    public function destroy(Turno $turno)
    {
        $negocio = $this->negocio();
        $this->authorizeTurno($turno, $negocio);

        $turno->delete();

        return redirect()->route('turnos.index')->with('status', 'Turno eliminado');
    }

    protected function validateData(Request $request, Negocio $negocio): array
    {
        return $request->validate([
            'profesional_id' => ['required', Rule::exists('profesionales', 'id')->where('negocio_id', $negocio->id)],
            'cliente_id' => ['required', Rule::exists('clientes', 'id')->where('negocio_id', $negocio->id)],
            'servicio_id' => ['required', Rule::exists('servicios', 'id')->where('negocio_id', $negocio->id)],
            'fecha' => ['required', 'date'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'estado' => ['required', Rule::in(['pendiente', 'confirmado', 'cancelado', 'completado'])],
            'precio' => ['nullable', 'numeric', 'min:0'],
            'notas' => ['nullable', 'string'],
        ]) + ['negocio_id' => $negocio->id];
    }

    protected function formData(Negocio $negocio): array
    {
        return [
            'profesionales' => Profesional::where('negocio_id', $negocio->id)->where('activo', true)->orderBy('nombre')->get(),
            'clientes' => Cliente::where('negocio_id', $negocio->id)->orderBy('nombre')->get(),
            'servicios' => Servicio::where('negocio_id', $negocio->id)->where('activo', true)->orderBy('nombre')->get(),
            'estados' => ['pendiente', 'confirmado', 'cancelado', 'completado'],
        ];
    }

    protected function negocio(): Negocio
    {
        $negocio = Negocio::where('usuario_id', Auth::id())->first();

        abort_if(is_null($negocio), 403, 'Debes registrar un negocio para gestionar turnos.');

        return $negocio;
    }

    protected function authorizeTurno(Turno $turno, Negocio $negocio): void
    {
        abort_if($turno->negocio_id !== $negocio->id, 403);
    }
}

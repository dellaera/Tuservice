<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Profesional;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfesionalController extends Controller
{
    public function index()
    {
        $negocio = $this->negocio();
        $profesionales = $negocio->profesionales()->with('usuario')->latest()->paginate(10);

        return view('profesionales.index', compact('negocio', 'profesionales'));
    }

    public function create()
    {
        $negocio = $this->negocio();
        $profesional = new Profesional();

        return view('profesionales.create', compact('negocio', 'profesional'));
    }

    public function store(Request $request)
    {
        $negocio = $this->negocio();
        $data = $this->validateData($request);

        $usuario = null;
        if ($data['email']) {
            $usuario = User::create([
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'] ?? '',
                'email' => $data['email'],
                'telefono' => $data['telefono'] ?? null,
                'password' => Hash::make($data['password'] ?? 'password123'),
                'rol' => 'profesional',
            ]);
        }

        $negocio->profesionales()->create([
            'usuario_id' => $usuario?->id,
            'nombre' => $data['nombre'],
            'activo' => $request->boolean('activo', true),
        ]);

        return redirect()->route('profesionales.index')->with('status', 'Profesional creado correctamente');
    }

    public function edit(Profesional $profesional)
    {
        $negocio = $this->negocio();
        $this->authorizeProfesional($profesional, $negocio);

        return view('profesionales.edit', compact('negocio', 'profesional'));
    }

    public function update(Request $request, Profesional $profesional)
    {
        $negocio = $this->negocio();
        $this->authorizeProfesional($profesional, $negocio);

        $data = $this->validateData($request, $profesional->usuario_id);

        if ($profesional->usuario && $data['email']) {
            $profesional->usuario->update([
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'] ?? $profesional->usuario->apellido,
                'email' => $data['email'],
                'telefono' => $data['telefono'] ?? $profesional->usuario->telefono,
            ]);
        }

        $profesional->update([
            'nombre' => $data['nombre'],
            'activo' => $request->boolean('activo', true),
        ]);

        return redirect()->route('profesionales.index')->with('status', 'Profesional actualizado');
    }

    public function destroy(Profesional $profesional)
    {
        $negocio = $this->negocio();
        $this->authorizeProfesional($profesional, $negocio);

        if ($profesional->usuario) {
            $profesional->usuario->delete();
        }

        $profesional->delete();

        return redirect()->route('profesionales.index')->with('status', 'Profesional eliminado');
    }

    protected function validateData(Request $request, ?int $usuarioId = null): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,'.($usuarioId ?? 'null')],
            'password' => ['nullable', 'string', 'min:6'],
        ]);
    }

    protected function negocio(): Negocio
    {
        $negocio = Negocio::where('usuario_id', Auth::id())->first();

        abort_if(is_null($negocio), 403, 'Debes registrar un negocio para gestionar profesionales.');

        return $negocio;
    }

    protected function authorizeProfesional(Profesional $profesional, Negocio $negocio): void
    {
        abort_if($profesional->negocio_id !== $negocio->id, 403);
    }
}

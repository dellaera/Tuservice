@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-1">Profesionales</h1>
        <p class="text-muted mb-0">Administrá tu equipo de trabajo.</p>
    </div>
    <a href="{{ route('profesionales.create') }}" class="btn btn-primary">Nuevo profesional</a>
</div>

@if ($profesionales->isEmpty())
    <div class="alert alert-light border">
        Aún no cargaste profesionales. Creá el primero para asignarle turnos.
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profesionales as $profesional)
                        <tr>
                            <td>{{ $profesional->nombre }}</td>
                            <td>{{ $profesional->usuario->email ?? '—' }}</td>
                            <td>{{ $profesional->usuario->telefono ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $profesional->activo ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ $profesional->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('profesionales.edit', $profesional) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="{{ route('profesionales.destroy', $profesional) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este profesional?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $profesionales->links() }}
        </div>
    </div>
@endif
@endsection

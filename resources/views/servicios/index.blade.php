@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-1">Servicios</h1>
        <p class="text-muted mb-0">Gestioná la oferta de tu negocio.</p>
    </div>
    <a href="{{ route('servicios.create') }}" class="btn btn-primary">Nuevo servicio</a>
</div>

@if ($servicios->isEmpty())
    <div class="alert alert-light border">
        Todavía no cargaste servicios. Agregá el primero para que tus clientes puedan reservar.
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Duración</th>
                        <th>Precio (ARS)</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->duracion_minutos }} min</td>
                            <td>$ {{ number_format($servicio->precio, 2, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $servicio->activo ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="{{ route('servicios.destroy', $servicio) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este servicio?');">
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
            {{ $servicios->links() }}
        </div>
    </div>
@endif
@endsection

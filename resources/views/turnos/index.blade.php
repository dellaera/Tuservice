@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
    <div>
        <h1 class="h4 mb-1">Agenda</h1>
        <p class="text-muted mb-0">Turnos del día {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</p>
    </div>
    <form class="d-flex gap-2" method="GET" action="{{ route('turnos.index') }}">
        <input type="date" name="fecha" value="{{ $fecha }}" class="form-control" style="max-width: 200px;">
        <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
        <a href="{{ route('turnos.create') }}" class="btn btn-primary">Nuevo turno</a>
    </form>
</div>

@if ($turnos->isEmpty())
    <div class="alert alert-light border">
        No hay turnos para la fecha seleccionada. Creá uno nuevo para comenzar.
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Hora</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Profesional</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($turnos as $turno)
                        <tr>
                            <td>{{ $turno->hora_inicio }} - {{ $turno->hora_fin }}</td>
                            <td>{{ $turno->cliente->nombre ?? '—' }}</td>
                            <td>{{ $turno->servicio->nombre ?? '—' }}</td>
                            <td>{{ $turno->profesional->nombre ?? '—' }}</td>
                            <td>
                                <span class="badge text-bg-light text-capitalize">{{ $turno->estado }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('turnos.edit', $turno) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="{{ route('turnos.destroy', $turno) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este turno?');">
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
            {{ $turnos->links() }}
        </div>
    </div>
@endif
@endsection

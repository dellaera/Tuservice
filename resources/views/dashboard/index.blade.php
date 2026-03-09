@extends('layouts.app')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <h1 class="h4 mb-1">Hola, {{ $user->nombre }} {{ $user->apellido }}</h1>
                    <p class="text-muted mb-0">{{ $negocio?->nombre ?? 'Aún no configuraste tu negocio' }}</p>
                </div>
                <div class="text-md-end mt-3 mt-md-0">
                    <span class="badge text-bg-primary">Plan activo</span>
                    <p class="mb-0 text-muted">{{ $negocio?->suscripciones()->latest()->first()?->plan ?? 'Trial' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <p class="text-muted mb-1">Turnos totales</p>
                        <h2 class="h4 mb-0">{{ $stats['total_turnos'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <p class="text-muted mb-1">Turnos hoy</p>
                        <h2 class="h4 mb-0">{{ $stats['turnos_hoy'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <p class="text-muted mb-1">Clientes</p>
                        <h2 class="h4 mb-0">{{ $stats['clientes'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <p class="text-muted mb-1">Profesionales</p>
                        <h2 class="h4 mb-0">{{ $stats['profesionales'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">Próximos turnos</h2>
                <a href="#" class="btn btn-sm btn-outline-primary">Ver agenda</a>
            </div>
            <div class="card-body">
                @if ($proximosTurnos->isEmpty())
                    <p class="text-muted mb-0">No hay turnos próximos. Empieza creando turnos desde la agenda.</p>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Cliente</th>
                                    <th>Servicio</th>
                                    <th>Profesional</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proximosTurnos as $turno)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }}</td>
                                        <td>{{ $turno->hora_inicio }} - {{ $turno->hora_fin }}</td>
                                        <td>{{ $turno->cliente->nombre ?? '-' }}</td>
                                        <td>{{ $turno->servicio->nombre ?? '-' }}</td>
                                        <td>{{ $turno->profesional->nombre ?? '-' }}</td>
                                        <td>
                                            <span class="badge text-bg-light text-capitalize">{{ $turno->estado }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

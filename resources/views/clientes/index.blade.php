@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-1">Clientes</h1>
        <p class="text-muted mb-0">Listado de clientes de tu negocio.</p>
    </div>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">Nuevo cliente</a>
</div>

@if ($clientes->isEmpty())
    <div class="alert alert-light border">
        Todavía no registraste clientes. Cargá el primero para empezar a reservar turnos.
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Notas</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->telefono ?? '—' }}</td>
                            <td>{{ $cliente->email ?? '—' }}</td>
                            <td>{{ Str::limit($cliente->notas, 40) }}</td>
                            <td class="text-end">
                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este cliente?');">
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
            {{ $clientes->links() }}
        </div>
    </div>
@endif
@endsection

@csrf

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Fecha</label>
        <input type="date" name="fecha" value="{{ old('fecha', $turno->fecha?->format('Y-m-d')) }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Hora inicio</label>
        <input type="time" name="hora_inicio" value="{{ old('hora_inicio', $turno->hora_inicio) }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Hora fin</label>
        <input type="time" name="hora_fin" value="{{ old('hora_fin', $turno->hora_fin) }}" class="form-control" required>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-4">
        <label class="form-label">Profesional</label>
        <select name="profesional_id" class="form-select" required>
            <option value="">Seleccionar</option>
            @foreach ($profesionales as $profesional)
                <option value="{{ $profesional->id }}" {{ old('profesional_id', $turno->profesional_id) == $profesional->id ? 'selected' : '' }}>
                    {{ $profesional->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Cliente</label>
        <select name="cliente_id" class="form-select" required>
            <option value="">Seleccionar</option>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('cliente_id', $turno->cliente_id) == $cliente->id ? 'selected' : '' }}>
                    {{ $cliente->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Servicio</label>
        <select name="servicio_id" class="form-select" required>
            <option value="">Seleccionar</option>
            @foreach ($servicios as $servicio)
                <option value="{{ $servicio->id }}" {{ old('servicio_id', $turno->servicio_id) == $servicio->id ? 'selected' : '' }}>
                    {{ $servicio->nombre }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-4">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select" required>
            @foreach ($estados as $estado)
                <option value="{{ $estado }}" {{ old('estado', $turno->estado) == $estado ? 'selected' : '' }}>
                    {{ ucfirst($estado) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Precio (pesos)</label>
        <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio', $turno->precio) }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Notas</label>
        <input type="text" name="notas" value="{{ old('notas', $turno->notas) }}" class="form-control">
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('turnos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar</button>
</div>

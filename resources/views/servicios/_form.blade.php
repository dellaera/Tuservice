@csrf

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre) }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" rows="3" class="form-control">{{ old('descripcion', $servicio->descripcion) }}</textarea>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Precio (pesos)</label>
        <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio', $servicio->precio) }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Duración (minutos)</label>
        <input type="number" min="5" max="480" name="duracion_minutos" value="{{ old('duracion_minutos', $servicio->duracion_minutos) }}" class="form-control" required>
    </div>
</div>

<div class="form-check form-switch mt-3">
    <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo" {{ old('activo', $servicio->activo) ? 'checked' : '' }}>
    <label class="form-check-label" for="activo">Servicio activo</label>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('servicios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar</button>
</div>

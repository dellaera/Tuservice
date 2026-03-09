@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="form-control">
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-6">
        <label class="form-label">Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email', $cliente->email) }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Notas</label>
        <input type="text" name="notas" value="{{ old('notas', $cliente->notas) }}" class="form-control">
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar</button>
</div>

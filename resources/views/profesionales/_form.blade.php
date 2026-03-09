@csrf

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $profesional->nombre) }}" class="form-control" required>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Apellido</label>
        <input type="text" name="apellido" value="{{ old('apellido', $profesional->usuario->apellido ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', $profesional->usuario->telefono ?? '') }}" class="form-control">
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-6">
        <label class="form-label">Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email', $profesional->usuario->email ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control" placeholder="(solo si querés enviar acceso nuevo)">
    </div>
</div>

<div class="form-check form-switch mt-3">
    <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo" {{ old('activo', $profesional->activo ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="activo">Profesional activo</label>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('profesionales.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar</button>
</div>

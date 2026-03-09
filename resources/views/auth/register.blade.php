@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-sm auth-card">
            <div class="card-body p-4">
                <h1 class="h4 mb-4 text-center">Crear cuenta para tu negocio</h1>

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido</label>
                            <input type="text" name="apellido" value="{{ old('apellido') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Nombre del negocio</label>
                            <input type="text" name="negocio_nombre" value="{{ old('negocio_nombre') }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Teléfono del negocio</label>
                            <input type="text" name="negocio_telefono" value="{{ old('negocio_telefono') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ciudad</label>
                            <input type="text" name="ciudad" value="{{ old('ciudad') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rubro</label>
                            <select name="rubro_id" class="form-select" required>
                                <option value="">Seleccionar rubro</option>
                                @foreach ($rubros as $rubro)
                                    <option value="{{ $rubro->id }}" {{ old('rubro_id') == $rubro->id ? 'selected' : '' }}>
                                        {{ $rubro->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Plan</label>
                            <div class="row g-3">
                                @foreach ($planes as $plan)
                                    <div class="col-md-4">
                                        <div class="form-check border rounded p-3 h-100">
                                            <input class="form-check-input" type="radio" name="plan" value="{{ $plan->slug }}" id="plan_{{ $plan->slug }}" {{ old('plan', 'trial') === $plan->slug ? 'checked' : '' }}>
                                            <label class="form-check-label" for="plan_{{ $plan->slug }}">
                                                <strong>{{ $plan->nombre }}</strong>
                                                <br>
                                                @if ($plan->precio_mensual > 0)
                                                    <span class="text-muted">USD {{ number_format($plan->precio_mensual, 2) }}/mes</span>
                                                @else
                                                    <span class="text-muted">Gratis</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terminos" id="terminos" required>
                                <label class="form-check-label" for="terminos">
                                    Acepto los términos y condiciones
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Crear cuenta</button>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">Ya tengo una cuenta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

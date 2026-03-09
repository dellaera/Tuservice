@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-4">Editar turno</h1>
                <form action="{{ route('turnos.update', $turno) }}" method="POST">
                    @method('PUT')
                    @include('turnos._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

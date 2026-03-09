@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-4">Nuevo cliente</h1>
                <form action="{{ route('clientes.store') }}" method="POST">
                    @include('clientes._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

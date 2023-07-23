@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <p class="display-6">Test Práctico: Evaluación de Usabilidad y Código Comercial -> Performance Comercial</p>
                    <br>
                    <p class="h3">Fabian Ortiz Maestre</p>
                    <br>
                    <a class="text-decoration-none text-primary" href="comercial">Performance Comercial</a>
                    <br>
                    <br>
                    <a class="btn btn-primary mb-3" href="https://github.com/fmaestre98/evaluacion-practica-agence">Github Project</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
           
            <div class="col-md-10">
                <livewire:show-comercial-data :cao_usuarios="$cao_usuarios" />
            </div>
        </div>
    </div>
</div>
@endsection
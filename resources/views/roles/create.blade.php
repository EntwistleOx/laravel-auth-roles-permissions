@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Crear Rol
                </div>
                <div class="card-body">

                    @include('common.errors')

                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        @include ('roles.form', [
                            'role' => new Caffeinated\Shinobi\Models\Role
                        ])

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

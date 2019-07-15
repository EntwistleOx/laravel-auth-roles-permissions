@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Crear Permiso
                </div>
                <div class="card-body">

                    @include('common.errors')

                    <form method="POST" action="{{ route('permissions.store') }}">
                        @csrf
                        @include ('permissions.form', [
                            'permission' => new Caffeinated\Shinobi\Models\Permission
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

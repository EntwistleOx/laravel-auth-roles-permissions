@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Editar Rol
                </div>
                <div class="card-body">

                    @include('common.errors')
                    @include('common.confirmation')

                    <form method="POST" action="{{ route('roles.update',$role->id) }}">
                        @csrf
                        @method('PATCH')

                        @include ('roles.form')

                        <hr>

                        <div class="mb-2">
                            <b>Asignar permisos</b>
                        </div>

                        @foreach ($permissions as $permission)
                        <div class="form-group form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="permission[]"
                                value="{{ $permission->slug }}"
                                @foreach($rolePermissions as $index)
                                {{ ($index->name == $permission->name) ? 'checked' : '' }}
                                @endforeach
                            >
                            <label class="form-check-label">{{ $permission->name }}</label>
                        </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

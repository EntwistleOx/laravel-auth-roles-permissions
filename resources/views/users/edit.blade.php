@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Editar Usuario
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update',$user->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" class="form-control" aria-describedby="name" placeholder="Nombre" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Usuario</label>
                            <input type="text" name="username" class="form-control" aria-describedby="username" placeholder="Usuario" value="{{ $user->username }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="Contraseña" value="{{ $user->password }}">
                        </div>

                        <hr>

                        <div class="mb-2">
                            <b>Asignar roles</b>
                        </div>

                        @foreach ($roles as $role)
                        <div class="form-group form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="role[]"
                                value="{{ $role->slug }}"
                                @foreach($userRoles as $index)
                                {{ ($index->name == $role->name) ? 'checked' : '' }}
                                @endforeach
                            >
                            <label class="form-check-label">{{ $role->name }}</label>
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

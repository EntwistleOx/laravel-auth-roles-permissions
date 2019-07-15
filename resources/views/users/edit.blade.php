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

                    @include('common.errors')
                    @include('common.confirmation')

                    <div class="mb-2">
                        <b>Informacion del usuario</b>
                    </div>

                    <form method="POST" action="{{ route('users.update',$user->id) }}">
                        @csrf
                        @method('PATCH')

                        @include ('users.form')

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

                    <hr>

                    <div class="mb-2">
                        <b>Cambiar password</b>
                    </div>

                    <form action="">
                        <div class="form-group">
                            <label for="name">Nuevo password</label>
                            <input type="password" name="password" class="form-control" aria-describedby="name" placeholder="Password" required >
                        </div>
                        <div class="form-group">
                            <label for="name">Confirmar password</label>
                            <input type="password" name="passwordConfirm" class="form-control" aria-describedby="username" placeholder="Confirmar password" required >
                        </div>
                        <button type="submit" class="btn btn-danger">Cambiar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

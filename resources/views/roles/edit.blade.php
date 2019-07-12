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
                    <form method="POST" action="{{ route('roles.update',$role->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" class="form-control" aria-describedby="name" placeholder="Nombre" value="{{ $role->name }}">
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" class="form-control" aria-describedby="slug" placeholder="Slug" value="{{ $role->slug }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control" aria-describedby="description" placeholder="Description" value="{{ $role->description }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Acceso</label>
                            <select class="custom-select mr-sm-2" name="special">
                                    <option value="1" selected>Elije...</option>
                                    <option value="all-access" {{ ( $role->special == 'all-access') ? 'selected' : '' }}>Total</option>
                                    <option value="no-access" {{ ( $role->special == 'no-access') ? 'selected' : '' }}>Denegado</option>
                            </select>
                        </div>

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

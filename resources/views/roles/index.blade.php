@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Roles
                    @can('roles.create')
                    <a href="{{route('roles.create')}}" class="btn btn-primary">Crear</a>
                    @endcan
                </div>

                <div class="card-body">

                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Slug</th>
                                    <th>Descripcion</th>
                                    <th>Acceso especial</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->slug }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>{{ $role->special }}</td>
                                    <td class="d-flex justify-content-around">
                                        @can('roles.edit')
                                        <a class="btn btn-success" href="{{route('roles.edit',$role->id)}}">Editar</a>
                                        @endcan

                                        @can('roles.destroy')
                                        <form action="{{route('roles.destroy',$role->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn bg-danger text-white" type="submit">Eliminar</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $roles->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Permisos
                    @can('permissions.create')
                    <a href="{{route('permissions.create')}}" class="btn btn-primary">Crear</a>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->slug }}</td>
                                    <td>{{ $permission->description }}</td>
                                    <td class="d-flex justify-content-around">
                                        @can('permissions.edit')
                                            <a class="btn btn-success" href="{{route('permissions.edit',$permission->id)}}">Editar</a>
                                        @endcan

                                        @can('permissions.destroy')
                                        <form action="{{route('permissions.destroy',$permission->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger text-white" type="submit">Eliminar</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $permissions->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

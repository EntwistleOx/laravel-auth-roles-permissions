@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Usuarios
                    @can('users.create')
                        <a href="{{route('users.create')}}" class="btn btn-primary">Crear</a>
                    @endcan
                </div>
                <div class="card-body">

                    @include('common.confirmation')

                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Username</th>
                                    <th>Rol</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        @foreach($user->roles as $roles => $name)
                                            <span class="badge badge-warning">{{  $name->name  }}</span>
                                        @endforeach
                                    </td>
                                    <td class="d-flex justify-content-around">
                                        @can('users.edit')
                                        <a class="btn btn-success" href="{{route('users.edit',$user->id)}}">Editar</a>

                                        @endcan

                                        @can('users.destroy')
                                        <form action="{{route('users.destroy',$user->id)}}" method="post">
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
                        {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

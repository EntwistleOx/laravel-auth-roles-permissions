@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Permisos<small>it all starts here</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            @include('common.confirmation', ['flag' => 'status'])
            <div class="box-header with-border">
            <h3 class="box-title">Listado de Permisos</h3>

            <div class="box-tools pull-right">
                @can('permissions.create')
                    <a href="{{route('permissions.create')}}" class="btn btn-primary btn-sm">Crear</a>
                @endcan
            </div>
            </div>
            <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th>Descripcion</th>
                        <th></th>
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
                                <a class="btn btn-success btn-xs" href="{{route('permissions.edit',$permission->id)}}">Editar</a>
                            @endcan
                        </td>
                        <td>
                            @can('permissions.destroy')
                                <form action="{{route('permissions.destroy',$permission->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('¿Desea eliminar el registro?')">Eliminar</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ $permissions->links() }}
        </div>
        <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->

@endsection

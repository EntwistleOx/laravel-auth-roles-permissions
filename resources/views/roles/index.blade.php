@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Roles<small>it all starts here</small></h1>
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
              @include('common.confirmation')
          <div class="box-header with-border">
            <h3 class="box-title">Listado de Roles</h3>

            <div class="box-tools pull-right">
                <a href="{{route('roles.create')}}" class="btn btn-primary btn-sm">Crear</a>
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
                            <th>Acceso especial</th>
                            <th></th>
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
                            <td><span class="label label-warning">{{ $role->special }}</span></td>
                            <td>
                                <a class="btn btn-success btn-xs" href="{{route('roles.edit',$role->id)}}">Editar</a>
                            </td>
                            <td>
                            <form action="{{route('roles.destroy',$role->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('¿Desea eliminar el registro?')">Eliminar</button>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
              {{ $roles->links() }}
          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
@endsection

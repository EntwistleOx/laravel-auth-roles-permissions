@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Usuarios<small>it all starts here</small></h1>
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
        @include('common.errors', ['bag' => 'error'])
        <div class="box-header with-border">
          <h3 class="box-title">Lista de Usuarios</h3>

          <div class="box-tools pull-right">
              @can('users.create')
                <a href="{{route('users.create')}}" class="btn btn-primary btn-sm">Crear</a>
              @endcan
          </div>
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Username</th>
                        <th>Rol</th>
                        <th></th>
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
                                <span class="label label-warning">{{  $name->name  }}</span>
                            @endforeach
                        </td>
                        <td>
                            @can('users.edit')
                                <a class="btn btn-success btn-xs" href="{{route('users.edit',$user->id)}}">Editar</a>
                            @endcan
                        </td>
                        <td>
                            @can('users.destroy')
                                <form action="{{route('users.destroy',$user->id)}}" method="post">
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
            {{ $users->links() }}
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection



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
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Editar Informacion del usuario</h3>
        </div>
        <!-- /.box-header -->
        <form method="POST" action="{{ route('users.update',$user->id) }}">
        <div class="box-body">
            @include('common.errors')
            @include('common.confirmation')

            @csrf
            @method('PATCH')
            @include ('users.form')
        </div>
        <!-- /.box-body -->

        <div class="box-header">
            <h3 class="box-title">Asignar Roles</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @foreach ($roles as $role)
            <div class="checkbox">
                <label class="check">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="role[]"
                        value="{{ $role->slug }}"
                        @foreach($userRoles as $index)
                        {{ ($index->name == $role->name) ? 'checked' : '' }}
                        @endforeach
                    >
                    {{ $role->name }}
                </label>
            </div>
            @endforeach
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        <!-- box-footer -->
        </form>
    </div>
    <!-- /.box -->

    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Cambiar Contraseña</h3>
        </div>
        <!-- /.box-header -->

        <form method="POST" action="{{ route('users.password', $user->id) }}">
            <div class="box-body">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="password">Nuevo password</label>
                    <input type="password" name="password" class="form-control" aria-describedby="password" placeholder="Password" required >
                </div>
                <div class="form-group">
                    <label for="passwordConfirm">Confirmar password</label>
                    <input type="password" name="password_confirmation" class="form-control" aria-describedby="password_confirmation " placeholder="Confirmar password" required >
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-danger">Cambiar</button>
            </div>
            <!-- box-footer -->
        </form>
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

@endsection

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
        <div class="box-header with-border">
            <h3 class="box-title">Crear un Usuarios</h3>
        </div>

        @include('common.errors')

        <form method="POST" action="{{ route('users.store') }}">
            <div class="box-body">
            @csrf

            @include ('users.form', [
                'user' => new App\User
            ])
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            <!-- /.box-footer-->
        </form>
        <!-- /.form-->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->

@endsection


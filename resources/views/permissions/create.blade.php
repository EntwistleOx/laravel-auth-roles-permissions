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
            <div class="box-header with-border">
                <h3 class="box-title">Crear Permisos</h3>
            </div>

            <form method="POST" action="{{ route('permissions.store') }}">
                <div class="box-body">
                    @include('common.errors')
                    @csrf

                    @include ('permissions.form', [
                        'permission' => new Caffeinated\Shinobi\Models\Permission
                    ])
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

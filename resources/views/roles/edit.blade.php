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
        <div class="box-header with-border">
            <h3 class="box-title">Editar Roles</h3>
        </div>

        <form method="POST" action="{{ route('roles.update',$role->id) }}">
            <div class="box-body">

            @include('common.errors')
            @include('common.confirmation', ['flag' => 'status'])

            @csrf
            @method('PATCH')

            @include ('roles.form')
            </div>
            <!-- /.box-body -->

            <div class="box-header">
                <h3 class="box-title">Asignar Permisos</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
                @foreach ($permissions as $permission)
                        <div class="checkbox">
                            <label class="form-check-label">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    name="permission[]"
                                    value="{{ $permission->slug }}"
                                    @foreach($rolePermissions as $index)
                                    {{ ($index->name == $permission->name) ? 'checked' : '' }}
                                    @endforeach
                                >
                                {{ $permission->name }}
                            </label>
                        </div>
                @endforeach
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

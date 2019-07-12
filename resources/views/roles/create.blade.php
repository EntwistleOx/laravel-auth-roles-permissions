@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Crear Rol
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" class="form-control" aria-describedby="name" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" class="form-control" aria-describedby="slug" placeholder="Slug">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control" aria-describedby="description" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <label for="name">Acceso</label>
                            <select class="custom-select mr-sm-2" name="special">
                                    <option selected>Elije...</option>
                                    <option value="all-access">Total</option>
                                    <option value="no-access">Denegado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

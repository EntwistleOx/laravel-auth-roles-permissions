@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Editar Permiso
                </div>
                <div class="card-body">

                    @include('common.errors')
                    @include('common.confirmation')

                    <form method="POST" action="{{ route('permissions.update',$permission->id) }}">
                        @csrf
                        @method('PATCH')
                        @include ('permissions.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

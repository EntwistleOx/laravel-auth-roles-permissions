@if ($errors->{ $bag ?? 'default' }->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        @foreach ($errors->{ $bag ?? 'default' }->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

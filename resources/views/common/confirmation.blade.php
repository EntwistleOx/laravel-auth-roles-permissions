@if (session('status'))
    <div class="alert alert-success alert-dismissible mt-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Confirmacion!</h4>
        {{ session('status') }}
    </div>
@endif

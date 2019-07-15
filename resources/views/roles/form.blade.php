<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" name="name" class="form-control" aria-describedby="name" placeholder="Nombre" value="{{ $role->name }}" >
</div>
<div class="form-group">
    <label for="slug">Slug</label>
    <input type="text" name="slug" class="form-control" aria-describedby="slug" placeholder="Slug" value="{{ $role->slug }}" >
</div>
<div class="form-group">
    <label for="description">Description</label>
    <input type="text" name="description" class="form-control" aria-describedby="description" placeholder="Description" value="{{ $role->description }}" >
</div>
<div class="form-group">
    <label for="name">Acceso</label>
    <select class="custom-select mr-sm-2" name="special">
            <option value="" selected>Elije...</option>
            <option value="all-access" {{ ( $role->special == 'all-access') ? 'selected' : '' }}>Total</option>
            <option value="no-access" {{ ( $role->special == 'no-access') ? 'selected' : '' }}>Denegado</option>
    </select>
</div>

<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" name="name" class="form-control" aria-describedby="name" placeholder="Nombre" value="{{ $permission->name }}" required>
</div>
<div class="form-group">
    <label for="slug">Slug</label>
    <input type="text" name="slug" class="form-control" aria-describedby="slug" placeholder="Slug" value="{{ $permission->slug }}" required>
</div>
<div class="form-group">
    <label for="description">Description</label>
    <input type="text" name="description" class="form-control" aria-describedby="description" placeholder="Description" value="{{ $permission->description }}" required>
</div>
